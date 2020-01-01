@component('profiles.activities.activity')
    @slot('heading')
        <span class="text-xl font-normal text-gray-900">
        <i class="fas fa-pencil-alt text-blue-600"></i>
            Published
            <a href="{{ $activity->subject->path() }}" class="text-blue-600">
                {{ $activity->subject->title }}
            </a>          
            <span class="text-gray-500 text-sm">
                {{ $activity->subject->created_at->diffForHumans() }}
            </span>
        </span>
    @endslot

    @slot('body')
         {!! $activity->subject->body !!}
    @endslot

@endcomponent
