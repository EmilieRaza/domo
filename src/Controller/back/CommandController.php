<?php

namespace App\Controller\back;

use App\Entity\Command;
use App\Form\CommandType;
use App\Repository\CommandRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/command")
 */
class CommandController extends AbstractController
{
    /**
     * @Route("/", name="admin_command_search", methods="GET")
     */
    public function search(CommandRepository $commandRepository): Response
    {
        return $this->render('back/command/search.html.twig', [
            'commands' => $commandRepository->findAll(), 
            'slug'=>'admin_command', 
        ]);
    }

    /**
     * @Route("/{id}", name="admin_command_read", methods="GET")
     */
    public function read(Command $command): Response
    {
        return $this->render('back/command/read.html.twig', [
        'command' => $command, 
            'slug'=>'admin_command',
        ]);
    }
/**
     * @Route("/update/{id}", name="admin_command_update", methods="GET|POST")
     */
    public function update(Request $request,Command $command): Response
    {
        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_command_search');
        }

        return $this->render('back/command/update.html.twig', [
            'command' => $command,
            'form' => $form->createView(),
            'slug'=>'admin_command',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_command_delete", methods="DELETE")
     */
    public function delete(Request $request, Command $command): Response
    {
            $msg = 'Enregistrement supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($command);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_command_search');
    }
}