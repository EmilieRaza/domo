<?php

namespace App\Controller\back;

use App\Entity\Page;
use App\Form\PageType;
use App\Repository\PageRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/page")
 */
class PageController extends AbstractController
{
    /**
     * @Route("/", name="admin_page_search", methods="GET")
     */
    public function search(PageRepository $pageRepository): Response
    {
        return $this->render('back/page/search.html.twig', [
            'pages' => $pageRepository->findAll(), 
            'slug'=>'admin_page', 
        ]);
    }

    /**
     * @Route("/create", name="admin_page_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute('admin_page_search');
        }

        return $this->render('back/page/create.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
            'slug'=>'admin_page',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_page_read", methods="GET")
     */
    public function read(Page $page): Response
    {
        return $this->render('back/page/read.html.twig', [
            'page' => $page, 
            'slug'=>'admin_page',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_page_update", methods="GET|POST")
     */
    public function update(Request $request, Page $page): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_page_search');
        }

        return $this->render('back/page/update.html.twig', [
            'page' => $page,
            'form' => $form->createView(),
            'slug'=>'admin_page',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_page_delete", methods="DELETE")
     */
    public function delete(Request $request, Page $page): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_page_search');
    }
}