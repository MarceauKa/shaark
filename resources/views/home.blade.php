@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $page_title }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if($posts->isNotEmpty())
        <div class="col-12">
            <div class="card-columns">
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
        </div>
        @else
            <div class="col-12 col-md-auto">
                <div class="card">
                    <div class="card-body">
                        <p class="text-center lead">
                            Ooops ! Aucun contenu !
                        </p>

                        <p class="text-center">
                            <a href="{{ route('link.create') }}" class="btn btn-outline-primary">Ajouter un lien</a>
                            <a href="{{ route('link.create') }}" class="btn btn-outline-primary">Ajouter une story</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
