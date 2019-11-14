@component('profiles.activities.activity')
    @slot('heading')
        <span class="flex-fill">
            <a href="{{ $activity->subject->favorited->path() }}">
                {{ $profileUser->name }} liked a reply
            </a>
        </span>
        <span>
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot

@endcomponent

