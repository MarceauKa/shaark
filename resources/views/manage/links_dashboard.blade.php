<div class="row justify-content-center mb-4">
    <div class="col-12">
        <div class="row text-uppercase">
            <div class="col-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Total') }}</small>
                        <h3 class="text-right text-primary">{{ number_format($stats->countTotal(), 0) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Health Checks') }}</small>
                        @if ($stats->isHealthCheckEnabled())
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
                        <h3 class="text-right text-info">{{ number_format($stats->countPending(), 0) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Healthy (200)') }}</small>
                        <h3 class="text-right text-success">{{ number_format($stats->countHealthy(), 0) }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Dead (4xx)') }}</small>
                        <h3 class="text-right text-danger">{{ number_format($stats->countDead(), 0) }}</h3>
                        <a href="{{ route('manage.links.dead.view') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Other (3xx, 5xx)') }}</small>
                        <h3 class="text-right text-muted">{{ number_format($stats->countOther(), 0) }}</h3>
                        <a href="{{ route('manage.links.other.view') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>

            <div class="col-6 mt-4 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <small class="card-title font-weight-bold text-muted">{{ __('Disabled Links') }}</small>
                        <h3 class="text-right text-muted">{{ number_format($stats->countDisabled(), 0) }}</h3>
                        <a href="{{ route('manage.links.disabled.view') }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>