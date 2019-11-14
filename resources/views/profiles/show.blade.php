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
            @forelse($activities as $date => $activity)
                <hr>

                <h3 class="page-header">{{ $date }}</h3>
                @foreach($activity as $record)
                    @if (view()->exists("profiles.activities.{$record->type}"))
                        @include("profiles.activities.{$record->type}", ['activity' => $record])
                    @endif
                @endforeach
                    @empty
                <hr>
                    <h5 class="text-muted mt-3">There is no activities for this user yet.</h5>
            @endforelse
        </div>
    </div>
@endsection
