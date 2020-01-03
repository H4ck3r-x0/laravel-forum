@extends('layouts.app')

@section('content')
<div class="">
    <div class="border-b">
        <div class="flex flex-row justify-between">
            <avatar-form :user="{{ $profileUser }}"></avatar-form>
            <div class="flex flex-col">
                <span class="text-sm font-medium border border-gray-400 rounded py-1 px-2 mb-2">
                <i class="fas fa-pencil-alt text-gray-600"></i>
                    Published: {{ $profileUser->threads_count }}
                </span>
                <span class="text-sm font-medium border border-gray-400 rounded py-1 px-2">
                <i class="far fa-comment-dots text-gray-600"></i>
                    Replied: {{ $profileUser->replies_count }}
                </span>                
            </div>
        </div>
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
