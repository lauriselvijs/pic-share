<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Admin;
use App\Events\UserRegisteredEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertNotNull;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests if user can visit signup page and see create an account text
     *
     * @return void
     */
    public function test_visit_signup_page_and_see_create_an_account_text()
    {
        $response = $this->get(route('auth.create'));

        $response->assertOk();
        $response->assertSeeText('Create an account');
    }

    /**
     * Tests creating new user.
     *
     * @return void
     */
    public function test_create_new_user()
    {
        // Create user and check if redirected to email verification page
        Event::fake([UserRegisteredEvent::class, Registered::class]);
        Notification::fake(UserRegisteredNotification::class);

        $response = $this->post(route('auth.create'), [
            'name' => 'John',
            'email' => 'john@mail.com',
            'agreement' => 'true',
            'password' => '123456',
            'password_confirmation' => '123456'
        ]);

        Event::assertDispatched(UserRegisteredEvent::class);
        Notification::assertNothingSent();
        Event::assertDispatched(Registered::class);

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
