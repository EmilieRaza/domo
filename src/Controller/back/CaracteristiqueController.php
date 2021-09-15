<?php

namespace App\Controller\back;

use App\Entity\Product;
use App\Entity\Caracteritique;
use App\Form\ProductType;
use App\Entity\Caracteristique;

use App\Entity\TitleCaracteristique;
use App\Repository\ProductRepository;
use App\Repository\CaracteristiquetRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TitleCaracteristiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/produit")
 */
class CaracteristiqueController extends AbstractController
{
    /**
     * @Route("/{id}/caracteristique/liste/", name="admin_caracteristique_search", methods="GET")
     */
    public function search(TitleCaracteristiqueRepository $titleCaracteristiqueRepository,Product $product): Response
    {
        return $this->render('back/caracteristique/search.html.twig', [
            'titleCaracts' => $titleCaracteristiqueRepository->findBy(['product'=>$product]), 
            'slug'=>'admin_category', 
        ]);
    }

     /**
     * @Route("/caracteristique/create", name="admin_caracteristique_create", methods="GET|POST")
     */
    public function create(Request $request,TitleCaracteristiqueRepository $titleCaracteristiqueRepositoryi): Response
    {        

        
        $titleCaracteristique = new TitleCaracteristique();
        $form = $this->createForm(ProductType::class, $titleCaracteristique, [
            'update' => $titleCaracteristique->getId()==null?false:true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($titleCaracteristique);
            $em->flush();

            return $this->redirectToRoute('admin_caracteristique_search');
        }

        return $this->render('back/caracteristique/create.html.twig', [
            'titleCaracteristique' => $titleCaracteristique,
            'form' => $form->createView(),
            'slug' => 'admin_product',
        ]);
    }
}