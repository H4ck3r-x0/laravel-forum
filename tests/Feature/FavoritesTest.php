<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_favorite_anything()
    {

        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
            ->assertRedirect('/login');

    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {

        $this->signIn();

        $reply = create('App\Reply');

        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_a_reply()
    {

        $this->signIn();

        $reply = create('App\Reply');

        $reply->favorite();


        $this->delete('/replies/' . $reply->id . '/favorites');

        $this->assertCount(0, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create('App\Reply');

        try
        {
            $this->post('/replies/' . $reply->id . '/favorites');
            $this->post('/replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('We did not expect to insert the same record set twice');
        }

        $this->assertCount(1, $reply->favorites);

    }
}
