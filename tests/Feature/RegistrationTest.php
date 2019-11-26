<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();
        event(new Registered(create('App\User')));
        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    /** @test */
    public function users_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();
        $this->post('/register', [
           'name' => 'Mohammed',
           'email' => 'mohammed@example.com',
           'password' => 'password',
           'password_confirmation' => 'password',
        ]);
        $user = User::whereName('Mohammed')->first();
        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $response = $this->get('/register/confirm?token=' . $user->confirmation_token);
        $this->assertTrue($user->fresh()->confirmed);
        $this->assertNull($user->fresh()->confirmation_token);

        $response->assertRedirect('/threads');
    }

    /** @test */
    public function confirming_an_invalid_token()
    {
        $this->get('/register/confirm?token=invalid')
            ->assertRedirect('/threads')
            ->assertSessionHas('flash', 'Unknown token.');
    }
}
