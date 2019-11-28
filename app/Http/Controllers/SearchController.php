<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        if (request()->expectsJson())
        {
            return Thread::search(request('query'))->paginate(15);
        }

        return view('threads.search', [
            'trending' => $trending->get()
        ]);
    }
}
