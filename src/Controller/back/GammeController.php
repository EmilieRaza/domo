<?php

namespace App\Controller\back;

use App\Entity\Gamme;
use App\Form\GammeType;
use App\Repository\GammeRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gamme")
 */
class GammeController extends AbstractController
{
    /**
     * @Route("/", name="admin_gamme_search", methods="GET")
     */
    public function search(GammeRepository $gammeRepository): Response
    {
        return $this->render('back/gamme/search.html.twig', [
            'gammes' => $gammeRepository->findAll(), 
            'slug'=>'admin_gamme', 
        ]);
    }

    /**
     * @Route("/create", name="admin_gamme_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $gamme = new Gamme();
        $form = $this->createForm(GammeType::class, $gamme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gamme);
            $em->flush();

            return $this->redirectToRoute('admin_gamme_search');
        }

        return $this->render('back/gamme/create.html.twig', [
            'gamme' => $gamme,
            'form' => $form->createView(),
            'slug'=>'admin_gamme',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_gamme_read", methods="GET")
     */
    public function read(Gamme $gamme): Response
    {
        return $this->render('back/gamme/read.html.twig', [
        'gamme' => $gamme, 
            'slug'=>'admin_gamme',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_gamme_update", methods="GET|POST")
     */
    public function update(Request $request, Gamme $gamme): Response
    {
        $form = $this->createForm(GammeType::class, $gamme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_gamme_search');
        }

        return $this->render('back/gamme/update.html.twig', [
            'gamme' => $gamme,
            'form' => $form->createView(),
            'slug'=>'admin_gamme',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_gamme_delete", methods="DELETE")
     */
    public function delete(Request $request, Gamme $gamme): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($gamme);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_gamme_search');
    }
}