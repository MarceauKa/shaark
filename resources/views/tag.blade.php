@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Tag : {{ $tag->name }}</h2>

            <div class="card-columns">
                @foreach($links as $link)
                    @include('partials.link', ['link' => $link])
                @endforeach
            </div>

            {{ $links->links() }}
        </div>
    </div>
</div>
@endsection
