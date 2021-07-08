<?php

namespace App\Controller\back;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Repository\SliderRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/slider")
 */
class SliderController extends AbstractController
{
    /**
     * @Route("/", name="admin_slider_search", methods="GET")
     */
    public function search(SliderRepository $sliderRepository): Response
    {
        return $this->render('back/slider/search.html.twig', [
            'sliders' => $sliderRepository->findAll(),
            'slug' => 'slider',
        ]);
    }

    /**
     * @Route("/create", name="admin_slider_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();

            return $this->redirectToRoute('admin_slider_search');
        }

        return $this->render('back/slider/create.html.twig', [
            'slider' => $slider,
            'form' => $form->createView(),
            'slug' => 'slider',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_slider_read", methods="GET")
     */
    public function read(Slider $slider): Response
    {
        return $this->render('back/slider/read.html.twig', [
            'slider' => $slider,
            'slug' => 'slider',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_slider_update", methods="GET|POST")
     */
    public function update(Request $request, Slider $slider): Response
    {
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_slider_search');
        }

        return $this->render('back/slider/update.html.twig', [
            'slider' => $slider,
            'form' => $form->createView(),
            'slug' => 'slider',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_slider_delete", methods="DELETE")
     */
    public function delete(Request $request, Slider $slider): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($slider);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_slider_search');
    }
}