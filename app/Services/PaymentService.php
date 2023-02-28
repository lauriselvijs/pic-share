<?php

namespace App\Services;

use App\Models\User;

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
     */
    public function makePayment(User $user, string $price, string $paymentMethodId): void
    {
        $user->charge(floatval($price) * 100, $paymentMethodId);
    }
}
