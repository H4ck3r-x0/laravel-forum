@component('profiles.activities.activity')
    @slot('heading')
        <span class="text-xl font-normal text-gray-900">
        <i class="far fa-comment-dots text-blue-600"></i>
            Replied to
            <a href="{{$activity->subject->thread->path()}}" class="text-blue-600">
                {{ $activity->subject->thread->title }}
            </a>            
            <span class="text-gray-500 text-sm">
                {{ $activity->subject->thread->created_at->diffForHumans() }}
            </span>
        </span>
    @endslot

    @slot('body')
         {!! $activity->subject->body !!}
    @endslot

@endcomponent

