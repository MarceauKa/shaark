@extends('layouts.manage')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-link mr-1"></i> {{ __('Other-status Links') }}
                </span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($other_links->isEmpty())
                        <div class="alert alert-info">
                            {{ __('No other-status links found') }}
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
                            @foreach ($other_links as $other_link)
                                <tr>
                                    <td><a href="{{ $other_link->permalink }}" target="_blank">{{ $other_link->title }}</a></td>
                                    <td>{{ $other_link->http_status }}</td>
                                    <td>{{ $other_link->http_checked_at }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{ $other_links->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
