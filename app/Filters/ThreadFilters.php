<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular', 'unanswered'];

    /**
     * Filter the threads by the username
     * @param $username
     * @return mixed
     */
    protected function by($username)
    {
        $user = User::where('username', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the threads by popularity
     * @return mixed
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');
    }

    public function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
