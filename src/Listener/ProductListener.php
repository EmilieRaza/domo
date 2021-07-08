<?php

namespace App\Listener;


use App\Entity\Product;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;

class ProductListener implements EventSubscriber
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function getSubscribedEvents()
    {
        return [
            'postLoad',
        ];
    }

    public function postLoad(LifecycleEventArgs $args)
    {

        $entity = $args->getEntity();

        if(!$entity instanceof Product){
            return;
        }
    
        if($this->security->isGranted('ROLE_CUSTOMER')) {
            $entity->setIsCustomer(true);
        }
    }
}
