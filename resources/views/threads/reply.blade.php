<div id="reply-{{ $reply->id }}" class="card mt-4 mb-4 shadow-sm bg-white rounded">
    <div class="card-header bg-white">
        <div class="level">
            <h6 class="flex-fill">
                <a href="/profiles/{{ $reply->owner->name }}">{{ $reply->owner->name }}</a>
                <span class="text-muted">said {{ $reply->created_at->diffForHumans() }}</span>
            </h6>
            <div>
                <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                    @csrf
{{--                    {{dd($reply->isFavorited())}}--}}
                    <button type="submit" class="btn btn-sm btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ Str::plural('Like', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
