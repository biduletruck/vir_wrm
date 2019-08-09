<?php

namespace App\Controller;

use App\Entity\OrderBack;
use App\Form\OrderBackType;
use App\Repository\OrderBackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order/back")
 */
class OrderBackController extends AbstractController
{
    /**
     * @Route("/", name="order_back_index", methods={"GET"})
     */
    public function index(OrderBackRepository $orderBackRepository): Response
    {
        return $this->render('order_back/index.html.twig', [
            'order_backs' => $orderBackRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="order_back_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $orderBack = new OrderBack();
        $form = $this->createForm(OrderBackType::class, $orderBack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderBack);
            $entityManager->flush();

            return $this->redirectToRoute('order_back_index');
        }

        return $this->render('order_back/new.html.twig', [
            'order_back' => $orderBack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_back_show", methods={"GET"})
     */
    public function show(OrderBack $orderBack): Response
    {
        return $this->render('order_back/show.html.twig', [
            'order_back' => $orderBack,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="order_back_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrderBack $orderBack): Response
    {
        $form = $this->createForm(OrderBackType::class, $orderBack);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_back_index');
        }

        return $this->render('order_back/edit.html.twig', [
            'order_back' => $orderBack,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_back_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OrderBack $orderBack): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderBack->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orderBack);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_back_index');
    }
}