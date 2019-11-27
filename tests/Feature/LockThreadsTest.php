<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_admin_may_not_lock_threads()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->post(route('locked-threads.store', $thread))->assertStatus(403);
        $this->assertFalse(! ! $thread->fresh()->locked);
    }

    /** @test */
    public function admin_can_lock_threads()
    {
        $this->signIn(factory('App\User')->states('admin')->create());
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->post(route('locked-threads.store', $thread));
        $this->assertTrue($thread->fresh()->locked, 'Failed asserting that the thread was locked.');
    }

    /** @test */
    public function admin_can_unlock_threads()
    {
        $this->signIn(factory('App\User')->states('admin')->create());
        $thread = create('App\Thread', ['user_id' => auth()->id(), 'locked' => false]);
        $this->delete(route('locked-threads.destroy', $thread));
        $this->assertFalse($thread->fresh()->locked, 'Failed asserting that the thread was unlocked.');
    }

    /** @test */
    public function once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();
        $thread = create('App\Thread', ['locked' => true]);

        $this->post($thread->path() . '/replies', [
            'body' => 'Simple Reply',
            'user_id' => auth()->id()
        ])->assertStatus(422);
    }
}
