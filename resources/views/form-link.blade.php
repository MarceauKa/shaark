@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 mb-3">
            <link-form parse-url="{{ $parse }}"
                       submit-url="{{ $submit }}"
                       @if(isset($link))
                       :link="{{ json_encode(\App\Http\Resources\LinkResource::make($link)) }}"
                       @endif
                       @if(isset($query))
                       query-url="{{ $query }}"
                       @endif
                       method="{{ $method }}"
            >
                @if(isset($link) && $link)
                <template #actions>
                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('More') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ $link->permalink }}">{{ __('Permalink') }}</a>
                            @if($link->archive)
                                <a class="dropdown-item" href="{{ route('link.download-archive', [$link->id, csrf_token()]) }}">{{ __('Archive') }}</a>
                            @endif
                            <h6 class="dropdown-header">{{ __('Actions') }}</h6>
                            <a class="dropdown-item"
                               href="{{ route('link.create-archive', [$link->id, csrf_token()]) }}"
                            >{{ __('Create archive') }}</a>
                            <a class="dropdown-item"
                               href="{{ route('link.update-preview', [$link->id, csrf_token()]) }}"
                            >{{ __('Update preview') }}</a>
                            <h6 class="dropdown-header">{{ __('Manage') }}</h6>
                            <confirm class="dropdown-item" text="{{ __('Delete') }}" text-confirm="{{ __('Confirm') }}" href="{{ route('link.delete', [$link->id, csrf_token()]) }}"></confirm>
                        </div>
                    </div>
                </template>
                @endif
            </link-form>
        </div>

        @if(empty($query))
        <div class="col-12 col-md-4">
            <sharer url="{{ route('link.create') }}"></sharer>
        </div>
        @endif
    </div>
</div>
@endsection
