<?php

namespace App\paymentGateways;

use App\payments\paymentMethod;

interface gatewayCustomer
{
    public function charge(paymentMethod $card, $amount);

    public function addCard($token);

}
