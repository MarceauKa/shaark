@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            <story-form submit-url="{{ $submit }}"
                       @if(isset($story))
                       :story="{{ json_encode(\App\Http\Resources\StoryResource::make($story)) }}"
                       @endif
                       method="{{ $method }}"
            ></story-form>
        </div>
    </div>
</div>
@endsection
