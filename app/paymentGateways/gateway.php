<?php

namespace App\paymentGateways;

use App\User;

interface gateway
{
    public function withUser(User $user);

    public function createCustomer();

}
