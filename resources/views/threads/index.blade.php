@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @forelse($threads as $thread)

                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header bg-white">
                            <div class="level">
                                <h4 class="flex-fill">
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->title }}
                                    </a>

                                </h4>
                                <a href="{{ $thread->path() }}">
                                             <span class="badge badge-light">
                                            {{ $thread->replies_count }}
                                                 {{ Str::plural('reply'), $thread->replies_count }}
                                            </span>
                                </a>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="body">
                                {{ $thread->body }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-info">There are no relevant results at this time.</p>
            @endforelse

        </div>
    </div>
@endsection
