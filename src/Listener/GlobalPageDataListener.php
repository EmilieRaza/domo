<?php

namespace App\Listener;

use App\Services\MyService;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;



class GlobalPageDataListener
{
    
    private $myService;
    
    private $twig;

    
    public function __construct(MyService $myService, \Twig_Environment $twig)
    {
        $this->myService = $myService;
        $this->twig = $twig;
    }


    public function onKernelRequest(GetResponseEvent $event)
    {
        $countCart =  $this->myService->countCart();
        $this->twig->addGlobal('count_cart', $countCart);
    }
    
   
}