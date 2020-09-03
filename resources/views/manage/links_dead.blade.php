@extends('layouts.manage')

@section('content')
    @include('manage.links_dashboard')

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-link mr-1"></i> {{ __('Dead Links') }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($dead_links->isEmpty())
                            <div class="alert alert-info">
                                {{ __('No dead links found') }}
                            </div>
                        @else
                            <table class="table table-borderless table-sm">
                                <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Last Checked') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($dead_links as $dead_link)
                                    <tr>
                                        <td><a href="{{ $dead_link->permalink }}" target="_blank">{{ $dead_link->title }}</a></td>
                                        <td>{{ $dead_link->http_status }}</td>
                                        <td>{{ $dead_link->http_checked_at }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $dead_links->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
