@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ Str::limit($link->content, 130) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $link->title }}">
    <meta property="og:url" content="{{ $link->permalink }}">
    <meta property="og:description" content="{{ Str::limit($link->content, 130) }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            <link-card :single="true" :link="{{ json_encode(\App\Http\Resources\LinkResource::make($link)) }}"></link-card>
            @can('comments.see')
            <comments :id="{{ $link->post->id }}"
                      :captcha="{{ json_encode(Captcha::create('default', true)) }}"
                      @can('comments.add')
                      :allow-guest="true"
                      @else
                      :allow-guest="false"
                @endcan
            ></comments>
            @endcan
        </div>
    </div>
</div>
@endsection
