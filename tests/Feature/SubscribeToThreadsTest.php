<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_subscribe_to_a_thread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_a_thread()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $this->delete($thread->path() . '/subscriptions');

        $this->assertCount(0, $thread->subscriptions);

    }
}
