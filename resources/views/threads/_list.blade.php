@forelse($threads as $thread)
    <div class="relative border p-6 mb-8 rounded-lg hover:bg-gray-100 shadow-md">
        <div
            class="flex absolute right-5 -top-3 w-32 bg-white border py-1 px-1 justify-center pr-1 rounded-lg hover:bg-gray-100">
            <a href="/threads/{{ $thread->channel->slug }}" class="block hover:underline">
                <i class="fas fa-tags text-secondary mr-1"></i> {{ $thread->channel->name }}
            </a>
        </div>
        @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
            <div class="flex absolute left-0 -top-3  py-1 px-1 justify-center pr-1 ">
                <i class="fab fa-hotjar fa-stack-1x text-redFire"></i>
            </div>
        @endif
        <div class="flex">
            <div class="w-1/7 h-12">
                <img
                    class="h-16 w-16 object-cover mr-4 rounded-full"
                    src="{{ $thread->creator->avatar_path }}"
                    alt="{{ $thread->creator->name }}"
                >
            </div>
            <div class="flex-col w-full">
                <h2 class="text-gray-700 font-bold text-lg">
                    <a class="hover:underline" href="{{ $thread->path() }}">
                        {{ $thread->title }}
                    </a>
                </h2>
                <a href="{{ route('profile', $thread->creator) }}" class=" font-bold text-sm text-secondary">
                    {{ $thread->creator->name }}
                    <span class="text-gray-600">
                        {{ $thread->created_at->diffForHumans() }}
                    </span>
                </a>
                <div class="mt-3 w-1/7">
                    <p class="text-gray-700 text-base leading-relaxed">
                        {!! $thread->body !!}
                    </p>
                </div>
                <div class="flex  mt-3 mb-0">
                    <p class="text-gray-500 mr-3">
                        <i class="far fa-eye"></i>
                        <span>
                            {{ $thread->visits()->count() }}
                        </span>
                    </p>
                    <p class="text-gray-500">
                        <i class="far fa-comment"></i>
                        <span>
                            {{ $thread->replies_count }}
                        </span>
                    </p>

                    @if($thread->lastReply)
                    <p class="text-gray-500 ml-3">
                        <a href="{{ route("profile", $thread->lastReply->owner) }}" class="font-bold text-sm text-secondary">
                            {{ $thread->lastReply->owner->name }}
                        </a>
                         <span> replied</span>
                         <span class="text-gray-600">{{ $thread->lastReply->created_at->diffForHumans() }}</span>
                    </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@empty
    <p class="text-info">There are no relevant results at this time.</p>
@endforelse
