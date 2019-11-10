@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">Forum Threads</div>

                    <div class="card-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="level">
                                    <h4 class="flex-fill">
                                        <a href="{{ $thread->path() }}">
                                            {{ $thread->title }}
                                        </a>

                                        <a href="{{ $thread->path() }}">
                                             <span class="badge badge-light">
                                            {{ $thread->replies_count }}
                                                 {{ Str::plural('reply'), $thread->replies_count }}
                                            </span>
                                        </a>
                                    </h4>

                                </div>

                                <div class="body">
                                    {{ $thread->body }}
                                </div>
                            </article>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
