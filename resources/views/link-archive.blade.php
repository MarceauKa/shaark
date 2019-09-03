@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
            @if($link->hasArchive())
                <div class="card mb-3">
                    <div class="card-header">{{ __('Current archive') }}</div>

                    <div class="card-body">
                        <form action="{{ route('link.archive-delete', $link->id) }}" method="POST">
                            @csrf

                            <a href="{{ route('link.archive-download', [$link->id, csrf_token()]) }}" class="btn btn-sm btn-primary">{{ __('Download archive') }}</a>
                            <button type="submit" class="btn btn-sm btn-danger" name="type" value="pdf">{{ __('Delete archive') }}</button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header">{{ __('New archive') }}</div>

                <div class="card-body">
                    @if(empty($providers))
                        <div class="alert alert-info">
                            {{ __('No provider found to archive this link') }}
                        </div>
                    @else
                        <p class="card-text">{!! __("Choose preferred method to archive this link: <a href=':link' target='_blank'>:link</a>", ['link' => $link->url]) !!}</p>

                        <form action="{{ route('link.archive-form', $link->id) }}" method="POST">
                            @csrf

                            <table class="table table-condensed table-bordered">
                                @if(in_array('media', $providers))
                                    <tr>
                                        <td>{{ __('Archive media') }}</td>
                                        <td class="text-right">
                                            <button type="submit" class="btn btn-sm btn-primary btn-block" name="type" value="media">{{ __('Choose') }}</button>
                                        </td>
                                    </tr>
                                @endif

                                @if(in_array('pdf', $providers))
                                    <tr>
                                        <td>{{ __('Archive PDF') }}</td>
                                        <td class="text-right">
                                            <button type="submit" class="btn btn-sm btn-primary btn-block" name="type" value="pdf">{{ __('Choose') }}</button>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
