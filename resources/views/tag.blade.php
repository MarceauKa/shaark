@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $page_title }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="mb-4">Tag : {{ $tag->name }}</h2>

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
