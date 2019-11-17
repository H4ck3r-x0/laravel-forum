<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/channel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test **/
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\User')->create());

        $thread = create('App\Thread');

        $reply = create('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');

    }

    /** @test */
    public function unauthorized_users_can_not_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

    }

    /** @test */
    public function unauthorized_users_can_not_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn();

        $this->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }


    /** @test */
    public function authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->patch("/replies/{$reply->id}", ['body' => 'updated']);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => 'updated']);

    }
}
