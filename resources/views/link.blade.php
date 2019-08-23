@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            @include('partials.link', ['link' => $link])
        </div>
    </div>
</div>
@endsection
