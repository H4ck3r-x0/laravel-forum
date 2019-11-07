@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a new Thread</div>
                    <div class="card-body">
                        <form method="POST" action="/threads">
                            @csrf
                            <div class="form-group">
                                <label for="channel">Choose a Channel</label>
                                <select name="channel_id" class="form-control @error('channel_id') is-invalid @enderror" required>
                                    <option value="">Choose One</option>
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('channel_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="title">Thread Title</label>
                                <input type="text" name="title" id="title"
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title') }}"
                                       required
                                >

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="body">Thread Body</label>
                                <textarea name="body" id="body" rows="5"
                                          required
                                          class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea>

                                @error('body')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
