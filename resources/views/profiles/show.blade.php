@extends('layouts.app')

@section('content')
<div class="container m-auto">
    <div class="border-b">
        <avatar-form :user="{{ $profileUser }}"></avatar-form>
    </div>
</div>
@endsection
