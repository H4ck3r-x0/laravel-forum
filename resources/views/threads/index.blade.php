@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('threads._list')
        </div>
        {{ $threads->links() }}
    </div>
@endsection
