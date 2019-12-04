<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $mohammed = create('App\User', ['username' => 'mohammed']);
        $this->signIn($mohammed);

        $saleh = create('App\User', ['username' => 'saleh']);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
           'body' => '@saleh I need your help.'
        ]);
        $this->json('post',$thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $saleh->notifications);

    }

    /** @test */
    function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User', ['name' => 'johndoe']);
        create('App\User', ['name' => 'johndoe2']);
        create('App\User', ['name' => 'janedoe']);
        $results = $this->json('GET', '/api/users', ['name' => 'john']);
        $this->assertCount(2, $results->json());
    }
}
