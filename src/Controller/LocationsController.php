<?php

namespace App\Controller;

use App\Entity\Agencies;
use App\Entity\Locations;
use App\Form\LocationsType;
use App\Repository\LocationsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/locations")
 */
class LocationsController extends AbstractController
{
    /**
     * @Route("/", name="locations_index", methods={"GET"})
     * @param LocationsRepository $locationsRepository
     * @return Response
     */
    public function index(LocationsRepository $locationsRepository): Response
    {
        return $this->render('locations/index.html.twig', [
            'locations' => $locationsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="locations_new", methods={"GET","POST"})
     * Permet d'ajouter une nouvelle Allée à l'entrepot en fonction du nombre de lice et d'alvéoles
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('allee', TextType::class)
            ->add('lice', NumberType::class)
            ->add('alveole', NumberType::class)
            ->add('agency', EntityType::class, array(
                'required' => false,
                'class'   => Agencies::class,
                'attr'      => array('class' => 'form-control')
            ))
            ->add('send', SubmitType::class,['label' => 'ajouter'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data= $form->getData();
            $entityManager = $this->getDoctrine()->getManager();


            for ($i = 0; $i <= $data['lice']; $i++)
            {
                $lice = $i < 10 ? "0" . $i : $i;
                for ($k = 0; $k <= $data['alveole']; $k++)
                {
                    $alveole = $k < 10 ? "**000" . $k : "**00" .$k;
                    $nameLocation = strtoupper("ERA" . $data['allee']) . $alveole  . $lice;
                    $name = $nameLocation . "-" . $data['agency'];
                    $entity = $this->getDoctrine()->getRepository(Locations::class)->findOneBy(['Name' => $name]);
                    if ($entity == null)
                    {
                        $location = new Locations();
                        $location->setLocation($nameLocation);
                        $location->setFreePlace(true);
                        $location->setDriveway(strtoupper($data['allee']));
                        $location->setAgency($data['agency']);
                        $location->setName($name);
                        $entityManager->merge($location);
                    }
                };
            };

            $entityManager->flush();
            return $this->redirectToRoute('locations_index');
        }

        return $this->render('locations/new.html.twig', [
            'form' => $form->createView()
        ]);

    }

  /*  public function new(Request $request): Response
    {
        $location = new Locations();
        $form = $this->createForm(LocationsType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($location);
            $entityManager->flush();

            return $this->redirectToRoute('locations_index');
        }

        return $this->render('locations/new.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }
  */

    /**
     * @Route("/{id}", name="locations_show", methods={"GET"})
     */
    public function show(Locations $location): Response
    {
        return $this->render('locations/show.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="locations_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Locations $location): Response
    {
        $form = $this->createForm(LocationsType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('locations_index', [
                'id' => $location->getId(),
            ]);
        }

        return $this->render('locations/edit.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="locations_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Locations $location): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($location);
            $entityManager->flush();
        }

        return $this->redirectToRoute('locations_index');
    }
}
