@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $page_title }}">
@endpush

@section('content')
<div class="container home alt">
    <div class="row justify-content-center">
        @if($posts->isNotEmpty())
        <div class="col-12 col-sm-9">
            <div class="card-columns">
                @foreach($posts as $post)
                    @if($post->postable instanceof \App\Link)
                        <link-card :single="false" :link="{{ json_encode(\App\Http\Resources\LinkResource::make($post->postable)) }}"></link-card>
                    @elseif($post->postable instanceof \App\Story)
                        <story-card :single="false" :story="{{ json_encode(\App\Http\Resources\StoryResource::make($post->postable)) }}"></story-card>
                    @endif
                @endforeach
            </div>

            {{ $posts->links() }}
        </div>

        <div class="col-12 col-sm-3">
            <div class="list-group">
                @foreach($tags as $tag)
                    <a href="{{ $tag->url }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        {{ $tag->name }}
                        <span class="badge badge-pill badge-primary">{{ $tag->posts_count }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        @else
            <div class="col-12 col-md-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="text-center lead">
                            {{ __('Whoops!') }}
                        </p>

                        <p class="text-center">
                            <a href="{{ route('link.create') }}" class="btn btn-outline-primary">{{ __('Add link') }}</a>
                            <a href="{{ route('story.create') }}" class="btn btn-outline-primary">{{ __('Add story') }}</a>
                            <a href="{{ route('chest.create') }}" class="btn btn-outline-primary">{{ __('Add chest') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
