<?php

namespace App\Controller;

use App\Entity\DetailOrderType;
use App\Form\DetailOrderTypeType;
use App\Repository\DetailOrderTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/detail/order/type")
 */
class DetailOrderTypeController extends AbstractController
{
    /**
     * @Route("/", name="detail_order_type_index", methods={"GET"})
     */
    public function index(DetailOrderTypeRepository $detailOrderTypeRepository): Response
    {
        return $this->render('detail_order_type/index.html.twig', [
            'detail_order_types' => $detailOrderTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="detail_order_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detailOrderType = new DetailOrderType();
        $form = $this->createForm(DetailOrderTypeType::class, $detailOrderType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detailOrderType);
            $entityManager->flush();

            return $this->redirectToRoute('detail_order_type_index');
        }

        return $this->render('detail_order_type/new.html.twig', [
            'detail_order_type' => $detailOrderType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_order_type_show", methods={"GET"})
     */
    public function show(DetailOrderType $detailOrderType): Response
    {
        return $this->render('detail_order_type/show.html.twig', [
            'detail_order_type' => $detailOrderType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="detail_order_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetailOrderType $detailOrderType): Response
    {
        $form = $this->createForm(DetailOrderTypeType::class, $detailOrderType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detail_order_type_index', [
                'id' => $detailOrderType->getId(),
            ]);
        }

        return $this->render('detail_order_type/edit.html.twig', [
            'detail_order_type' => $detailOrderType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detail_order_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, DetailOrderType $detailOrderType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detailOrderType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detailOrderType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detail_order_type_index');
    }
}
