<div class="card mt-4 mb-4 shadow-sm bg-white rounded">
    <div class="card-header bg-white">
        <a href="#">{{ $reply->owner->name }}</a>
        <span class="text-muted">said {{ $reply->created_at->diffForHumans() }}</span>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
