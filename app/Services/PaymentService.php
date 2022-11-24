<?php

namespace App\Services;

use App\Models\User;

class PaymentService
{

    /**
     * Create new customer
     *
     * @param User $user
     * @return void
     */
    public function createCostumer(User $user): void
    {
        $user->createOrGetStripeCustomer();
    }

    /**
     * Adds payment method to user
     *
     * @param User $user
     * @param string $paymentMethod
     * @return void
     */
    public function addPaymentMethod(User $user, string $paymentMethod): void
    {
        $user->addPaymentMethod($paymentMethod);
    }

    /**
     * Charge user for purchase
     *
     * @param User $user
     * @param float $price
     * @param string $paymentMethod
     * @return void
     */
    public function charge(User $user, float $price, string $paymentMethod): void
    {
        $user->charge($price * 100, $paymentMethod);
    }

    /**
     * Makes payment to service
     *
     * @param User $user
     * @param string $paymentMethod
     * @param float $price
     * @return void
     */
    public function makePayment(User $user, string $paymentMethod, float $price)
    {
        $this->createCostumer($user);
        // $this->addPaymentMethod($user, $paymentMethod);
        $this->charge($user, $price, $paymentMethod);
    }
}
