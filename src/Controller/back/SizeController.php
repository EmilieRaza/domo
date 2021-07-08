<?php

namespace App\Controller\back;

use App\Entity\Size;
use App\Form\SizeType;
use App\Repository\SizeRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/size")
 */
class SizeController extends AbstractController
{
    /**
     * @Route("/", name="admin_size_search", methods="GET")
     */
    public function search(SizeRepository $sizeRepository): Response
    {
        return $this->render('back/size/search.html.twig', [
            'sizes' => $sizeRepository->findAll(), 
            'slug'=>'admin_size', 
        ]);
    }

    /**
     * @Route("/create", name="admin_size_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $size = new Size();
        $form = $this->createForm(SizeType::class, $size);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($size);
            $em->flush();

            return $this->redirectToRoute('admin_size_search');
        }

        return $this->render('back/size/create.html.twig', [
            'size' => $size,
            'form' => $form->createView(),
            'slug'=>'admin_size',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_size_read", methods="GET")
     */
    public function read(Size $size): Response
    {
        return $this->render('back/size/read.html.twig', [
        'size' => $size, 
            'slug'=>'admin_size',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_size_update", methods="GET|POST")
     */
    public function update(Request $request, Size $size): Response
    {
        $form = $this->createForm(SizeType::class, $size);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_size_search');
        }

        return $this->render('back/size/update.html.twig', [
            'size' => $size,
            'form' => $form->createView(),
            'slug'=>'admin_size',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_size_delete", methods="DELETE")
     */
    public function delete(Request $request, Size $size): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($size);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_size_search');
    }
}