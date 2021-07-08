<?php

namespace App\Controller\front;

use App\Entity\Command;
use App\Entity\Product;

use App\Services\Mailer;
use App\Form\ProductType;
use App\Entity\Information;
use App\Entity\ProductCard;
use App\Services\MyService;
use App\Form\InformationType;
use App\Form\ProductCardType;
use App\Entity\CommandProduct;
use App\Services\StripeService;
use App\Services\GeneratePdfService;
use Symfony\Component\Asset\Package;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\PromotionalRepository;
use App\Repository\ConfigurationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;

/**
 * @Route("/produit")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_all", methods="GET")
     */
    public function productAll(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request): Response
    {

        $products = $paginator->paginate(
            $productRepository->findBy(['isActive' => true], ['updatedAt' => 'ASC']),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('front/product/product_all.html.twig', [
            'products' => $products,
            'slug' => 'product',
        ]);
    }


    /**
     * @Route("/categorie/{id}/{name}", name="product_category", methods="GET")
     */
    public function productDetail(ProductRepository $productRepository, PaginatorInterface $paginator, Request $request, int $id, CategoryRepository $categoryRepository): Response
    {
        $category =  $categoryRepository->findOneById($id);
        $products = $paginator->paginate(
            $productRepository->findBy(['category' => $id], ['updatedAt' => 'ASC']),
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('front/product/product_category.html.twig', [
            'category' => $category,
            'products' => $products,
            'slug' => 'product',
        ]);
    }


    /**
     * @Route("/{id}/{title}", name="product", methods="GET|POST")
     */
    public function product(ProductRepository $productRepository, Product $product, int $id, Request $request, Session $session, ConfigurationRepository $configurationRepository): Response
    {
        $productCard = new ProductCard;
        $myService = new MyService($productRepository, $session, $configurationRepository);
        $form = $this->createForm(ProductCardType::class, $productCard);
        $form->handleRequest($request);
        $carts = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $carts = $session->get('carts');
            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    if ($cart['id'] == $id) {
                        $this->addFlash('warning', 'Ce produit existe déjà dans le panier!');
                    }
                }
            }
            $qtt = $productCard->getQuantity();
            $id = $product->getId();
            $carts = $myService->setCart($carts, $id, $qtt);
            $session->set('carts', $carts);
            return $this->redirectToRoute('cart');
        }

        return $this->render('front/product/product.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
            'products' => $productRepository->findBySimilar(
                [
                    'category' => $product->getCategory(),
                ],
                $id,
                3
            ),
            'slug' => 'product',
        ]);
    }

    /**
     * @Route("/panier", name="cart", methods="GET|POST")
     */
    public function cart(ProductRepository $productRepository, Request $request, Session $session, ConfigurationRepository $configurationRepository): Response
    {
        $maxKillo = $configurationRepository->findOneByName('max_killo');
        $myService = new MyService($productRepository, $session, $configurationRepository);
        $carts = [];

        //  echo"<pre>";
        //  var_dump($session->get('carts'));
        //  echo"</pre>";

        if ($request->getMethod() == 'POST') {


            $qtt = $request->get('qtt');
            $id =  $request->get('id');

            $carts = $session->get('carts');
            $carts = $myService->setCart($carts, $id, $qtt);
            $session->set('carts', $carts);
            return $this->redirectToRoute('cart');
        }

        $products = $myService->getCart();

        return $this->render('front/product/cart.html.twig', [
            'max_killo' => $maxKillo,
            'products' => $products,
            'slug' => 'cart',
        ]);
    }

    /**
     * @Route("/delete/{id}", name="product_delete", methods="DELETE")
     */
    public function delete(Request $request, Product $product, int $id, Session $session): Response
    {
        $msg = 'Produit enlevé du panier avec succès';
        $carts = $session->get('carts');
        foreach ($carts as $key => $cart) {
            if ($cart['id'] == $id) {
                unset($carts[$key]);
                break;
            }
        }

        $session->set('carts', $carts);
        $this->addFlash('success', $msg);
        return $this->redirectToRoute('cart');
    }


    /**
     * @Route("/coordonnees", name="product_information", methods="GET|POST")
     */
    public function information(ProductRepository $productRepository, Request $request, Session $session, ConfigurationRepository $configurationRepository, PromotionalRepository $promotionalRepository): Response
    {
        $information = new Information;
        $data = $session->get('information');

        // echo"<pre>";
        //     var_dump($data);
        // echo"</pre>";
        $form = $this->createForm(InformationType::class, $information);
        if (!empty($data)) {
            $form->get('firstname')->setData($data['firstname']);
            $form->get('lastname')->setData($data['lastname']);
            $form->get('email')->setData($data['email']);
            $form->get('phone')->setData($data['phone']);
            $form->get('address')->setData($data['address']);
            $form->get('zipcode')->setData($data['zipcode']);
            $form->get('city')->setData($data['city']);
        }
        $form->handleRequest($request);
        $msg = 'Désolé. vous n\'avez pas accès à cette page';
        $carts = $session->get('carts');

        if (!empty($carts)) {
            if ($request->getMethod() == 'POST') {
                $total = $request->get('total');
                if (!empty($total)) {
                    $cart_total = $session->get('cart_total');
                    $cart_total['total'] = $total;
                    $session->set('cart_total', $cart_total);
                }
            }


            if ($form->isSubmitted() && $form->isValid()) {
                $data['firstname'] = $information->getFirstname();
                $data['lastname'] = $information->getLastname();
                $data['email'] = $information->getEmail();
                $data['phone'] = $information->getPhone();
                $data['address'] = $information->getAddress();
                $data['zipcode'] = $information->getZipcode();
                $data['city'] = $information->getCity();
                
                if(!empty($information->getCode())){
                    $promotional = $promotionalRepository->findOneByCode($information->getCode());
                    $data['solde'] = $promotional->getSolde();
                }

                $session->set('information', $data);
                return $this->redirectToRoute('product_payment');
            }
        } else {
            $this->addFlash('danger', $msg);
            return $this->redirectToRoute('cart');
        }

        $myService = new MyService($productRepository, $session, $configurationRepository);
        $products = $myService->getCart();

        return $this->render('front/product/information.html.twig', [
            'products' =>  $products,
            'slug' => 'cart',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/paiement", name="product_payment", methods="GET|POST")
     */
    public function payment(RouterInterface $router, ProductRepository $productRepository, Request $request, Session $session, ConfigurationRepository $configurationRepository): Response
    {
        $data = $session->get('information');
        $myService = new MyService($productRepository, $session, $configurationRepository);
        $products = $myService->getCart();
        $carts = $session->get('carts');
        $cart_total = $session->get('cart_total');
        $msg = 'Désolé. vous n\'avez pas accès à cette page';
        $pk_stripe = $this->getParameter('conf_pk_stripe');

        if(!empty($data['solde'])){
            $total = $myService->getTotal($data['solde']);
            $oldtotal = $myService->getTotal();
        }else{
            $total = $myService->getTotal();
            $oldtotal = 0;
        }
        
        $delivery = $myService->getDelivery();
        $tva = $configurationRepository->findOneByName('tva');

        // echo"<pre>";
        //     var_dump($delivery);
        // echo"</pre>";

        if (!empty($carts) && !empty($data) && !empty($cart_total)) {
            $absPath = $this->getParameter('kernel.project_dir').'/public/';
            $package = new Package(new JsonManifestVersionStrategy($absPath.'build/manifest.json'));
            $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
            $data['image'] = $baseurl.$package->getUrl('build/images/default-image.png');
            $data['name'] = $this->getParameter('conf_company_name');
            $data['description'] = 'Paiement de ' . $data['firstname'] . ' ' . $data['lastname'];
            $data['amount'] = $total * 100;
            $data['success_url'] = $baseurl . $router->generate('payment_success');
            $data['cancel_url'] = $baseurl . $router->generate('payment_cancel');
            $session->set('information', $data);
        } else {
            $this->addFlash('danger', $msg);
            return $this->redirectToRoute('cart');
        }

        if (!empty($data)) {
            $sk_stripe = $this->getParameter('conf_sk_stripe');
            $stripeSevice = new StripeService($sk_stripe);
            $checkout = $stripeSevice->checkout($data);
            $data['stripeKey'] = $checkout->payment_intent;
            $session->set('information', $data);
        }

        return $this->render('front/product/payment.html.twig', [
            'tva' => $tva->getValue(),
            'delivery' => $delivery,
            'total' => $total,
            'oldtotal' => $oldtotal,
            'information' => $data,
            'products' =>  $products,
            'slug' => 'cart',
            'pk_stripe' => $pk_stripe,
            'session_id' => $checkout->id,
        ]);
    }

    /**
     * @Route("/paiement-accepte", name="payment_success", methods="GET")
     */
    public function paymentSuccess(ProductRepository $productRepository, Session $session, Request $request, Mailer $mailer, ConfigurationRepository $configurationRepository): Response
    {
        $command = new Command;

        $data = $session->get('information');
        $myService = new MyService($productRepository, $session, $configurationRepository);
        $products = $myService->getCart();
        $productKey = $myService->getToken(12);
        $data['productKey'] = $productKey;
        $session->set('information', $data);
       if(!empty($data['solde'])){
            $total = $myService->getTotal($data['solde']);
            $oldtotal = $myService->getTotal();
        }else{
            $total = $myService->getTotal();
        }
        $delivery = $myService->getDelivery();
        $tva = $configurationRepository->findOneByName('tva');

        $data['conf_server_email'] = $this->getParameter('conf_server_email');
        $data['conf_company_name'] = $this->getParameter('conf_company_name');
        $data['conf_company_business'] = $this->getParameter('conf_company_business');
        $data['conf_company_siret'] = $this->getParameter('conf_company_siret');
        $data['conf_company_phone'] = $this->getParameter('conf_company_phone1');
        $data['conf_company_email'] = $this->getParameter('conf_company_email');
        $data['conf_company_email2'] = $this->getParameter('conf_company_email2');
        $data['conf_company_address'] = $this->getParameter('conf_company_address');
        $data['conf_company_zipcode'] = $this->getParameter('conf_company_zipcode');
        $data['conf_company_city'] = $this->getParameter('conf_company_city');
        $baseurl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath();
        $data['url_website'] = $baseurl;
        $data['productKey'] = $productKey;
        $data['total'] = $total;
        $data['oldtotal'] = $oldtotal;
        $data['delivery'] = $delivery;
        $data['tva'] = $tva->getValue();
        $data['products'] = $products;

        $em = $this->getDoctrine()->getManager();
        $command->setOrderKey($data['productKey']);
        $command->setFirstname($data['firstname']);
        $command->setLastname($data['lastname']);
        $command->setEmail($data['email']);
        $command->setPhone($data['phone']);
        $command->setAddress($data['address']);
        $command->setZipcode($data['zipcode']);
        $command->setCity($data['city']);
        $command->setStripeKey($data['stripeKey']);

        foreach ($products as $product) {
            $commandProduct = new CommandProduct;
            $commandProduct->setQuantity($product['qtt']);
            $commandProduct->setPrice($product['object']->getPrice());
            $commandProduct->setProduct($product['object']);
            $em->persist($commandProduct);
            $command->addCommandProduct($commandProduct);
        }

        $absPath = $this->getParameter('kernel.project_dir').'/public/';
        $filename = $absPath."upload/billing/facture_".$productKey.".pdf";

        $command->setBilling("facture_".$productKey.".pdf");

        $generatePdfService = new GeneratePdfService;
        $template = $this->renderView('front/product/billing/billing.html.twig',[
            'data' => $data,
        ]);
        $generatePdfService->Pdf($filename, $template);
        
        $MailerConfirmation = 'front/product/mail/mail_confirmation.html.twig';
        $MailerAdmin = 'front/product/mail/mail_admin.html.twig';
        // MAILER
        $this->mailerConfirmation($mailer, $data, $MailerConfirmation, $filename);
        $this->mailerAdmin($mailer, $data, $MailerAdmin, $filename);
        // END MAILER

        $em->persist($command);
        $em->flush();

        $session->remove('information');
        $session->remove('carts');
        $this->addFlash('success', 'Paiement accepté ! Merci pour votre commande et votre confiance !');
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/paiement-refuse", name="payment_cancel", methods="GET")
     */
    public function paymentCancel(RouterInterface $router, Session $session, Request $request): Response
    {
        $session->remove('information');
        $session->remove('carts');
        $this->addFlash('danger', 'Votre paiement a été decliné !');
        return new RedirectResponse($router->generate('home'));
    }

    ////////////////////////
    //// ADMIN MAIL ///////
    //////////////////////

    public function mailerAdmin($mailer, $data, $folder, $attachement){

        // on utilise le service Mailer créé précédemment
        //$session = new Session;
        //$data = $session->get('paymentSession');
    
        $bodyMailContact = $mailer->createBodyMail($folder, ['data' => $data]);
        
        $mailer->sendMessage(
            $data['conf_company_name'], 
            $data['conf_server_email'], 
            $data['conf_company_email'], 
            'Une personne viens de faire un achat sur votre site '.$data['conf_company_name'].' - '.$data['productKey'], $bodyMailContact,$data['conf_company_email2'],
            $attachement
        );
    }

    //////////////////////////
    //// CONFIRMATION MAIL //
    ////////////////////////

    public function mailerConfirmation($mailer, $data, $folder, $attachement){

        // on utilise le service Mailer créé précédemment

        $bodyMailConfirmation = $mailer->createBodyMail($folder, ['data'=>$data]);

        $mailer->sendMessage(
            $data['conf_company_name'], 
            $data['conf_server_email'], 
            $data['email'], 
            'Confirmation - '.$data['conf_company_name'].' - '.$data['productKey'], 
            $bodyMailConfirmation,
            null,
            $attachement
        );
    }
}
