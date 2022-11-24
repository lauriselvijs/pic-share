<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class PaymentController extends Controller
{

    /**
     * Redirects user to charging page
     *
     * @param Post $post
     * @return View
     */
    public function charge(Post $post): View
    {
        $this->authorize('buy', $post);

        $user = auth()->user();

        return view('payment.index', [
            'user' => $user,
            'intent' => $user->createSetupIntent(),
            'post' => $post,
        ]);
    }

    public function process(Request $request, Post $post)
    {
        $user = auth()->user();
        $paymentMethod = $request->input('payment_method');
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);

        try {
            $user->charge($post->price * 100, $paymentMethod);
        } catch (Exception $error) {
            return back()->withErrors(['message' => __('payment.error', ['error' => $error->getMessage()])]);
        }
        return redirect()->route('posts.index')->with('message',  __('payment.success'));
    }
}
