@extends('layouts.app')

@push('meta')
    <meta name="description" content="{{ $page_title }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Tag : {{ $tag->name }}</h2>
            <p class="text-muted">{{ $links->total() }} {{ Str::plural('élément', $links->total()) }}</p>

            <div class="card-columns mt-4">
                @foreach($links as $link)
                    @include('partials.link', ['link' => $link])
                @endforeach
            </div>

            {{ $links->links() }}
        </div>
    </div>
</div>
@endsection
