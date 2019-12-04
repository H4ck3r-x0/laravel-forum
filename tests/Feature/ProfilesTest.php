<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
    public function a_user_has_profile()
    {
        $user = create('App\User');

        $this->get("/profiles/{$user->username}")
            ->assertSee($user->name);
    }

   /** @test */
    public function profiles_display_all_threads_created_by_the_associated_user()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get("/profiles/". auth()->user()->username)
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
}
