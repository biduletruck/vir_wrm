<?php

namespace App\Controller;

use App\Entity\LabelStatus;
use App\Form\LabelStatusType;
use App\Repository\LabelStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/label/status")
 */
class LabelStatusController extends AbstractController
{
    /**
     * @Route("/", name="label_status_index", methods={"GET"})
     * @param LabelStatusRepository $labelStatusRepository
     * @return Response
     */
    public function index(LabelStatusRepository $labelStatusRepository): Response
    {
        return $this->render('label_status/index.html.twig', [
            'label_statuses' => $labelStatusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="label_status_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $labelStatus = new LabelStatus();
        $form = $this->createForm(LabelStatusType::class, $labelStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($labelStatus);
            $entityManager->flush();

            return $this->redirectToRoute('label_status_index');
        }

        return $this->render('label_status/new.html.twig', [
            'label_status' => $labelStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="label_status_show", methods={"GET"})
     * @param LabelStatus $labelStatus
     * @return Response
     */
    public function show(LabelStatus $labelStatus): Response
    {
        return $this->render('label_status/show.html.twig', [
            'label_status' => $labelStatus,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="label_status_edit", methods={"GET","POST"})
     * @param Request $request
     * @param LabelStatus $labelStatus
     * @return Response
     */
    public function edit(Request $request, LabelStatus $labelStatus): Response
    {
        $form = $this->createForm(LabelStatusType::class, $labelStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('label_status_index');
        }

        return $this->render('label_status/edit.html.twig', [
            'label_status' => $labelStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="label_status_delete", methods={"DELETE"})
     * @param Request $request
     * @param LabelStatus $labelStatus
     * @return Response
     */
    public function delete(Request $request, LabelStatus $labelStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$labelStatus->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($labelStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('label_status_index');
    }
}
