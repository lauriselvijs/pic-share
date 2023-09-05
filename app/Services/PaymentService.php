<?php

namespace App\Services;

use App\Models\User;
use Laravel\Cashier\Exceptions\IncompletePayment;

class PaymentService
{

    /**
     * Remove special characters from name
     */
    public function normalizeName(string $name): string
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT', $name);
    }

    /**
     * Make payment
     * 
     * @throws IncompletePayment
     */
    public function makePayment(User $user, string $price, string $paymentMethodId): void
    {
        $user->charge((float) $price * 100, $paymentMethodId);
    }
}
