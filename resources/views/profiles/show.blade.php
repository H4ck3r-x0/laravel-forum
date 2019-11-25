@extends('layouts.app')

@section('content')
    <div class="container page-header">
        <div class="col-md-12">
            <div class="level">
                <h2 class="flex-fill">
                    <img
                        class="mr-1 rounded-circle"
                        width="100"
                        height="100"
                        src="{{ asset($profileUser->avatar_path) }}"
                        alt="{{ $profileUser->name }}">
                    {{ $profileUser->name }}
                </h2>
                <h5 class="text-muted">
                    Created {{ $profileUser->created_at->diffForHumans() }}
                </h5>
            </div>
            @can('update', $profileUser)
                <form method="POST" action="{{ route('avatar', $profileUser) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="avatar">
                    <button type="submit" class="btn btn-sm btn-primary">Add Avatar</button>
                </form>
            @endcan
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
