<?php

namespace App\Controller\front;

use App\Entity\User;
use App\Services\Mailer;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="registration", methods="GET|POST")
     */
    public function create(Request $request, Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles(['ROLE_CUSTOMER']);
            $user->setUsername($user->getEmail());
            $user->setEnabled(false);
            $em->persist($user);
            $em->flush();

            $conf_company_name = $this->getParameter('conf_company_name');
            $conf_company_email = $this->getParameter('conf_company_email');
            $conf_server_email = $this->getParameter('conf_server_email');

            // on utilise le service Mailer créé précédemment
            $bodyMailUser = $mailer->createBodyMail('security/mail/mail_user.html.twig', [
                'user' => $user,
                'conf_company_name' => $conf_company_name
            ]);

            $mailer->sendMessage($conf_company_name, $conf_server_email, $user->getEmail(), 'Inscription', $bodyMailUser);

            // on utilise le service Mailer créé précédemment
            $bodyMailAdmin = $mailer->createBodyMail('security/mail/mail_admin.html.twig', [
                'user' => $user,
                'conf_company_name' => $conf_company_name,
            ]);

            $mailer->sendMessage($conf_company_name, $conf_server_email, $conf_company_email, 'Nouvelle inscription via votre site internet', $bodyMailAdmin);

            $this->addFlash('success', 'Merci pour votre inscription ! Vous recevrez un email une fois votre compte verifié et validé');
            return $this->redirectToRoute('home');
        }

        return $this->render('bundles/FOSUserBundle/Registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}