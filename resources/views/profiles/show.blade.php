@extends('layouts.app')

@section('content')
    <div class="container page-header">
        <div class="level">
            <h1>
                {{ $profileUser->name }}
                <small class="text-muted">
                    Created {{ $profileUser->created_at->diffForHumans() }}
                </small>
            </h1>
        </div>
        <hr>
        @foreach($threads as $thread)
            <div class="card shadow-sm bg-white rounded mb-3">
                <div class="card-header bg-white">

                    <div class="level">
                        <span class="flex-fill">
                           <a href="#">{{ $thread->creator->name}}</a>
                            <a href="{{$thread->path()}}" class="text-muted">
                                posted:
                                {{ $thread->title }}
                            </a>
                        </span>
                        <span>
                            {{ $thread->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        @endforeach

        {{ $threads->links() }}
    </div>
@endsection
