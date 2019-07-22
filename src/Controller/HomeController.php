<?php


namespace App\Controller;

use App\Repository\LocationsRepository;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route(path="/", name="index")
     * @return Response
     */
    public function index(LocationsRepository $locationsRepository): Response
    {
        $stat = $locationsRepository->occupancyRateWarehouse();
        /**
         * @var Highchart
         */
        $ob = new Highchart();
        $ob->chart->renderTo('graph');  // The #id of the div where to render the chart
        $ob->chart->type('pie');
        $ob->chart->options3d(array(
            'enabled' => true,
            'alpha' => 45,
            'beta' => 0
        ));
     //   $ob->title->text('Taux d\'occupation');
        $ob->title->text('');
        $ob->plotOptions->pie(
            [
            'allowPointSelect'  => true,
            'depth' => 35,
            'cursor'    => 'pointer',
            'dataLabels'    => [
                'enabled' => true,
                'showInLegend'  => false,
            ]]
        );


        $data = [];
        array_push($data, ['Libre', (int)$stat[0]['libre']]);
        array_push($data,['Occupé', (int)$stat[0]['total'] - (int)$stat[0]['libre']]);

        $ob->series(array(array("name" => "Alvéole(s)", "data"=>$data)));
        return $this->render('home.html.twig',[
        'stat'  => $stat,
        'chart'    => $ob,
        ]);

    }


}