<?php


namespace App\Controller;

use App\Entity\OrderStatus;
use App\Repository\LocationsRepository;
use App\Repository\OrderStatusRepository;
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
        return $this->render('home.html.twig',[
        'stat' => $stat,
        ]);

    }


}