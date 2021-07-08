<?php

namespace App\Controller\back;

use App\Entity\PageBlock;
use App\Form\PageBlockType;
use App\Repository\PageBlockRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/page/block")
 */
class PageBlockController extends AbstractController
{
    /**
     * @Route("/", name="admin_page_block_search", methods="GET")
     */
    public function search(PageBlockRepository $pageBlockRepository): Response
    {
        return $this->render('back/page_block/search.html.twig', [
            'page_blocks' => $pageBlockRepository->findAll(), 
            'slug'=>'admin_page_block', 
        ]);
    }

    /**
     * @Route("/create", name="admin_page_block_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $pageBlock = new PageBlock();
        $form = $this->createForm(PageBlockType::class, $pageBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pageBlock);
            $em->flush();

            return $this->redirectToRoute('admin_page_block_search');
        }

        return $this->render('back/page_block/create.html.twig', [
            'page_block' => $pageBlock,
            'form' => $form->createView(),
            'slug'=>'admin_page_block',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_page_block_read", methods="GET")
     */
    public function read(PageBlock $pageBlock): Response
    {
        return $this->render('back/page_block/read.html.twig', ['
            page_block' => $pageBlock, 
            'slug'=>'admin_page_block',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_page_block_update", methods="GET|POST")
     */
    public function update(Request $request, PageBlock $pageBlock): Response
    {
        $form = $this->createForm(PageBlockType::class, $pageBlock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_page_block_search');
        }

        return $this->render('back/page_block/update.html.twig', [
            'page_block' => $pageBlock,
            'form' => $form->createView(),
            'slug'=>'admin_page_block',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_page_block_delete", methods="DELETE")
     */
    public function delete(Request $request, PageBlock $pageBlock): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($pageBlock);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_page_block_search');
    }
}