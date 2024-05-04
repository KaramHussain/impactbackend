<?php
namespace App\paymentGateways\gateways;

use App\User;
use App\paymentGateways\gateway;
use App\paymentGateways\gateways\stripeGatewayCustomer;
use Stripe\Customer as StripeCustomer;

class stripeGateway implements gateway
{
    public $user;
    public function withUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function user()
    {
        return $this->user;
    }

    public function createCustomer()
    {
        if($this->user->gateway_customer_id)
        {
            return $this->getCustomer();
        }

        $customer = new stripeGatewayCustomer(
            $this, $this->createStripeCustomer()
        );

        $this->user->update([
            'gateway_customer_id' => $customer->id()
        ]);

        return $customer;
    }

    public function getCustomer()
    {
        return new stripeGatewayCustomer(
            $this, StripeCustomer::retrieve($this->user->gateway_customer_id)
        );
    }

    protected function createStripeCustomer()
    {
        return StripeCustomer::create([
            'name'  => $this->user->first_name,
            'email' => $this->user->email
        ]);
    }

}
