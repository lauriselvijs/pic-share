<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{

    public function __construct(private PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

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

    /**
     * Process incoming payment
     *
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function process(Request $request, Post $post): RedirectResponse
    {
        $user = auth()->user();
        $paymentMethod = $request->input('payment_method');

        try {
            $this->paymentService->makePayment($user,  $paymentMethod, $post->price);
        } catch (Exception $error) {
            return back()->withErrors(['message' => __('payment.error', ['error' => $error->getMessage()])]);
        }
        return redirect()->route('posts.index')->with('message',  __('payment.success'));
    }
}
