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

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests creating new user.
     *
     * @group view
     * @return void
     */
    public function test_create_new_user()
    {
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
    }
}
