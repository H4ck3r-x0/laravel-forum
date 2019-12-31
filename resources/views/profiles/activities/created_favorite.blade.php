@component('profiles.activities.activity')
    @slot('heading')
        <span class="text-xl font-normal text-gray-900">
        <i class="far fa-thumbs-up text-blue-600"></i>
            Liked a reply from
            <a href="{{ $activity->subject->favorited->path() }}" class="text-blue-600">
                 {{ $activity->subject->favorited->owner->name }}
            </a>
            <span class="text-gray-500 text-sm">
                {{ $activity->subject->favorited->created_at->diffForHumans() }}
            </span>
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot

@endcomponent

