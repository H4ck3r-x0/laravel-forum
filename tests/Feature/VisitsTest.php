<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Visits;

class VisitsTest extends TestCase
{

    use RefreshDatabase;


    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = create('App\Thread');

        $this->visits = new Visits($this->thread);
        $this->visits->reset();
    }

    /** @test */
    public function visits_may_incrments_once_by_one_guest()
    {
        $this->assertEmpty($this->visits->get());

        $this->call('GET', $this->thread->path(), [], [], [], ['REMOTE_ADDR' => '127.1.1.1'], []);
        $this->assertEquals("1", $this->visits->count());

        $this->call('GET', $this->thread->path(), [], [], [], ['REMOTE_ADDR' => '127.1.1.1'], []);
        $this->assertEquals("1", $this->visits->count());

        $this->call('GET', $this->thread->path(), [], [], [], ['REMOTE_ADDR' => '127.1.1.2'], []);
        $this->assertEquals("2", $this->visits->count());

    } 








}
