<?php

namespace App\Controller;

use App\Entity\FamilyProduct;
use App\Form\FamilyProductType;
use App\Repository\FamilyProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/family_product")
 */
class FamilyProductController extends AbstractController
{
    /**
     * @Route("/", name="family_product_index", methods={"GET"})
     * @param FamilyProductRepository $familyProductRepository
     * @return Response
     */
    public function index(FamilyProductRepository $familyProductRepository): Response
    {
        return $this->render('family_product/index.html.twig', [
            'family_products' => $familyProductRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="family_product_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $familyProduct = new FamilyProduct();
        $form = $this->createForm(FamilyProductType::class, $familyProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($familyProduct);
            $entityManager->flush();

            return $this->redirectToRoute('family_product_index');
        }

        return $this->render('family_product/new.html.twig', [
            'family_product' => $familyProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="family_product_show", methods={"GET"})
     * @param FamilyProduct $familyProduct
     * @return Response
     */
    public function show(FamilyProduct $familyProduct): Response
    {
        return $this->render('family_product/show.html.twig', [
            'family_product' => $familyProduct,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="family_product_edit", methods={"GET","POST"})
     * @param Request $request
     * @param FamilyProduct $familyProduct
     * @return Response
     */
    public function edit(Request $request, FamilyProduct $familyProduct): Response
    {
        $form = $this->createForm(FamilyProductType::class, $familyProduct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('family_product_index');
        }

        return $this->render('family_product/edit.html.twig', [
            'family_product' => $familyProduct,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="family_product_delete", methods={"DELETE"})
     * @param Request $request
     * @param FamilyProduct $familyProduct
     * @return Response
     */
    public function delete(Request $request, FamilyProduct $familyProduct): Response
    {
        if ($this->isCsrfTokenValid('delete'.$familyProduct->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($familyProduct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('family_product_index');
    }
}
