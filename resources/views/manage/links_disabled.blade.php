@extends('layouts.manage')

@section('content')
    @include('manage.links_dashboard')

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-link mr-1"></i> {{ __('Disabled Links') }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($disabled_links->isEmpty())
                            <div class="alert alert-info">
                                {{ __('No disabled links found') }}
                            </div>
                        @else
                            <table class="table table-borderless table-sm">
                                <thead>
                                <tr>
                                    <th>{{ __('Title') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($disabled_links as $disabled_link)
                                    <tr>
                                        <td><a href="{{ $disabled_link->permalink }}" target="_blank">{{ $disabled_link->title }}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            {{ $disabled_links->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
