@forelse($threads as $thread)
    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-header bg-white">
                <div class="level">
                    <div class="flex-fill">
                        <h3>
                            <a href="{{ $thread->path() }}">
                                @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                    <strong>{{ $thread->title }}</strong>
                                @else
                                    {{ $thread->title }}
                                @endif
                            </a>
                        </h3>
                        <h6>
                            Posted By:
                            <a href="{{ route('profile', $thread->creator) }}">
                                {{ $thread->creator->name }}
                            </a>
                        </h6>
                    </div>
                    <a href="{{ $thread->path() }}">
                                     <span class="badge badge-light">
                                    {{ $thread->replies_count }}
                                         {{ Str::plural('reply'), $thread->replies_count }}
                                    </span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>
@empty
    <p class="text-info">There are no relevant results at this time.</p>
@endforelse
