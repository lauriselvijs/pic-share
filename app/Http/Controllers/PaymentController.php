<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Laravel\Cashier\Exceptions\IncompletePayment;

class PaymentController extends Controller
{

    public function __construct(private PaymentService $paymentService)
    {
    }

    /**
     * Redirects user to charging page
     */
    public function charge(Request $request, Post $post): View
    {
        $this->authorize('buy', $post);

        $user = $request->user();
        $user->name = $this->paymentService->normalizeName($request->user()->name);

        return view('payment.index', [
            'user' => $user,
            'post' => $post,
        ]);
    }

    /**
     * Process incoming payment
     */
    public function process(Request $request, Post $post): RedirectResponse
    {
        $user = $request->user();
        $paymentMethodId = $request->input('payment_method_id');

        try {
            $this->paymentService->makePayment($user,  $post->price, $paymentMethodId);
        } catch (IncompletePayment $exception) {
            return back()->withErrors(['message' => __('payment.error', ['error' => $exception->payment->status])]);
        }

        return redirect()->route('posts.index')->with('message',  __('payment.success'));
    }
}
