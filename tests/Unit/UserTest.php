<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('App\User');
        $reply = create('App\Reply', ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {
        $user = create('App\User');
        $this->assertEquals(asset('images/avatars/default.png'), $user->avatar_path);

        $user->avatar_path = 'avatars/my.png';
        $this->assertEquals(asset('avatars/my.png'), $user->avatar_path);

    }
}
