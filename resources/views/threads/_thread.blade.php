{{-- Editing The Thread--}}
<div class="card shadow-sm bg-white rounded mb-3" v-if="editing">
    <div class="card-header bg-white">
        <div class="level">
            <div class="flex-fill">
                <input type="text" name="title" class="form-control" v-model="form.title">
            </div>
        </div>
    </div>
    <div class="card-body">
        <trix-vue v-model="form.body" :value="form.body" @body-changed="updateBodyContent"></trix-vue>
{{--        <textarea name="body" class="form-control" cols="30" rows="10" v-model="form.body"></textarea>--}}
    </div>
    <div class="card-footer">
        <div class="d-flex">
            <button type="button" class="btn btn-sm btn-primary" @click="update">
                Update
            </button>
            <button type="button" class="btn btn-sm btn-link" @click="resetForm">
                Cancel
            </button>
            @can ('update', $thread)
                <form method="POST" action="{{ $thread->path() }}" style="margin-left: auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            @endcan
        </div>
    </div>
</div>
{{-- The Thread--}}
<div class="card shadow-sm bg-white rounded" v-else>
    <div class="card-header bg-white">
        <div class="level">
            <div class="flex-fill">
                <img
                    class="mr-1 rounded-circle"
                    width="32"
                    height="32"
                    src="{{ asset($thread->creator->avatar_path) }}"
                    alt="{{ $thread->creator->name }}">
                <a href="/profiles/{{ $thread->creator->name }}">{{ $thread->creator->name}}</a>
                <span class="text-muted" v-text="title"></span>
            </div>
        </div>
    </div>
    <div class="card-body" v-html="body"></div>
    <div class="card-footer" v-if="authorize('owns', thread)">
        <div class="d-flex">
            <button type="button" class="btn btn-sm btn-primary" @click="editing = true">
                Edit
            </button>
        </div>
    </div>
</div>
