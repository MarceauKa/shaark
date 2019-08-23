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
        <div class="col-12 col-md-4">
            <sharer url="{{ route('link.create') }}"></sharer>
        </div>
        @endif
    </div>
</div>
@endsection
