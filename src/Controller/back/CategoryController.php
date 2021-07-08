<?php

namespace App\Controller\back;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_category_search", methods="GET")
     */
    public function search(CategoryRepository $categoryRepository): Response
    {
        return $this->render('back/category/search.html.twig', [
            'categories' => $categoryRepository->findAll(), 
            'slug'=>'admin_category', 
        ]);
    }

    /**
     * @Route("/create", name="admin_category_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin_category_search');
        }

        return $this->render('back/category/create.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'slug'=>'admin_category',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_category_read", methods="GET")
     */
    public function read(Category $category): Response
    {
        return $this->render('back/category/read.html.twig', [
        'category' => $category, 
            'slug'=>'admin_category',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_category_update", methods="GET|POST")
     */
    public function update(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_category_search');
        }

        return $this->render('back/category/update.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
            'slug'=>'admin_category',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_category_delete", methods="DELETE")
     */
    public function delete(Request $request, Category $category): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_category_search');
    }
}