<?php


namespace App\Controller;

use App\Entity\OrderStatus;
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
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }


}