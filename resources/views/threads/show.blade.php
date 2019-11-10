@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name}}</a>
                        posted:
                        {{ $thread->title }}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include ('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @if (auth()->check())
                    <form method="POST" action="{{ $thread->path() . '/replies' }}" class="mt-4">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" id="body" rows="3" class="form-control"
                                      placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                @else
                    <p class="text-center">
                        Please <a href="{{ route('login') }}">sign in</a> to participate in the forum.
                    </p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <span class="text-muted">
                            This thread was publish {{ $thread->created_at->diffForHumans() }} by
                            <a href="@">{{ $thread->creator->name }}</a>
                            and currently has {{ $thread->replies_count }}
                            {{ Str::plural('comment', $thread->replies_count) }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
