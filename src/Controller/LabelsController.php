<?php

namespace App\Controller;

use App\Entity\Labels;
use App\Entity\Locations;
use App\Form\LabelsType;
use App\Repository\LabelsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/labels")
 */
class LabelsController extends AbstractController
{
    /**
     * @Route("/", name="labels_index", methods={"GET"})
     */
    public function index(LabelsRepository $labelsRepository): Response
    {
        return $this->render('labels/index.html.twig', [
            'labels' => $labelsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="labels_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $label = new Labels();
        $form = $this->createForm(LabelsType::class, $label);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($label);
            $entityManager->flush();

            return $this->redirectToRoute('labels_index');
        }

        return $this->render('labels/new.html.twig', [
            'label' => $label,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="labels_show", methods={"GET"})
     */
    public function show(Labels $label): Response
    {
        return $this->render('labels/show.html.twig', [
            'label' => $label,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="labels_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Labels $label, ObjectManager $entityManager): Response
    {
        $form = $this->createForm(LabelsType::class, $label);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if (!$data->getLocation() == null)
            {
                $oldLocation = $this->getDoctrine()->getRepository(Locations::class)->find($data->getLocation());
                $oldLocation->setFreePlace(1);
                $entityManager->persist($oldLocation);
                $entityManager->flush();
            }

            $data->setLocation($data->getNewLocation());
            $data->getLocation()->setFreePlace(0);
            $data->setLogin($this->getUser());
            $data->setLocationDate(new \DateTime('NOW'));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('labels_index');
        }

        return $this->render('labels/edit.html.twig', [
            'label' => $label,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="labels_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Labels $label): Response
    {
        if ($this->isCsrfTokenValid('delete'.$label->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($label);
            $entityManager->flush();
        }

        return $this->redirectToRoute('labels_index');
    }
}
