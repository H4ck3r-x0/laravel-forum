<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    protected $thread;

    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    public function get()
    {
        return Redis::get($this->cacheKey());
    }  

    public function record()
    {
        if (request()->ip() != Redis::hget("Visits", $this->checkClientIp())) {
            Redis::incr($this->cacheKey());
            Redis::hset("Visits", $this->checkClientIp(), request()->ip());

            return $this;
        }

        return null;    
    }

    public function reset()
    {
        Redis::del($this->cacheKey());
        Redis::del("Visits");

        return $this;
    }

    public function count()
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }

    protected function cacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }


    protected function checkClientIp()
    {
        $client_ip = request()->ip();
        return "threads.{$this->thread->id}:userIp:{$client_ip}";
    }    
}
