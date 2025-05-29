<?php

uses(\Tests\DuskTestCase::class);
use Laravel\Dusk\Browser;

uses(\Illuminate\Foundation\Testing\DatabaseMigrations::class);

test('sign up', function () {
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
});