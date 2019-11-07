<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Thread $thread, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);

        return back();
    }
}
