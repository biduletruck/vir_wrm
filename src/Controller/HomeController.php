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
     * @param LocationsRepository $locationsRepository
     * @return Response
     */
    public function index(LocationsRepository $locationsRepository): Response
    {
        $stat = $locationsRepository->occupancyRateWarehouse();
        $ways = $locationsRepository->occupancyByDriveWay();

        $serie = [];
        foreach ($ways as $way)
        {
             array_push( $serie, [ 'name' => 'Allée : ' . $way['driveway'], 'y' => round(((( ($way['total'] - $way['libre']) / $way['total']) *100 )),2)]);
        }

        $driveways = new Highchart();
        $driveways->chart->renderTo('way');  // The #id of the div where to render the chart
        $driveways->chart->type('column');
        $driveways->title->text('');
        $driveways->xAxis->type('category');
        $driveways->yAxis->max(100);
        $driveways->yAxis->title(['text' => 'Taux d\'ocupation par allée']);
        $driveways->series([['name' => "Tx d'utilisation par l'allées",'data' => $serie]]);
        $driveways->plotOptions->column(
            [
                'series' => [
                    'borderWidth' => 0,
                    'dataLabels' => [
                    'enabled' => true,
                    'format' => '[point.y:.1f]%',
                        ]
                ]
            ]
        );

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
        $ob->title->text('Taux d\'occupation');
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

        $data = [
                    ['Libre', (int)$stat[0]['libre']],
                    ['Occupé', (int)$stat[0]['total'] - (int)$stat[0]['libre']]
                ];

        $ob->series(array(array("name" => "Alvéole(s)", "data"=>$data)));


        return $this->render('home.html.twig',[
        'stat'  => $stat,
        'chart'    => $ob,
        'driveways' => $driveways,
        ]);

    }


}