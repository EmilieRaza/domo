<?php

namespace App\Controller\back;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="admin_product_search", methods="GET")
     */
    public function search(ProductRepository $productRepository): Response
    {
        return $this->render('back/product/search.html.twig', [
            'products' => $productRepository->findBy([], ['updatedAt' => 'ASC']),
            'slug' => 'admin_product',
        ]);
    }

    /**
     * @Route("/create", name="admin_product_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product, [
            'update' => $product->getId()==null?false:true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('admin_product_search');
        }

        return $this->render('back/product/create.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'slug' => 'admin_product',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_product_read", methods="GET")
     */
    public function read(Product $product): Response
    {
        return $this->render('back/product/read.html.twig', [
            'product' => $product,
            'slug' => 'admin_product',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_product_update", methods="GET|POST")
     */
    public function update(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product, [
            'update' => $product->getId()==null?false:true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_product_search');
        }

        return $this->render('back/product/update.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'slug' => 'admin_product',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_product_delete", methods="DELETE")
     */
    public function delete(Request $request, Product $product): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_product_search');
    }
}