@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $page_title }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if($links->isNotEmpty())
        <div class="col-12">
            <div class="card-columns">
                @foreach($links as $link)
                    @include('partials.link', ['link' => $link])
                @endforeach
            </div>

            {{ $links->links() }}
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
