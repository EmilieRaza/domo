<?php

namespace App\Controller\back;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PagesController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('back/pages/index.html.twig', [
            'slug' => 'admin',
        ]);
    }
    /**
     * @Route("/espace-client", name="espace-client")
     */
    public function indexEspaceClient()
    {
        return $this->render('back/pages/index-espace-client.html.twig', [
            'slug' => 'espace-client',
        ]);
    }
    

    /**
     * @Route("/admin/fos-user-profile-show", name="fos_user_profile_show")
     */
    public function fos_user_profile_show()
    {
        return $this->redirectToRoute('admin');
    }
    
}
