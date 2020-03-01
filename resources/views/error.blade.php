@extends('layouts.minimal')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    @yield('code') - @yield('title')
                    <span>
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-home"></i></a>
                    </span>
                </div>

                <div class="card-body">
                    <p class="mb-0 lead">@yield('message')</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
