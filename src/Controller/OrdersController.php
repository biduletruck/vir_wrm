<?php

namespace App\Controller;


use App\Entity\Agencies;
use App\Entity\Labels;
use App\Entity\Orders;
use App\Entity\ProductListing;
use App\Entity\Storages;
use App\Form\OrdersType;
use App\Repository\LabelsRepository;
use App\Repository\OrdersRepository;
use App\Repository\OrderStatusRepository;
use App\Repository\ProductListingRepository;
use App\Service\LabelGeneratorWithQrCode;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orders")
 */
class OrdersController extends AbstractController
{
    /**
     * @Route("/", name="orders_index", methods={"GET"})
     * @param OrdersRepository $ordersRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(OrdersRepository $ordersRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $orders = $paginator->paginate($ordersRepository->findAllOrdersQuery($this->getUser()->getAgency()),
        $request->query->getInt('page',1), 10);

        $sortable = $paginator->paginate($ordersRepository->findAll());

        return $this->render('orders/index.html.twig', [
            'orders' => $orders,
            'sortable' => $sortable
        ]);
    }

    /**
     * @Route("/new", name="orders_new", methods={"GET", "POST"})
     * @param Request $request
     * @param OrderStatusRepository $orderStatusRepository
     * @return Response
     * @throws \Exception
     */
    public function new(Request $request, OrderStatusRepository $orderStatusRepository): Response
    {
        $order = new Orders();
        $date = new \DateTime("NOW");

        $virLocalNumber = "GEN-" . $date->getTimestamp();
        $delivryDate = $request->request->get('orders_new');

        $form = $this->createForm(OrdersType::class, $order);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $command = new Orders();
            $command->setOrderingNumber($order->getOrderingNumber())
            ->setVirLocalNumber($virLocalNumber)
            ->setCustomerName($order->getCustomerName())
            ->setDateEntry($date)
            ->setDelivryDate(new \DateTime($delivryDate['DelivryDate']))
            ->setUser($this->getUser())
            ->setLabels($order->getLabels())
            ->setAgency($this->getUser()->getAgency())
            //->setOrderStatus($orderStatusRepository->findOneBy(array('Name' => "En attente")))
            ;

            $entityManager->persist($command);
            $entityManager->flush();

            $this->addProductToListing($order, $command, $entityManager);
            $this->addLabelBeforeLocation($command);
            return $this->redirectToRoute('orders_index');
        }

        return $this->render('orders/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/labels", name="orders_labels", methods={"GET", "POST"})
     * @param Orders $orders
     * @param OrdersRepository $ordersRepository
     * @param int $id
     * @return RedirectResponse
     */
    public function showPrintLabels(Orders $orders, OrdersRepository $ordersRepository, int $id)
    {
        if ($this->accessOrderById($id) !== $this->getUser()->getAgency()) {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à voir cette commande');
            return $this->redirectToRoute('orders_index');
        } else {
            $order = $ordersRepository->find($orders);
            $pdf = new LabelGeneratorWithQrCode();
            $pdf->createLabelsWithQrCode($order);
        }
    }

    /**
     * @param Orders $order
     * @param Orders $command
     * @param ObjectManager $entityManager
     */
    private function addProductToListing(Orders $order, Orders $command, ObjectManager $entityManager): void
    {
        foreach ($order->getProductListings() as $productListing)
        {
            $product = new ProductListing();
            $product->setProductNumber($productListing->getProductNumber())
            ->setFamilyProduct($productListing->getFamilyProduct())
            ->setOrderNumber($command);

            $entityManager->persist($product);
            $entityManager->persist($this->addLabelInLocation($product));
        }
        $entityManager->flush();
    }

    /**
     * @param ProductListing $ProductListing
     * @return Storages
     */
    private function addLabelInLocation(ProductListing $ProductListing)
    {
        $product = new Storages();
        $product->setProduct($ProductListing);
        return $product;
    }

    /**
     * @param Orders $order
     */
    private function addLabelBeforeLocation(Orders $order)
    {
        $entityManager = $this->getDoctrine()->getManager();

        for ($i = 1; $i <= $order->getLabels(); $i ++)
        {
            $label = new Labels();
            $label->setVirLocalNumber($order)
            ->setLocalLabel($order->getVirLocalNumber() . "-" . $i );
            $entityManager->persist($label);
        }
        $entityManager->flush();
    }

    /**
     * @Route("/{id}", name="orders_show", methods={"GET"})
     * @param Orders $order
     * @param ProductListingRepository $listingRepository
     * @param int $id
     * @param LabelsRepository $labelsRepository
     * @return Response
     */
    public function show(Orders $order, ProductListingRepository $listingRepository, int $id, LabelsRepository $labelsRepository): Response
    {
        if ( $this->accessOrderById($id) !== $this->getUser()->getAgency())
        {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à voir cette commande');
            return $this->redirectToRoute('orders_index');
        }else{
            return $this->render('orders/show.html.twig', [
                'order' => $order,
                'products' => $listingRepository->findBy(['OrderNumber' => $order]),
                'labels' => $labelsRepository->findBy(['virLocalNumber' => $order]),
            ]);
        }
    }

    /**
     * @Route("/{id}/edit", name="orders_edit", methods={"GET", "POST"})
     * @param Request $request
     * @param Orders $order
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, Orders $order, int $id): Response
    {
        if ( $this->accessOrderById($id) !== $this->getUser()->getAgency())
        {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à voir cette commande');
            return $this->redirectToRoute('orders_index');
        }else {
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
    }

    /**
     * @Route("/{id}", name="orders_delete", methods={"DELETE"})
     * @param Request $request
     * @param Orders $order
     * @param int $id
     * @return Response
     */
    public function delete(Request $request, Orders $order, int $id): Response
    {
        if ( $this->accessOrderById($id) !== $this->getUser()->getAgency())
        {
            $this->addFlash('danger', 'Vous n\'êtes pas autorisé à voir cette commande');
            return $this->redirectToRoute('orders_index');
        }else {
            if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($order);
                $entityManager->flush();
            }
            return $this->redirectToRoute('orders_index');
        }
    }

    /**
     * @param int $id
     * @return Agencies|null
     */
    private function accessOrderById(int $id)
    {
        $repo = $this->getDoctrine()->getRepository(Orders::class);
        $testOrder = $repo->find($id);
        $orderAcces = $testOrder->getAgency();
        return $orderAcces;
    }


}
