<?php

namespace App\Controller\back;

use App\Entity\Promotional;
use App\Form\PromotionalType;
use App\Repository\PromotionalRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/promotional")
 */
class PromotionalController extends AbstractController
{
    /**
     * @Route("/", name="admin_promotional_search", methods="GET")
     */
    public function search(PromotionalRepository $promotionalRepository): Response
    {
        return $this->render('back/promotional/search.html.twig', [
            'promotionals' => $promotionalRepository->findAll(), 
            'slug'=>'admin_promotional', 
        ]);
    }

    /**
     * @Route("/create", name="admin_promotional_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $promotional = new Promotional();
        $form = $this->createForm(PromotionalType::class, $promotional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($promotional);
            $em->flush();

            return $this->redirectToRoute('admin_promotional_search');
        }

        return $this->render('back/promotional/create.html.twig', [
            'promotional' => $promotional,
            'form' => $form->createView(),
            'slug'=>'admin_promotional',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_promotional_read", methods="GET")
     */
    public function read(Promotional $promotional): Response
    {
        return $this->render('back/promotional/read.html.twig', [
        'promotional' => $promotional, 
            'slug'=>'admin_promotional',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_promotional_update", methods="GET|POST")
     */
    public function update(Request $request, Promotional $promotional): Response
    {
        $form = $this->createForm(PromotionalType::class, $promotional);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_promotional_search');
        }

        return $this->render('back/promotional/update.html.twig', [
            'promotional' => $promotional,
            'form' => $form->createView(),
            'slug'=>'admin_promotional',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_promotional_delete", methods="DELETE")
     */
    public function delete(Request $request, Promotional $promotional): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($promotional);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_promotional_search');
    }
}