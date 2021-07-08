<?php

namespace App\Controller\back;

use App\Entity\Weight;
use App\Form\WeightType;
use App\Repository\WeightRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/weight")
 */
class WeightController extends AbstractController
{
    /**
     * @Route("/", name="admin_weight_search", methods="GET")
     */
    public function search(WeightRepository $weightRepository): Response
    {
        return $this->render('back/weight/search.html.twig', [
            'weights' => $weightRepository->findAll(), 
            'slug'=>'admin_weight', 
        ]);
    }

    /**
     * @Route("/create", name="admin_weight_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $weight = new Weight();
        $form = $this->createForm(WeightType::class, $weight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($weight);
            $em->flush();

            return $this->redirectToRoute('admin_weight_search');
        }

        return $this->render('back/weight/create.html.twig', [
            'weight' => $weight,
            'form' => $form->createView(),
            'slug'=>'admin_weight',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_weight_read", methods="GET")
     */
    public function read(Weight $weight): Response
    {
        return $this->render('back/weight/read.html.twig', [
        'weight' => $weight, 
            'slug'=>'admin_weight',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_weight_update", methods="GET|POST")
     */
    public function update(Request $request, Weight $weight): Response
    {
        $form = $this->createForm(WeightType::class, $weight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_weight_search');
        }

        return $this->render('back/weight/update.html.twig', [
            'weight' => $weight,
            'form' => $form->createView(),
            'slug'=>'admin_weight',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_weight_delete", methods="DELETE")
     */
    public function delete(Request $request, Weight $weight): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($weight);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_weight_search');
    }
}