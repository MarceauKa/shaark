@extends('layouts.manage')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Settings') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('manage.settings') }}" method="POST">
                    @csrf

                    <fieldset>
                        <legend>{{ __('General') }}</legend>

                        <div class="form-group">
                            <label for="name">{{ __('Site name') }}</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ $settings['name'] }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="locale">{{ __('Language') }}</label>
                            <select name="locale" id="locale" class="form-control">
                                <option value="fr"{{ $settings['locale'] == 'fr' ? ' selected' : '' }}>FR</option>
                                <option value="en"{{ $settings['locale'] == 'en' ? ' selected' : '' }}>EN</option>
                            </select>
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
                    </fieldset>

                    <fieldset>
                        <legend>{{ __('Archiving') }}</legend>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="private_archive" id="private_archive" {{ $settings['private_archive'] ? ' checked' : '' }}>
                                <label class="custom-control-label" for="private_archive">{{ __('Make archives private?') }}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="link_archive_pdf" id="link_archive_pdf" {{ $settings['link_archive_pdf'] ? ' checked' : '' }}>
                                <label class="custom-control-label" for="link_archive_pdf">{{ __('PDF archiving (Web pages to PDF)') }}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="node_bin">{{ __('Node.js binary') }}</label>
                            <input type="text" class="form-control {{ $errors->has('node_bin') ? ' is-invalid' : '' }}" name="node_bin" id="node_bin" value="{{ $settings['node_bin'] }}">
                            @error('node_bin')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="link_archive_media" id="link_archive_media" {{ $settings['link_archive_media'] ? ' checked' : '' }}>
                                <label class="custom-control-label" for="link_archive_media">{{ __('Media archiving (Youtube, Soundcloud, ...)') }}</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="youtube_dl_bin">{{ __('Youtube-dl binary') }}</label>
                            <input type="text" class="form-control {{ $errors->has('youtube_dl_bin') ? ' is-invalid' : '' }}" name="youtube_dl_bin" id="youtube_dl_bin" value="{{ $settings['youtube_dl_bin'] }}">
                            @error('youtube_dl_bin')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </fieldset>

                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
