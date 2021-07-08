<?php

namespace App\Services;
use Stripe\Stripe;


class StripeService{
    
    private $sk_key;


    public function __construct($sk_key)
    {
        $this->sk_key = $sk_key;
    }

    public function checkout(array $data)
    {
        
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        Stripe::setApiKey($this->sk_key);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'name' => $data['name'],
                'description' => $data['description'],
                'images' => [$data['image']],
                'amount' => $data['amount'],
                'currency' => 'eur',
                'quantity' => 1,
            ]],
            'success_url' => $data['success_url'],
            'cancel_url' => $data['cancel_url'],
        ]);

        return $session;
    }
}