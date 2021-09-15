<?php

namespace App\Controller\back;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="admin_contact_search", methods="GET")
     */
    public function search(ContactRepository $contactRepository): Response
    {
        return $this->render('back/contact/search.html.twig', [
            'contacts' => $contactRepository->findAll(), 
            'slug'=>'admin_contact', 
        ]);
    }

    // /**
    //  * @Route("/create", name="admin_category_create", methods="GET|POST")
    //  */
    // public function create(Request $request): Response
    // {
    //     $category = new Category();
    //     $form = $this->createForm(CategoryType::class, $category);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($category);
    //         $em->flush();

    //         return $this->redirectToRoute('admin_category_search');
    //     }

    //     return $this->render('back/category/create.html.twig', [
    //         'category' => $category,
    //         'form' => $form->createView(),
    //         'slug'=>'admin_category',
    //     ]);
    // }

    /**
     * @Route("/{id}", name="admin_contact_read", methods="GET")
     */
    public function read(Contact $contact): Response
    {
        return $this->render('back/contact/read.html.twig', [
        'contact' => $contact, 
            'slug'=>'admin_category',
        ]);
    }

    // /**
    //  * @Route("/update/{id}", name="admin_category_update", methods="GET|POST")
    //  */
    // public function update(Request $request, Category $category): Response
    // {
    //     $form = $this->createForm(CategoryType::class, $category);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('admin_category_search');
    //     }

    //     return $this->render('back/category/update.html.twig', [
    //         'category' => $category,
    //         'form' => $form->createView(),
    //         'slug'=>'admin_category',
    //     ]);
    // }

    /**
     * @Route("/delete/{id}", name="admin_category_delete", methods="DELETE")
     */
    public function delete(Request $request, Contact $contact): Response
    {
            $msg = 'Message supprimé avec succès';
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush();
            $this->addFlash('success', $msg);
            return $this->redirectToRoute('admin_contact_search');
    }
}