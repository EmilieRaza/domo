<?php

namespace App\Controller\back;

use App\Entity\ProductImage;
use App\Form\ProductImageType;
use App\Repository\ResourceRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product/image")
 */
class ProductImageController extends AbstractController
{
    /**
     * @Route("/", name="admin_product_image_search", methods="GET")
     */
    public function search(ResourceRepository $resourceRepository): Response
    {
        return $this->render('back/product_image/search.html.twig', ['product_images' => $resourceRepository->findAll()]);
    }

    /**
     * @Route("/create", name="admin_product_image_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $productImage = new ProductImage();
        $form = $this->createForm(ProductImageType::class, $productImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productImage);
            $em->flush();

            return $this->redirectToRoute('admin_product_image_search');
        }

        return $this->render('back/product_image/create.html.twig', [
            'product_image' => $productImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_product_image_read", methods="GET")
     */
    public function read(ProductImage $productImage): Response
    {
        return $this->render('back/product_image/read.html.twig', ['product_image' => $productImage]);
    }

    /**
     * @Route("/update/{id}", name="admin_product_image_update", methods="GET|POST")
     */
    public function update(Request $request, ProductImage $productImage): Response
    {
        $form = $this->createForm(ProductImageType::class, $productImage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_product_image_search');
        }

        return $this->render('back/product_image/update.html.twig', [
            'product_image' => $productImage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_product_image_delete", methods="DELETE")
     */
    public function delete(Request $request, ProductImage $productImage): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($productImage);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_product_image_search');
    }
}