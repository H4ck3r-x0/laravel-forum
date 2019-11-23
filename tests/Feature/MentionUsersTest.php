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
        $mohammed = create('App\User', ['name' => 'Mohammed']);
        $this->signIn($mohammed);

        $saleh = create('App\User', ['name' => 'Saleh']);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
           'body' => '@Saleh I need your help.'
        ]);
        $this->json('post',$thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $saleh->notifications);


    }
}
