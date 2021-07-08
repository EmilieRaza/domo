<?php

namespace App\Controller\back;

use App\Entity\Resource;
use App\Form\ResourceType;
use App\Repository\ResourceRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/resource")
 */
class ResourceController extends AbstractController
{
    /**
     * @Route("/", name="admin_resource_search", methods="GET")
     */
    public function search(ResourceRepository $resourceRepository): Response
    {
        return $this->render('back/resource/search.html.twig', [
            'resources' => $resourceRepository->findAll(), 
            'slug'=>'admin_resource', 
        ]);
    }

    /**
     * @Route("/create", name="admin_resource_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $resource = new Resource();
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resource);
            $em->flush();

            return $this->redirectToRoute('admin_resource_search');
        }

        return $this->render('back/resource/create.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
            'slug'=>'admin_resource',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_resource_read", methods="GET")
     */
    public function read(Resource $resource): Response
    {
        return $this->render('back/resource/read.html.twig', ['
            resource' => $resource, 
            'slug'=>'admin_resource',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_resource_update", methods="GET|POST")
     */
    public function update(Request $request, Resource $resource): Response
    {
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_resource_search');
        }

        return $this->render('back/resource/update.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
            'slug'=>'admin_resource',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_resource_delete", methods="DELETE")
     */
    public function delete(Request $request, Resource $resource): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($resource);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_resource_search');
    }
}