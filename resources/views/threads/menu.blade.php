<div class="w-1/4 mr-10 h-12">
    <button type="submit"  class=" w-full uppercase font-medium shadow focus:outline-none hover:bg-lightBlue bg-secondary text-white p-2 pr-4 pl-4 rounded-lg tracking-wider">
        start a new discussion
    </button>
    <div class="flex-1">
        <h3 class="font-sans font-bold text-xl ml-1 text-gray-700 tracking-wide mt-4 mb-1">Browse</h3>
        <ul class="border-b">
            <li class="mb-2 hover:bg-gray-100 py-3 px-3 rounded-lg">
                <a href="/threads" class="block font-bold text-sm text-lightBlue hover:text-lighterBlue tracking-wider">
                    <i class="fab fa-rocketchat fa-lg mr-2"></i> All Dissections
                </a>
            </li>
            @if (auth()->check())
                <li class="mb-2 hover:bg-gray-100 py-3 px-3 rounded-lg">
                    <a href="/threads?by={{ auth()->user()->username }}" class="block text-sm font-bold text-blue-600 hover:text-blue-500 tracking-wider">
                        <i class="fas fa-question-circle fa-lg mr-2"></i> My Dissections
                    </a>
                </li>
            @endif
            <li class="mb-2 hover:bg-gray-100 py-3 px-3 rounded-lg">
                <a href="/threads?popular=1" class="block text-sm font-bold text-redFire hover:text-redFireLight tracking-wider">
                    <i class="fas fa-fire fa-lg mr-2"></i>  Popular Dissections
                </a>
            </li>
            <li class="mb-2 hover:bg-gray-100 py-3 px-3 rounded-lg">
                <a href="/threads?unanswered=1" class="block text-sm font-bold text-unanswerdGray hover:text-unanswerdGrayLight tracking-wider">
                    <i class="fab fa-replyd fa-lg mr-2"></i>  Unanswered Dissections
                </a>
            </li>
            <li class="mb-2 hover:bg-gray-100 py-3 px-3 rounded-lg">
                <a href="#" class="block text-sm font-bold text-gray-800 hover:text-gray-500 hover:bg-gray-100 tracking-wider ">
                    <i class="far fa-star fa-lg mr-2"></i>  Subscribing
                </a>
            </li>
        </ul>
        <h3 class="font-sans font-bold text-xl ml-1 text-gray-700 tracking-wide mt-4 mb-1">Channels</h3>
        <ul class="mt-4">
            @foreach ($channels as $channel)
{{--                {{dd($channel)}}--}}
                <li class="mb-1 hover:bg-gray-100 py-3 px-3 rounded-lg">
                    <a class="block text-sm font-bold text-tagsGray hover:text-lightBlue  hover:bg-gray-100 tracking-wider" href="/threads/{{ $channel->slug }}">
                        <i class="fas fa-tags text-gray-400 mr-2"></i> {{ $channel->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
