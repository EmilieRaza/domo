<?php

namespace App\Controller\back;

use App\Entity\Configuration;
use App\Form\ConfigurationType;
use App\Repository\ConfigurationRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/configuration")
 */
class ConfigurationController extends AbstractController
{
    /**
     * @Route("/", name="admin_configuration_search", methods="GET")
     */
    public function search(ConfigurationRepository $configurationRepository): Response
    {
        return $this->render('back/configuration/search.html.twig', [
            'configurations' => $configurationRepository->findAll(),
            'slug' => 'config',
        ]);
    }

    /**
     * @IsGranted("ROLE_SUPER_ADMIN")
     * @Route("/create", name="admin_configuration_create", methods="GET|POST")
     */
    public function create(Request $request): Response
    {
        $configuration = new Configuration();
        $form = $this->createForm(ConfigurationType::class, $configuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configuration);
            $em->flush();

            return $this->redirectToRoute('admin_configuration_search');
        }

        return $this->render('back/configuration/create.html.twig', [
            'configuration' => $configuration,
            'form' => $form->createView(),
            'slug' => 'config',
        ]);
    }

    /**
     * @Route("/{id}", name="admin_configuration_read", methods="GET")
     */
    public function read(Configuration $configuration): Response
    {
        return $this->render('back/configuration/read.html.twig', [
            'configuration' => $configuration,
            'slug' => 'config',
        ]);
    }

    /**
     * @Route("/update/{id}", name="admin_configuration_update", methods="GET|POST")
     */
    public function update(Request $request, Configuration $configuration): Response
    {
        $form = $this->createForm(ConfigurationType::class, $configuration);

        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {
            $form->remove('name');
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_configuration_search');
        }

        return $this->render('back/configuration/update.html.twig', [
            'configuration' => $configuration,
            'form' => $form->createView(),
            'slug' => 'config',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_configuration_delete", methods="DELETE")
     */
    public function delete(Request $request, Configuration $configuration): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($configuration);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_configuration_search');
    }
}