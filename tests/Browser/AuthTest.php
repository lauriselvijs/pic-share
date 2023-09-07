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
                ->type('password', '}YVPrN0e1P81')
                ->type('password_confirmation', '}YVPrN0e1P81')
                ->check('agreement')
                ->press('Sign up')
                ->waitForRoute('verification.notice')
                ->assertRouteIs('verification.notice');
        });
    }
}
