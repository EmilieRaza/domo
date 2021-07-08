<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Class AfterLoginRedirection
 *
 * @package App\Services
 */
class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    private $router;

    private $om;

    private $session;

    private $security;

    /**
     * AfterLoginRedirection constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router, EntityManagerInterface $om, SessionInterface $session, Security $security)
    {
        $this->router = $router;
        $this->om = $om;
        $this->session = $session;
        $this->security = $security;
    }

    /**
     * @param Request $request
     *
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {   
        $user = $this->om->getRepository(\App\Entity\User::class)->findOneByUsername($token->getUsername());

        $msg = 'Bienvenue '.$user->getFirstname().' '.$user->getLastname();
        $user->setLastLogin(new \DateTime('now'));
        $this->om->flush();
        $this->session->getFlashBag()->add('success', $msg);

        if ($this->security->isGranted('ROLE_ADMIN')) {
            // c'est un aministrateur : on le rediriger vers l'espace admin
            $redirection = new RedirectResponse($this->router->generate('admin'));
        } else {
            // c'est un utilisaeur lambda : on le rediriger vers l'accueil
            $redirection = new RedirectResponse($this->router->generate('home'));
        }

        return $redirection;
    }
}