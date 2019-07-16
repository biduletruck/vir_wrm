<?php


namespace App\Controller;


use App\Service\LabelGeneratorWithQrCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route(path="/", name="index")
     * @return Response
     */
    public function index():Response
    {

        $data = ['gen-123456789-1/4','gen-123456789-2/4','gen-123456789-3/4','gen-123456789-4/4',];


        $pdf = new LabelGeneratorWithQrCode();
       // $pdf->LabelWithQrCode('yann clement');
        $pdf->createLabelsWithQrCode(count($data), $data);


        //return $this->render('home.html.twig');
    }
}