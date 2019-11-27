@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/vendor/jquery.atwho.css') }}" rel="stylesheet">
@endsection

@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8" v-cloak>
                    @include('threads._thread')
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
                        <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"
                                          v-if="signdIn"></subscribe-button>
                        <button class="btn btn-sm btn-danger mb-1"
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
