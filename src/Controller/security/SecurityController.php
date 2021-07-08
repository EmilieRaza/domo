<?php

namespace App\Controller\security;

use App\Entity\User;
use App\Services\Mailer;
use App\Form\UpdateUserType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Repository\ConfigurationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController
{
    
    /**
     * @Route("/admin/user/search", name="admin_security_search")
     * @return Response
    */

    public function index(UserRepository $userRepository): Response
    {
        return $this->render('security/search.html.twig', [
            'users' => $userRepository->findBy([],['id' => 'DESC']),
            'slug' => 'admin_security_search'
        ]);
    }

    // /**
    //  * @Route("/admin/user/{id}", name="admin_security_read", methods="GET")
    //  */
    // public function read(Product $product): Response
    // {
    //     return $this->render('back/product/read.html.twig', [
    //         'product' => $product,
    //         'slug' => 'admin_product',
    //     ]);
    // }

    /**
     * @Route("/admin/user/supprimer/{id}", name="admin_security_delete", methods="DELETE")
     * @param User $user
    */

    public function delete(User $user)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès');
            return $this->redirectToRoute('admin_security_search');
    }

     /**
     * @Route("/admin/user/isactive/{id}", name="admin_security_isactive", methods="ISACTIVE")
     * @param User $user
    */

    public function isEnabled(User $user, Mailer $mailer)
    {
            $param = $user->isEnabled();
            $conf_company_name = $this->getParameter('conf_company_name');
            $conf_server_email = $this->getParameter('conf_server_email');

            if(!$param){
                $param = true;
            }else{
                $param = false;
            }

            $user->setEnabled($param);
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            if($user->isEnabled()){
                // on utilise le service Mailer créé précédemment
                $bodyMailUser = $mailer->createBodyMail('security/mail/mail_enabled.html.twig', [
                    'user' => $user,
                    'conf_company_name' => $conf_company_name
                ]);

                $mailer->sendMessage($conf_company_name, $conf_server_email, $user->getEmail(), 'Compte activé', $bodyMailUser);
            }

            $this->addFlash('success', 'L\'utilisateur a été modifié avec succès');
            return $this->redirectToRoute('admin_security_search');
    }
}
