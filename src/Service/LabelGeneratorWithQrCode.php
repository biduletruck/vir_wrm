<?php


namespace App\Service;


use App\Entity\Orders;
use Symfony\Component\HttpFoundation\Response;


class LabelGeneratorWithQrCode extends \TCPDF
{
    private $pdf;

    protected $title;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return LabelGeneratorWithQrCode
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);

        $this->pdf = new \TCPDF();
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->SetAutoPageBreak(TRUE, 0);
    }


    public function newPage()
    {
        $this->pdf->AddPage();
        $this->header();
    }


    public function header()
    {
        $this->pdf->Image( './build/logo.png',10 ,10 ,'', 20);
        $this->pdf->SetFont('helvetica', 'B', 20);
        $this->pdf->cell(190, 20, $this->getTitle(),0, 1 ,"C");
    }

    public function footer()
    {
        $this->pdf->SetY(-15);
    }

    /**
     * @param string $data
     * @return Response
     */
    public function LabelWithQrCode(string $data): Response
    {
        $this->pdf->write2DBarcode( $data, 'QRCODE,H', 10, 100, 190, 190);
        return new Response($this->pdf->Output(), 200, array('Content-Type' => 'application/pdf'));
    }


    /**
     * @param Orders $orders
     * @return Response
     */
    public function createLabelsWithQrCode(Orders $orders): Response
    {
        for ($i = 1; $i <= $orders->getLabels(); $i ++)
        {
            $localNumber= $orders->getVirLocalNumber() . "-" . $i . "/";
            $this->setTitle($orders->getOrderingNumber());
            $this->newPage();
            $this->pdf->Cell(190, 20, $orders->getVirLocalNumber(), 0,1 , 'C');
            $this->pdf->Cell(190, 20, $orders->getCustomerName(), 0,1 , 'C');
            $this->pdf->Cell(190, 20, $localNumber . $orders->getLabels(), 0,1 , 'C');
            $this->pdf->write2DBarcode( $localNumber, 'QRCODE,H', 10, 100, 190, 190);
        }
        return new Response($this->pdf->Output(), 200, array('Content-Type' => 'application/pdf'));
    }

}