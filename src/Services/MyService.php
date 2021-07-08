<?php

namespace App\Services;

use App\Repository\ConfigurationRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * Class MyServoce
 */
class MyService
{

        private $productRepository;
        private $session;
        private $configurationRepository;

        public function __construct(ProductRepository $productRepository, SessionInterface $session, ConfigurationRepository $configurationRepository )
        {
            $this->productRepository = $productRepository;
            $this->session = $session;
            $this->configurationRepository = $configurationRepository;
        }

        public function setCart(array $carts = null, int $id, int $qtt = 0){
            if (null !== $carts) {
                $find = false;

                foreach ($carts as &$cart) {
                    if ($cart['id'] == $id ) {
                        $find = true;
                        $cart['qtt'] = $qtt;
                        break;
                    }
                }
                
                if (!$find) {
                    $carts[] = [
                        'id' => $id,
                        'qtt' => $qtt,
                    ];
                }
            } else {
                $carts = [];
                $carts[] = [
                    'id' => $id,
                    'qtt' => $qtt,
                ];
            }

            return $carts;
        }

        public function getCart(){
            $carts = $this->session->get('carts');
           
            if(!empty($carts)){
                foreach ($carts as &$cart) {
                    $cart['object'] = $this->productRepository->find($cart['id']);
                }
            }
            
            return $carts;
        }

        public function countCart(){
            $countCart = 0;
            $carts = $this->session->get('carts');
            if(!empty($carts)){
                foreach($carts as $cart){
                    $countCart += $cart['qtt'];
                }
            }else{
                $countCart = 0;
            }
            return $countCart;
        }

        public function getDelivery()
        {
            $carts = $this->getCart();
            $withDelivery = true;
            $weight = 0;
            $delivery = 0;
            $delivery1 = $this->configurationRepository->findOneByName('delivery1')->getValue();
            $delivery2 = $this->configurationRepository->findOneByName('delivery2')->getValue();
            $maxDeliveryKillo = $this->configurationRepository->findOneByName('max_delivery_killo')->getValue();

            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    if ($cart['object']->getWithDelivery() <= 0) {
                        $withDelivery = false;
                        if(!empty($cart['object']->getWeight())){
                            $weight += $cart['object']->getWeight()->getValue();
                        }
                    }
                }

                if(!$withDelivery){
                   if($weight > $maxDeliveryKillo){
                    $delivery = $delivery2;
                   }else{
                    $delivery = $delivery1;
                   }
                }
            }

            return $delivery;
        }

        // public function getTotal()
        // {
        //     $carts = $this->getCart();
        //     $tva = $this->configurationRepository->findOneByName('tva');
        //     $tva = ( 1 + $tva->getValue()/100);
           

        //     if (!empty($carts)) {
        //         $total = 0;
        //         foreach ($carts as $cart) {
        //             if ($cart['object']->getSolde() > 0) {
        //                 $total += $cart['object']->getPriceSolde() * $cart['qtt'];
        //             } else {
        //                 $total += $cart['object']->getPrice() * $cart['qtt'];
        //             }
        //         }

        //         if($this->getDelivery() > 0 ){
        //             $total = $total + $this->getDelivery();
        //         }
                
        //         $total = round($total*$tva, 2);
        //         return $total;
        //     }
        //     return 0;
        // }

        public function getTotal($promoCode = null)
        {
            $carts = $this->getCart();
            if (!empty($carts)) {
                $total = 0;
                foreach ($carts as $cart) {
                    if ($cart['object']->getSolde() > 0) {
                        $total += $cart['object']->getPriceSolde() * $cart['qtt'];
                    } else {
                        $total += $cart['object']->getPrice() * $cart['qtt'];
                    }
                }


                if(!empty($promoCode)){
                    $total = $total - ((floatval($promoCode)*$total)/100);
                }


                if($this->getDelivery() > 0 ){
                    $total = $total + $this->getDelivery();
                }

                return number_format($total,2);
            }
            return 0;
        }

        // FONCTION GENERATE TOKEN
        public function getToken($length) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

}