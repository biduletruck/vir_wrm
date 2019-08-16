<?php

namespace App\Controller;

use App\Entity\Labels;
use App\Entity\Locations;
use App\Form\Labels\AddLabelInLocationType;
use App\Form\Labels\LabelsType;
use App\Repository\LabelsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

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
     * @Route("/add", name="labels_add", methods={"GET","POST"})
     */
    public function AddLabelLocation(Request $request): Response
    {
        $label = new Labels();
        $form = $this->createForm(AddLabelInLocationType::class, $label);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            /** @var Labels $data */
            $data = $form->getData();
            $lice = $data->getLice() < 10 ? "0" . $data->getLice() : $data->getLice();
            $newLocation = $data->getNewLocation() . $lice;


            //Récupération de la commande
            $order = $entityManager->getRepository(Labels::class)->findOneBy(['localLabel' => $data->getLocalLabel()]);
            //Récupération de l'emplacement en base
            $location = $entityManager->getRepository(Locations::class)->findOneBy(['Name' => $newLocation ."-" . $this->getUser()->getAgency()->getName()]);
     dump($lice);
     dump($newLocation);
     dump($order);
     dump($location);

     //die();
            $label = $entityManager->getRepository(Labels::class)->find($order);
            dump($label);

            if (!$label->getLocation() == null)
            {

                $oldLocation = $this->getDoctrine()->getRepository(Locations::class)->find($label->getLocation());
                $oldLocation->setFreePlace(1);
              /*  $entityManager->persist($oldLocation);
                $entityManager->flush(); */

              dump($oldLocation);
            }
            $label->setLogin($this->getUser());
            $label->setVirLocalNumber($order->getVirLocalNumber());
            $label->setLocationDate(new \DateTime());
            $label->setLocation($location);
            $label->getLocation()->setFreePlace(0);

            $entityManager->persist($label);
            $entityManager->flush();

            return $this->redirectToRoute('labels_index');
        }

        return $this->render('labels/add.html.twig', [
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

    /**
     * Find label in base
     *
     * @Route("/FindLabel", name="find_label_in_base")
     */
    public function findLabelInBase(Request $request)
    {
        if ($request->isMethod('POST') && $request->isXmlHttpRequest())
        {
            $content = $request->request;
            $tab = $content->get('add_label_in_location');
            dump($tab);
            $em = $this->getDoctrine()->getManager();
            /* @var $Label Labels  */
            $emplacement = $em->getRepository(Labels::class)->findOneBy(['localLabel' => $tab['localLabel']]);


            $response = new JsonResponse();


            if ( !empty($emplacement) && ($emplacement->getVirLocalNumber()->getAgency() === $this->getUser()->getAgency()) ) {
                if(!empty($tab['lice']) && !empty($tab['newLocation']))
                {
                    $lice = $tab['lice'] < 10 ? "0" . $tab['lice'] : $tab['lice'];
                    $isValidLocation = $em->getRepository(Locations::class)->findOneBy(['Name' => $tab['newLocation'] . $lice . "-" . $this->getUser()->getAgency() ]);
                    $location = $isValidLocation !== null ? true : false;
                }else{
                    $location = false;
                }
                $response->setData(["response" => true, "localLabel" => $location]);
            }else{
                $response->setData(["response" => false,"localLabel" => false]);
            }
            return $response;
        }
        return false;

    }

}
