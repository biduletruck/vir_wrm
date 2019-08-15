<?php

namespace App\Controller;

use App\Entity\ProductListing;
use App\Form\ProductListing1Type;
use App\Repository\ProductListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/productlisting")
 */
class ProductListingController extends AbstractController
{
    /**
     * @Route("/", name="product_listing_index", methods={"GET"})
     */
    public function index(ProductListingRepository $productListingRepository): Response
    {
        return $this->render('product_listing/index.html.twig', [
            'product_listings' => $productListingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_listing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productListing = new ProductListing();
        $form = $this->createForm(ProductListing1Type::class, $productListing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productListing);
            $entityManager->flush();

            return $this->redirectToRoute('product_listing_index');
        }

        return $this->render('product_listing/new.html.twig', [
            'product_listing' => $productListing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_listing_show", methods={"GET"})
     */
    public function show(ProductListing $productListing): Response
    {
        return $this->render('product_listing/show.html.twig', [
            'product_listing' => $productListing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_listing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductListing $productListing): Response
    {
        $form = $this->createForm(ProductListing1Type::class, $productListing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_listing_index');
        }

        return $this->render('product_listing/edit.html.twig', [
            'product_listing' => $productListing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_listing_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductListing $productListing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$productListing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productListing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_listing_index');
    }
}
