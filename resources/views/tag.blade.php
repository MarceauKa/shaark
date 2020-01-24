@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $page_title }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="cards">
                <masonry :cols="2" :gutter="30">
                    <div class="card mb-4">
                        <div class="card-header"><i class="fas fa-tags"></i> {{ __('Tag') }} &mdash; {{ $tag->name }}</div>
                        <div class="card-body">
                            {{ $tag->posts_count }} {{ Str::plural('élément', $tag->posts_count) }}
                        </div>
                    </div>

                    @foreach($posts as $post)
                        @if($post->postable instanceof \App\Link)
                            <link-card :single="false" :link="{{ json_encode(\App\Http\Resources\LinkResource::make($post->postable)) }}"></link-card>
                        @elseif($post->postable instanceof \App\Story)
                            <story-card :single="false" :story="{{ json_encode(\App\Http\Resources\StoryResource::make($post->postable)) }}"></story-card>
                        @elseif($post->postable instanceof \App\Chest)
                            <chest-card :single="false" :chest="{{ json_encode(\App\Http\Resources\ChestResource::make($post->postable)) }}"></chest-card>
                        @elseif($post->postable instanceof \App\Album)
                            <album-card :single="false" :album="{{ json_encode(\App\Http\Resources\AlbumResource::make($post->postable)) }}"></album-card>
                        @endif
                    @endforeach
                </masonry>
            </div>

            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
