@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update account') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('account') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input type="text" name="name" id="name"
                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">{{ __('Email') }}</label>
                                    <input type="email" name="email" id="email"
                                           class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('account.password') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_password">{{ __('New password') }}</label>
                                    <input type="password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : '' }}"
                                           name="new_password" id="new_password">
                                    @error('new_password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_password_confirmation">{{ __('Confirm password') }}</label>
                                    <input type="password" class="form-control"
                                           name="new_password_confirmation" id="new_password_confirmation">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="current_password">{{ __('Current password') }}</label>
                            <input type="password" class="form-control {{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                                   name="current_password" id="current_password" autocomplete="new-password">
                            @error('current_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
