@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $page_title }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>{{ __('Tag') }} : {{ $tag->name }}</h2>
            <p class="text-muted">{{ $posts->total() }} {{ Str::plural('élément', $posts->total()) }}</p>

            <div class="card-columns mt-4">
                @foreach($posts as $post)
                    @if($post->postable instanceof \App\Link)
                        <link-card :single="false" :link="{{ json_encode(\App\Http\Resources\LinkResource::make($post->postable)) }}"></link-card>
                    @elseif($post->postable instanceof \App\Story)
                        <story-card :single="false" :story="{{ json_encode(\App\Http\Resources\StoryResource::make($post->postable)) }}"></story-card>
                    @elseif($post->postable instanceof \App\Chest)
                        <chest-card :single="false" :chest="{{ json_encode(\App\Http\Resources\ChestResource::make($post->postable)) }}"></chest-card>
                    @endif
                @endforeach
            </div>

            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
