@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $page_title }}">
@endpush

@section('content')
<div class="container home">
    <div class="row justify-content-center">
        @if($posts->isNotEmpty())
        <div class="col-12">
            <div class="card-columns">
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
