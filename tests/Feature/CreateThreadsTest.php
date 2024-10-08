<?php

namespace Tests\Feature;

use App\Activity;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
        ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function new_users_must_confirm_their_email_address_before_creating_a_thread()
    {
        $user = factory('App\User')->states('unconfirmed')->create();
        $this->signIn($user);

        $thread = make('App\Thread');

        return $this->post('/threads', $thread->toArray())
            ->assertRedirect('/threads')
            ->assertSessionHas('flash');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertStatus(422);
    }

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();
        $thread = create('App\Thread', [
            'title' => 'Hello There',
            'slug' => 'hello-there'
        ]);
        $this->assertEquals($thread->fresh()->slug, 'hello-there');

        $this->post('/threads', $thread->toArray());
        $this->assertTrue(Thread::whereSlug('hello-there-2')->exists());

        $this->post('/threads', $thread->toArray());
        $this->assertTrue(Thread::whereSlug('hello-there-3')->exists());
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertStatus(422);

        $this->publishThread(['channel_id' => 1000])
            ->assertStatus(422);
    }

    /** @test */
    public function unauthorized_users_can_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

         $this->delete($thread->path())
            ->assertRedirect('/login');

         $this->signIn();

        $this->delete($thread->path())
            ->assertStatus( 403);

    }


    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, Activity::count());
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->json('post', '/threads', $thread->toArray());
    }
}
