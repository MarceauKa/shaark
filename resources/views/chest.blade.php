@extends('layouts.app')

@push('meta')
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $chest->title }}">
    <meta property="og:url" content="{{ $chest->permalink }}">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            @include('partials.chest', ['post' => $chest->post, 'chest' => $chest])
        </div>
    </div>
</div>
@endsection
