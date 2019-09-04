<?php

namespace App\Controller;

use App\Entity\Labels;
use App\Entity\Locations;
use App\Form\Labels\AddLabelInLocationType;
use App\Form\Labels\LabelsType;
use App\Form\Labels\OutLabelInLocationType;
use App\Repository\LabelsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use function Matrix\diagonal;

/**
 * @Route("/labels")
 */
class LabelsController extends AbstractController
{
    /**
     * @Route("/", name="labels_index", methods={"GET"})
     * @param LabelsRepository $labelsRepository
     * @return Response
     */
    public function index(LabelsRepository $labelsRepository): Response
    {
        return $this->render('labels/index.html.twig', [
            'labels' => $labelsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="labels_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
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
     * @param Request $request
     * @return Response
     * @throws \Exception
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

            $newLocation = $data->getNewLocation() . $this->getStr($data->getLice());


            //Récupération de la commande
            $order = $entityManager->getRepository(Labels::class)->findOneBy(['localLabel' => $data->getLocalLabel()]);


            //Récupération de l'emplacement en base
            $location = $entityManager->getRepository(Locations::class)->findOneBy(['Name' => $newLocation ."-" . $this->getUser()->getAgency()->getName()]);


            $label = $entityManager->getRepository(Labels::class)->find($order);
            if (!$label->getLocation() == null)
            {
                $oldLocation = $this->getDoctrine()->getRepository(Locations::class)->find($label->getLocation());
                $oldLocation->setCountLabels($oldLocation->getCountLabels()-1);
                if ( $oldLocation->getCountLabels() < 1)
                {
                    $oldLocation->setFreePlace(1);
                }
                $entityManager->persist($oldLocation);
                $entityManager->flush();
            }
            $label->setLogin($this->getUser());
            $label->setVirLocalNumber($order->getVirLocalNumber());
            $label->setLocationDate(new \DateTime());
            $label->setLocation($location);
            $label->getLocation()->setCountLabels($location->getCountLabels() + 1);
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
     * @Route("/outofstock", name="labels_out_of_stock", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function outOfStock(Request $request): Response
    {
        $label = new Labels();
        $form = $this->createForm(OutLabelInLocationType::class, $label);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            /** @var Labels $data */
            $data = $form->getData();

            //Récupération de la commande
            $order = $entityManager->getRepository(Labels::class)->findOneBy(['localLabel' => $data->getLocalLabel()]);
            $label = $entityManager->getRepository(Labels::class)->find($order);
            $oldLocation = $this->getDoctrine()->getRepository(Locations::class)->find($label->getLocation());
            $oldLocation->setCountLabels($oldLocation->getCountLabels()-1);
            if ( $oldLocation->getCountLabels() < 1)
            {
                $oldLocation->setFreePlace(1);
            }
            $entityManager->persist($oldLocation);
            $entityManager->flush();

            $label->setLogin($this->getUser());
            $label->setVirLocalNumber($order->getVirLocalNumber());
            $label->setLocationDate(new \DateTime());
            $label->setLocation(null);
            $entityManager->persist($label);
            $entityManager->flush();

            return $this->redirectToRoute('labels_index');
        }

        return $this->render('labels/out.html.twig', [
            'label' => $label,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="labels_show", methods={"GET"})
     * @param Labels $label
     * @return Response
     */
    public function show(Labels $label): Response
    {
        return $this->render('labels/show.html.twig', [
            'label' => $label,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="labels_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Labels $label
     * @param ObjectManager $entityManager
     * @return Response
     * @throws \Exception
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
     * @param Request $request
     * @param Labels $label
     * @return Response
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
     * @param Request $request
     * @return bool|JsonResponse
     */
    public function findLabelInBase(Request $request)
    {
        if ($request->isMethod('POST') && $request->isXmlHttpRequest())
        {
            $content = $request->request;
            $tab = $content->get('add_label_in_location');
            $em = $this->getDoctrine()->getManager();
            /* @var $Label Labels  */
            $emplacement = $em->getRepository(Labels::class)->findOneBy(['localLabel' => $tab['localLabel']]);

            $response = new JsonResponse();

            if ( !empty($emplacement) && ($emplacement->getVirLocalNumber()->getAgency() === $this->getUser()->getAgency()) ) {
                if(!empty($tab['lice']) && !empty($tab['newLocation']))
                {

                    $isValidLocation = $em->getRepository(Locations::class)->findOneBy(['Name' => $tab['newLocation'] . $this->getStr($tab) . "-" . $this->getUser()->getAgency() ]);
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

    /**
     * Find label in base
     *
     * @Route("/FindLabelForOut", name="find_label_in_base_for_out")
     * @param Request $request
     * @return bool|JsonResponse
     */
    public function findLabelInBaseForOut(Request $request)
    {
        if ($request->isMethod('POST') && $request->isXmlHttpRequest())
        {
            $content = $request->request;
            $tab = $content->get('out_label_in_location');
            $em = $this->getDoctrine()->getManager();
            /* @var $Label Labels  */
            $emplacement = $em->getRepository(Labels::class)->findOneBy(['localLabel' => $tab['localLabel']]);

            $response = new JsonResponse();

            if ( !empty($emplacement) && ($emplacement->getVirLocalNumber()->getAgency() === $this->getUser()->getAgency()) )
            {
               // $isValidLocation = $em->getRepository(Locations::class)->findOneBy(['Name' => $tab['newLocation'] . $this->getStr($tab) . "-" . $this->getUser()->getAgency() ]);
              //  $location = $isValidLocation !== null ? true : false;
                dump($emplacement);
                $location = $emplacement->getLocation() !== null ? true : false;
            }else{
                $location = false;
            }
            $response->setData(["response" => true, "localLabel" => $location]);

            return $response;
        }
        return false;

    }

    /**
     * @param $tab
     * @return string
     */
    public function getStr($tab): string
    {
        $lice = $tab['lice'] < 10 ? "0" . $tab['lice'] : $tab['lice'];
        return $lice;
    }

}
