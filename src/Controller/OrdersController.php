<?php

namespace App\Controller;


use App\Entity\Orders;
use App\Entity\OrderStatus;
use App\Entity\ProductListing;
use App\Form\OrdersType;
use App\Repository\OrdersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\CssSelector\Tests\Node\NegationNodeTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Tests\Fixtures\ToString;

/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods={"GET"})
     */
    public function index(OrdersRepository $ordersRepository): Response
    {
        return $this->render('orders/index.html.twig', [
            'orders' => $ordersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="orders_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $delivryDate = $request->request->get('orders_new');
        $order = new Orders();
        $date = new \DateTime("NOW");

        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $command = new Orders();
            $command->setOrderingNumber($order->getOrderingNumber());
            $command->setVirLocalNumber("GEN-" . $date->getTimestamp());
            $command->setCustomerName($order->getCustomerName());
            $command->setDateEntry($date);
            $command->setDelivryDate(new \DateTime($delivryDate['DelivryDate']));
            $command->setUser($this->getUser());
            //$command->setOrderStatus();

            $entityManager->persist($command);
            $entityManager->flush();

            foreach ($order->getProductListings() as $productListing)
            {
                $product = new ProductListing();
                $product->setProductNumber($productListing->getProductNumber());
                $product->setFamilyProduct($productListing->getFamilyProduct());
                $product->setOrderNumber($command);
                $entityManager->persist($product);
            }

            $entityManager->flush();

            return $this->redirectToRoute('orders_index');
        }

        return $this->render('orders/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orders_show", methods={"GET"})
     */
    public function show(Orders $order): Response
    {
        return $this->render('orders/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="orders_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Orders $order): Response
    {
        $commandorm = $this->createForm(OrdersType::class, $order);
        $commandorm->handleRequest($request);

        if ($commandorm->isSubmitted() && $commandorm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('orders_index', [
                'id' => $order->getId(),
            ]);
        }

        return $this->render('orders/edit.html.twig', [
            'order' => $order,
            'form' => $commandorm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="orders_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Orders $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orders_index');
    }
}
