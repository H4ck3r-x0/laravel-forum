@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mb-3">
                @include('threads._list')
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header bg-white">
                        <h5>Search</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="/threads/search">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Looking for something?" name="query">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" >Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
