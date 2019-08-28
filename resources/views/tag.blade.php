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
                        @include('partials.link', ['link' => $post->postable, 'post' => $post, 'index' => true])
                    @elseif($post->postable instanceof \App\Story)
                        @include('partials.story', ['story' => $post->postable, 'post' => $post, 'index' => true])
                    @elseif($post->postable instanceof \App\Chest)
                        @include('partials.chest', ['chest' => $post->postable, 'post' => $post, 'index' => true])
                    @endif
                @endforeach
            </div>

            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
