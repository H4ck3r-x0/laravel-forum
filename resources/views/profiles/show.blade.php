@extends('layouts.app')

@section('content')
    <div class="container page-header">
        <div class="col-md-12">
            <avatar-form :user="{{ $profileUser }}"></avatar-form>

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
