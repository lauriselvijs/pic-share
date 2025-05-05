<?php

namespace Tests\Feature;

use App\Events\UserRegisteredEvent;
use App\Models\User;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if user can visit signup page and see create an account text
     */
    public function test_visit_signup_page_and_see_create_an_account_text(): void
    {
        $response = $this->get(route('auth.create'));

        $response->assertOk();
        $response->assertSeeText('Create an account');
    }

    /**
     * Tests creating new user.
     */
    public function test_create_new_user(): void
    {
        // Create user and check if redirected to email verification page
        Event::fake([UserRegisteredEvent::class, Registered::class]);
        Notification::fake(UserRegisteredNotification::class);

        $response = $this->post(route('auth.create'), [
            'name' => 'John',
            'email' => 'john@mail.com',
            'agreement' => 'true',
            'password' => '}YVPrN0e1P81',
            'password_confirmation' => '}YVPrN0e1P81',
        ]);

        Event::assertDispatched(UserRegisteredEvent::class);
        Event::assertDispatched(Registered::class);
        Notification::assertNothingSent();

        $response->assertSessionHasNoErrors();

        $response->assertRedirect(route('verification.notice'));

        // Check if user exists in DB
        $user = User::where('name', 'John')->first();

        assertNotNull($user);

        // Check if created user can see email verification message
        $response = $this->get(route('verification.notice'));

        $response->assertOk();
        $response->assertSeeText('Check your inbox');
    }
}
