@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            <album-form @if(isset($album)):album="{{ json_encode(\App\Http\Resources\AlbumResource::make($album)) }}" @endif dusk="album-form"></album-form>
        </div>
    </div>
</div>
@endsection
