<?php
namespace App\paymentGateways\gateways;

use App\Exceptions\paymentFailedException;
use App\paymentGateways\gateway;
use App\paymentGateways\gatewayCustomer;
use App\payments\paymentMethod;
use Exception;
use Stripe\Customer as stripeCustomer;
use Stripe\Charge as stripeCharge;

class stripeGatewayCustomer implements gatewayCustomer
{
    protected $customer;
    protected $gateway;

    public function __construct(gateway $gateway, stripeCustomer $customer)
    {
        $this->gateway = $gateway;
        $this->customer = $customer;
    }

    public function charge(paymentMethod $card, $amount)
    {
        try {
            stripeCharge::create([
                'currency' => 'usd',
                'amount'   => $amount,
                'customer' => $this->customer->id,
                'source'   => $card->provider_id
            ]);
        } catch (Exception $e) {
            throw new paymentFailedException;
        }

    }

    public function addCard($token)
    {
        $card = $this->customer->sources->create([
            'source' => $token
        ]);

        $this->customer->default_source = $card->id;
        $this->customer->save();

        return $this->gateway->user()->paymentMethods()->create([
            'provider_id' => $card->id,
            'card_type'   => $card->brand,
            'last_four'   => $card->last4,
            'default'     => true
        ]);

    }

    public function id()
    {
        return $this->customer->id;
    }
}
