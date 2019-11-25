@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mb-3">
                @include('threads._list')
            </div>
            <div class="col-md-4">
                @if(count($trending))
                <div class="card">
                    <div class="card-header bg-white">
                        <h5>Trending Threads</h5>
                    </div>
                    <div class="card-body">
                        @foreach($trending as $thread)
                            <ul class="list-group">
                                <li class="list-group-item mb-1">
                                    <a href="{{ url($thread->path) }}">
                                        {{ $thread->title }}
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        {{ $threads->links() }}
    </div>
@endsection
