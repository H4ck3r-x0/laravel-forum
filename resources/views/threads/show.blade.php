@extends('layouts.app')
@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="flex" v-cloak>
            @include('threads.menu')

            @include('threads._thread')

        </div>
    </thread-view>
@endsection
