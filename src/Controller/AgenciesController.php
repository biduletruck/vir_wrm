<?php

namespace App\Controller;

use App\Entity\Agencies;
use App\Form\AgenciesType;
use App\Repository\AgenciesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/agencies")
 */
class AgenciesController extends AbstractController
{
    /**
     * @Route("/", name="agencies_index", methods={"GET"})
     */
    public function index(AgenciesRepository $agenciesRepository): Response
    {
        return $this->render('agencies/index.html.twig', [
            'agencies' => $agenciesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="agencies_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $agency = new Agencies();
        $form = $this->createForm(AgenciesType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agency);
            $entityManager->flush();

            return $this->redirectToRoute('agencies_index');
        }

        return $this->render('agencies/new.html.twig', [
            'agency' => $agency,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agencies_show", methods={"GET"})
     */
    public function show(Agencies $agency): Response
    {
        return $this->render('agencies/show.html.twig', [
            'agency' => $agency,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="agencies_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Agencies $agency): Response
    {
        $form = $this->createForm(AgenciesType::class, $agency);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agencies_index');
        }

        return $this->render('agencies/edit.html.twig', [
            'agency' => $agency,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="agencies_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Agencies $agency): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agency->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($agency);
            $entityManager->flush();
        }

        return $this->redirectToRoute('agencies_index');
    }
}
