@extends('layouts.manage')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="row text-uppercase">
            <div class="col-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Total') }}</small>
                        <h3 class="text-right text-primary">{{ number_format($num_total, 0) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Health Checks') }}</small>
                        @if ($health_checks_enabled)
                            <h3 class="text-right text-capitalize text-success">{{ __('Enabled') }}</h3>
                        @else
                            <h3 class="text-right text-capitalize text-muted">{{ __('Disabled') }}</h3>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-6 mt-4 col-lg-4 mt-lg-0">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Pending Checks') }}</small>
                        <h3 class="text-right text-info">{{ number_format($num_pending, 0) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Healthy (200)') }}</small>
                        <h3 class="text-right text-success">{{ number_format($num_healthy, 0) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Dead (4xx)') }}</small>
                        <h3 class="text-right text-danger">{{ number_format($num_dead, 0) }}</h3>
                        <a href="{{ route('manage.links.dead.view') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Other (3xx, 5xx)') }}</small>
                        <h3 class="text-right text-muted">{{ number_format($num_other, 0) }}</h3>
                        <a href="{{ route('manage.links.other.view') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
