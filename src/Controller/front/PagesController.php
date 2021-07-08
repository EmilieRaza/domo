<?php

namespace App\Controller\front;

use App\Entity\Page;
use App\Entity\Contact;
use App\Services\Mailer;
use App\Entity\Propertie;
use App\Form\ContactType;
use App\Entity\Recruitment;
use App\Form\RecruitmentType;
use App\Repository\SliderRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $productRepository, SliderRepository $sliderRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('front/pages/index.html.twig', [
            'sliders' => $sliderRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'products' => $productRepository->findBy(['isActive' => true, 'isHome' => true],['updatedAt' => 'DESC'], 6),
            'slug' =>'home',
        ]);
    }


    
     /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, Mailer $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $conf_company_name = $this->getParameter('conf_company_name');
            $conf_company_email = $this->getParameter('conf_company_email');
            $conf_company_email2 = $this->getParameter('conf_company_email2');
            $conf_server_email = $this->getParameter('conf_server_email');
            $contactType = $contact->getType();
            $contactName = $contact->getFirstName().' '.$contact->getLastName();
            $contactEmail = $contact->getEmail();
            $contactPhone = $contact->getPhone();
            $contactMessage = $contact->getMessage();

            // on utilise le service Mailer créé précédemment
            $bodyMailConfirmation = $mailer->createBodyMail('front/pages/mail/mail_confirmation.html.twig', [
                'conf_company_name' => $conf_company_name,
                'contact_name' =>  $contactName,
            ]);

            $mailer->sendMessage($conf_company_name,  $conf_server_email, $contact->getEmail(), 'Confirmation - '.$conf_company_name, $bodyMailConfirmation);

            // on utilise le service Mailer créé précédemment
            $bodyMailContact = $mailer->createBodyMail('front/pages/mail/mail_contact.html.twig', [
                'contact_type' =>  $contactType,
                'contact_name' =>  $contactName,
                'contact_email' => $contactEmail,
                'contact_phone' => $contactPhone,
                'contact_message' => $contactMessage,
                'conf_company_name' => $conf_company_name,
                
            ]);

            $mailer->sendMessage($conf_company_name, $conf_server_email, $conf_company_email, 'Contact - '.$conf_company_name, $bodyMailContact, $conf_company_email2);

            $this->addFlash('success', 'Message reçu ! Nous vous recontactons dans les plus brefs délais le temps de préparer une réponse ou une offre adaptée à votre besoin.');
            return $this->redirectToRoute('home');
        }

        return $this->render('front/pages/contact.html.twig', [
            'slug' =>'contact',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{title}", name="page_read", methods="GET" , requirements={"id"="\d+"})
     */
    public function read(Page $page): Response
    {
        return $this->render('front/pages/read.html.twig', [
            'page' => $page, 
            'slug'=>'page',
        ]);
    }
}
