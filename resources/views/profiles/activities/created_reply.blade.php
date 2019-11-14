@component('profiles.activities.activity')
    @slot('heading')
        <span class="flex-fill">
            {{ $profileUser->name }} replied to a
            <a href="{{$activity->subject->thread->path()}}">
                {{ $activity->subject->thread->title }}
            </a>
        </span>
        <span>
            {{ $activity->subject->thread->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot

@endcomponent

