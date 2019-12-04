<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_not_by_the_current_user()
    {
        $user = auth()->user();

        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, $user->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Reply body'
        ]);

        $this->assertCount(0, $user->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Reply body'
        ]);
        $this->assertCount(1, $user->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        create(DatabaseNotification::class);

        $user = auth()->user();

        $this->assertCount(1, $this->getJson("/profiles/{$user->username}/notifications")->json());
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        create(DatabaseNotification::class);

        $user = auth()->user();

        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profiles/{$user->username}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);

    }
}
