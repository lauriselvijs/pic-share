<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test if user can sign up.
     *
     * @return void
     */
    public function testSignUp()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('auth.create')
                ->type('name', 'John')
                ->type('email', 'john@mail.com')
                ->type('password', '123456')
                ->type('password_confirmation', '123456')
                ->check('agreement')
                ->press('Sign up')
                ->waitForRoute('verification.notice')
                ->assertRouteIs('verification.notice');
        });
    }
}
