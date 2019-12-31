@extends('layouts.app')

@section('content')
<div class="">
    <div class="border-b">
        <avatar-form :user="{{ $profileUser }}"></avatar-form>
    </div>
    <div class="flex items-center justify-center mt-4">
    	<h1 class="border-b-2 border-blue-600 text-3xl">Activity</h1>
    </div>
	<div class="mt-6">
        @forelse($activities as $date => $activity)
        <div class="flex justify-center">
            <h3 class="w-32 text-lg font-medium font-mono border border-blue-600 flex justify-center mb-5 mt-5 rounded-full">
            	{{ $date }}
        	</h3>	
        </div>
        @foreach($activity as $record)
            @if (view()->exists("profiles.activities.{$record->type}"))
                @include("profiles.activities.{$record->type}", ['activity' => $record])
            @endif
        @endforeach
        @empty
            <h5 class="text-muted mt-3">There is no activities for this user yet.</h5>
        @endforelse
	</div>    
</div>
@endsection
