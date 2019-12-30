@extends('layouts.app')

@section('content')
    <div class="flex">
        @include('threads.menu')
        <div class="w-full h-12">
            <div class="">
                @include('threads._list')
                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection
