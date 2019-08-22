@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 mb-3">
            <link-form parse-url="{{ $parse }}"
                       submit-url="{{ $submit }}"
                       @if(isset($link))
                       :link="{{ json_encode($link) }}"
                       @endif
                       @if(isset($query))
                       query-url="{{ $query }}"
                       @endif
                       method="{{ $method }}"
                       :tags="{{ $tags }}"
            ></link-form>
        </div>

        @if(empty($query))
        <div class="col-12 col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ajout rapide</h5>
                    <p class="card-text">Glissez et déposez le bouton ci-dessous dans votre barre de favoris</p>
                    <p class="card-text">
                        <a class="btn btn-outline-primary"
                           href="{{ \App\Link::sharingBookmarkCode() }}"
                        >Shaare</a>
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
