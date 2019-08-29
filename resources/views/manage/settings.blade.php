@extends('layouts.manage')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Settings') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('manage.settings') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">{{ __('Site name') }}</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ $settings['name'] }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="is_private" id="is_private" {{ $settings['is_private'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="is_private">{{ __('Private content (all content is private and login is required)') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="is_dark" id="is_dark" {{ $settings['is_dark'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="is_dark">{{ __('Dark mode') }}</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
