@extends('layouts.app')

@section('content')
    <div class="container page-header">
        <div class="col-md-8 offset-2">
            <div class="level">
                <h1>
                    {{ $profileUser->name }}
                    <small class="text-muted">
                        Created {{ $profileUser->created_at->diffForHumans() }}
                    </small>
                </h1>
            </div>
            @foreach($activities as $date => $activity)
                <hr>

                <h3 class="page-header">{{ $date }}</h3>
                @foreach($activity as $record)
                    @include("profiles.activities.{$record->type}", ['activity' => $record])
                @endforeach
            @endforeach
        </div>
    </div>
@endsection
