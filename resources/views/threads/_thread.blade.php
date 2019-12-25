{{--      Edit Thread      --}}
<div class="w-full h-12" v-if="editing">
    <input
        type="text"
        name="title"
        class="transition focus:outline-none border border-transparent focus:bg-white focus:border-gray-300 placeholder-gray-600 rounded-lg bg-gray-200 py-2 pr-4 pl-5 block w-full appearance-none antialiased text-1xl font-bold text-gray-800 leading-relaxed ds-input"
        v-model="form.title">

    <div class="flex flex-row mt-4">
        <img
            class="w-12 h-12 mr-2 rounded-full"
            src="{{ asset($thread->creator->avatar_path) }}"
            alt="{{ $thread->creator->name }}">
        <div class="flex flex-col">
            <a href="/profiles/{{ $thread->creator->username }}" class="text-gray-800 font-bold leading-relaxed">
                {{ $thread->creator->name}}
            </a>
            <span class="text-xs text-gray-500">
               Published {{ $thread->created_at->diffForHumans() }}
            </span>
        </div>
    </div>
    <div class="mt-6">
        <vue-trix v-model="form.body" :value="form.body" @body-changed="updateBodyContent"></vue-trix>
        <div class="flex mt-4">
            <button
                v-if="form.body"
                type="button"
                class="font-medium tracking-wide px-4 py-1 bg-secondary hover:bg-lightBlue rounded text-white focus:outline-none"
                @click="update">
                <i class="fas fa-pen"></i> Update
            </button>
            <button
                type="button"
                class="font-medium tracking-wide px-4 py-1 rounded text-gray-700 hover:underline focus:outline-none"
                @click="resetForm">
                Cancel
            </button>
            @can ('update', $thread)
                <form method="POST" action="{{ $thread->path() }}" style="margin-left: auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="font-medium tracking-wide px-4 py-1 bg-redFire hover:bg-redFireLight rounded text-white focus:outline-none">
                        <i class="far fa-trash-alt"></i> Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>

{{--         Show Thread   --}}
<div class="w-full h-12" v-else>
    <div class="hover:bg-gray-100 px-4 py-2 rounded">
        <div class="flex flex-row justify-between">
            <h1 v-text="title" class="antialiased text-2xl font-bold text-gray-800 leading-relaxed"></h1>
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
                    <p class="block ml-3 border px-2 text-gray-500 rounded hover:bg-white hover:text-black">
                        <a href="/threads/{{ $thread->channel->slug }}">
                            {{ $thread->channel->name }}
                        </a>
                    </p>
                </div>
        </div>
        <div class="flex mt-4">
            <img
                class="w-12 h-12 mr-2 rounded-full"
                src="{{ asset($thread->creator->avatar_path) }}"
                alt="{{ $thread->creator->name }}">
            <div class="flex flex-col">
                <a href="/profiles/{{ $thread->creator->username }}" class="text-gray-800 hover:underline font-bold leading-relaxed">
                    {{ $thread->creator->name}}
                </a>
                <span class="text-xs text-gray-500">
                {{ $thread->created_at->diffForHumans() }}
            </span>
            </div>
            <div class="flex flex-row">
                <div class="ml-3">
                    <button
                        v-if="authorize('owns', thread)"
                        type="button"
                        class="font-medium tracking-wide text-secondary mr-2 rounded text-white focus:outline-none"
                        @click="editing = true">
                        <i class="fas fa-edit"></i>
                    </button>
                    <subscribe-button
                        :active="{{ json_encode($thread->isSubscribedTo) }}"
                        v-if="signdIn">
                    </subscribe-button>
                </div>
            </div>
        </div>

        <div class="mt-6 font-medium text-gray-800 font-semibold leading-relaxed tracking-wide" v-html="body"></div>
    </div>
        <div class="w-full mt-10 border-b border-b-2 pb-3 font-medium text-gray-700 text-lg">
            <span v-text="repliesCount"></span> {{ Str::plural('Reply', $thread->replies_count) }}
        </div>
        {{--  End Show Thread  --}}


    {{--  Show Replies  --}}

    <replies
        class="mt-3"
        @added="repliesCount++"
        @removed="repliesCount--">
    </replies>
</div>
