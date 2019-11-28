<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_threads()
    {
        config(['scout.driver' => 'algolia']);
        $search = "Laravel";
        create('App\Thread', [], 2);
        create('App\Thread', ['body' => "This {$search} framework is awesome."], 2);
        do {
            sleep(.25);
            $results = $this->getJson("/threads/search?query={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);
        Thread::latest()->take(4)->unsearchable();
    }
}
