@extends('layouts.manage')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Logins') }}</div>

            <div class="card-body">
                @if($logins->isEmpty())
                    <div class="alert alert-info">{{ __('No logins') }}</div>
                @else
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                        <tr>
                            <th>{{ __('IP address') }}</th>
                            <th>{{ __('System') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Status') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logins as $login)
                            <tr>
                                <td class="align-middle">
                                    <a href="https://www.ip-tracker.org/locator/ip-lookup.php?ip={{ $login->ip_address }}" title="TraceIP" target="_blank">
                                        {{ $login->ip_address }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            {{ $login->device->is_mobile ? '📱' : '🖥' }}
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div>{{ $login->device->platform }} <small>{{ $login->device->platform_version }}</small></div>
                                            <div>{{ $login->device->browser }} <small>{{ $login->device->browser_version }}</small></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">{{ $login->created_at->diffForHumans() }}</td>
                                <td class="align-middle">
                                    @if($login->type === \Lab404\AuthChecker\Models\Login::TYPE_LOGIN)
                                        <span class="badge badge-success">{{ __('Succeeded') }}</span>
                                    @elseif($login->type === \Lab404\AuthChecker\Models\Login::TYPE_LOCKOUT)
                                        <span class="badge badge-danger">{{ __('Locked') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ __('Failed') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $logins->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
