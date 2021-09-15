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
use App\Repository\GammeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GammeController extends AbstractController
{
    /**
     * @Route("/navbar_gamme", name="home")
     */
    public function index(GammeRepository $gammepository)
    {
        return $this->render('front/blocks/navbar_gamme.html.twig', [
            'gammes' => $gammepository->findAll(),
            // 'slug' => 'product_gamme'
        ]);
    }

}
