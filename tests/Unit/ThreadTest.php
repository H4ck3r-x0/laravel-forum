<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ThreadTest extends TestCase
{
   use RefreshDatabase;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_thread_has_a_path()
    {
        $thread = create('App\Thread');

        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->slug}",
            $thread->path()
        );
    }

   /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

   /** @test */
    public function a_thread_has_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

   /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'user_id' => 1,
            'body' => 'Good Thread'
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        $this->signIn()
            ->thread
            ->subscribe()
            ->addReply([
            'user_id' => 1001,
            'body' => 'Good Thread'
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);

    }

    /** @test */
    public function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }

    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_the_replies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $user = auth()->user();

        $this->assertTrue($thread->hasUpdatesFor($user));

        $user->read($thread);

        $this->assertFalse($thread->hasUpdatesFor($user));

    }

    /** @test */
    public function a_thread_record_each_visit()
    {
        $thread = make('App\Thread', ['id' => 1]);
        $thread->visits()->reset();
        $this->assertSame(0, $thread->visits()->count());

        $thread->visits()->record();
        $this->assertEquals(1, $thread->visits()->count());
    }

    /** @test */
    public function a_threads_body_is_sanitized_automatically()
    {
        $thread = make('App\Thread', ['body' => '<script>alert("bad")</script><p>It is okey!</p>']);
        $this->assertEquals('<p>It is okey!</p>', $thread->body);
    }
}
