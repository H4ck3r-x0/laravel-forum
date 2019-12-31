@extends('layouts.app')

@section('content')
<div class="font-sans">
    <div class="container mx-auto">
        <div class="mb-2">
            <h1 class="text-2xl text-gray-700 font-medium uppercase tracking-wider">Create a new Thread</h1>
        </div>
        <div class="">
            <form method="POST" action="/threads" class="w-full bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                @csrf
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="title">
                            Thread Title
                        </label>
                        <input
                            name="title"
                            class=
                            "@error('title') border-red-300 @enderror appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4  leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="title"
                            type="text"
                            value="{{ old('title') }}"
                            autofocus
                            placeholder="I need help with ...">

                            @error('title')
                            <span class="text-red-500 text-xs italic" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                    </div>

                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="channel">
                            Choose a Channel
                        </label>
   
                      <div class="relative">
                        <select 
                        name="channel_id"
                        class="@error('channel_id') border-red-300 @enderror block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="channel">
                          <option value="">Choose One</option>
                        @foreach ($channels as $channel)
                            <option
                                value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                {{ $channel->name }}
                            </option>
                        @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                      </div>

                        @error('channel_id')
                        <span class="text-red-500 text-xs italic" role="alert">
                                {{ $message }}
                        </span>
                        @enderror
                    </div>                    
                </div>
                    <div class="w-full mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="body">
                            Thread Body
                        </label>
                        <vue-trix placeholder="Enter Your content here ..." class="@error('body') border-red-300 @enderror"></vue-trix>
                        @error('body')
                        <span class="text-red-500 text-xs italic" role="alert">
                                {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Publish</button>

            </form>
        </div>
    </div>    
</div>
@endsection