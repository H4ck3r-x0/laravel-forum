<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
                        <button type="submit" class="btn btn-sm btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                            {{ $reply->favorites_count }} {{ Str::plural('Like', $reply->favorites_count) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group mb-0">
                    <textarea name="" class="form-control" v-model="body"></textarea>

                    <div class="d-flex mt-2">
                        <button type="button" class="btn btn-sm btn-primary mr-1" @click="update">
                            Update
                        </button>
                        <button type="button" class="btn btn-sm btn-link" @click="editing = false">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
            <div
                v-else v-text="body"
                @can('update', $reply)
                    @dblclick="editing = true"
                @endcan>
            </div>
        </div>

        @can('update', $reply)
            <div class="card-footer d-flex">
                <button type="button" class="btn btn-sm btn-secondary mr-1" @click="editing = true">
                    Edit
                </button>
                <button type="submit" class="btn btn-sm btn-danger" @click="destroy">
                    Delete
                </button>
            </div>
        @endcan
    </div>
</reply>
