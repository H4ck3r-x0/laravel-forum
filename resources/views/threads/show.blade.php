@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/vendor/jquery.atwho.css') }}" rel="stylesheet">
@endsection

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8 ">
                    <div class="card shadow-sm bg-white rounded">
                        <div class="card-header bg-white">
                            <div class="level">
                                <div class="flex-fill">
                                    <img
                                        class="mr-1 rounded-circle"
                                        width="32"
                                        height="32"
                                        src="{{ asset($thread->creator->avatar_path) }}"
                                        alt="{{ $thread->creator->name }}">
                                    <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name}}</a>
                                    <span class="text-muted">
                                    posted:
                                    {{ $thread->title }}
                                </span>
                                </div>
                                @can ('update', $thread)
                                    <form method="POST" action="{{ $thread->path() }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies
                        class="mt-3"
                        @added="repliesCount++"
                        @removed="repliesCount--">
                    </replies>

                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm  mb-5 bg-white rounded">
                        <div class="card-body">
                            <span class="text-muted">
                                This thread was publish {{ $thread->created_at->diffForHumans() }} by
                                <a href="@">{{ $thread->creator->name }}</a>
                                and currently has <span v-text="repliesCount"></span>
                                {{ Str::plural('comment', $thread->replies_count) }}
                            </span>
                        </div>
                        <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signdIn"></subscribe-button>
                        <button class="btn btn-sm btn-danger"
                                v-text="locked ? 'Unlock' : 'Lock'"
                                v-if="authorize('isAdmin')"
                                @click="toggleLock">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
