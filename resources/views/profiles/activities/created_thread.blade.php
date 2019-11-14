@component('profiles.activities.activity')
    @slot('heading')
        <span class="flex-fill">
            {{ $profileUser->name }} published a
            <a href="{{ $activity->subject->path() }}">
                {{ $activity->subject->title }}
            </a>
        </span>
        <span>
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot

@endcomponent
