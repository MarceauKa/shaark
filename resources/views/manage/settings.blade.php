@extends('layouts.manage')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <form method="POST" action="{{ route('manage.settings') }}" enctype="multipart/form-data">
            @csrf

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{ __('shaarli.settings.general.title') }}
                    <button type="button" class="btn btn-sm btn-outline-primary" @click="installPwa" :disabled="prompt === null">{{ __('shaarli.settings.general.install_button') }}</button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">{{ __('shaarli.settings.general.site_name') }}</label>
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ $settings['name'] }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="locale">{{ __('shaarli.settings.general.lang') }}</label>
                        <select name="locale" id="locale" class="form-control custom-select">
                            <option value="fr"{{ $settings['locale'] == 'fr' ? ' selected' : '' }}>FR</option>
                            <option value="en"{{ $settings['locale'] == 'en' ? ' selected' : '' }}>EN</option>
                            <option value="de"{{ $settings['locale'] == 'de' ? ' selected' : '' }}>DE</option>
                            <option value="ja"{{ $settings['locale'] == 'ja' ? ' selected' : '' }}>JA</option>
                        </select>
                        @error('locale')
                        <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="is_private" id="is_private" {{ $settings['is_private'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="is_private">{{ __('shaarli.settings.general.private_help') }}</label>
                        </div>
                        @error('is_private')
                        <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">{{ __('shaarli.settings.appearance.title') }}</div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="is_dark" id="is_dark" {{ $settings['is_dark'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="is_dark">{{ __('shaarli.settings.appearance.is_dark') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="home_show_tags" id="home_show_tags" {{ $settings['home_show_tags'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="home_show_tags">{{ __('shaarli.settings.appearance.home_show_tags') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="home_show_chests" id="home_show_chests" {{ $settings['home_show_chests'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="home_show_chests">{{ __('shaarli.settings.appearance.home_show_chests') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="compact_cardslist" id="compact_cardslist" {{ $settings['compact_cardslist'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="compact_cardslist">{{ __('shaarli.settings.appearance.compact_cardslist') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('shaarli.settings.appearance.columns_count') }}</label>
                        <input type="number" class="form-control {{ $errors->has('columns_count') ? ' is-invalid' : '' }}" step="1" min="1" max="4"
                               name="columns_count" id="columns_count" value="{{ $settings['columns_count'] }}">

                        @error('columns_count')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <label for="name">{{ __('shaarli.settings.appearance.custom_background') }}</label>
                    <background name="custom_background" :values="{{ $settings['custom_background'] ?? '{type: "none"}' }}"></background>
                    @error('custom_background')
                    <span class="text-danger" role="alert">{{ $message }}</span>
                    @enderror

                    <label for="name">{{ __('shaarli.settings.appearance.custom_icon') }}</label>
                    <div class="custom-file">
                        <label for="custom_icon" class="custom-file-label" data-browse="{{ __('Browse') }}">{{ __('File') }}</label>
                        <input type="file" class="custom-file-input" name="custom_icon" id="custom_icon" accept="image/png" />
                    </div>
                    @error('custom_icon')
                    <span class="text-danger" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">{{ __('shaarli.settings.2fa.title') }}</div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="secure_login" id="secure_login" {{ $settings['secure_login'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="secure_login">{{ __('shaarli.settings.2fa.secure_login') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('shaarli.settings.2fa.secure_code_expires') }}</label>
                        <input type="number" class="form-control {{ $errors->has('secure_code_expires') ? ' is-invalid' : '' }}" step="5"
                               name="secure_code_expires" id="secure_code_expires" value="{{ $settings['secure_code_expires'] }}">
                        @error('secure_code_expires')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('shaarli.settings.2fa.secure_code_length') }}</label>
                        <input type="number" class="form-control {{ $errors->has('secure_code_length') ? ' is-invalid' : '' }}" step="1"
                               name="secure_code_length" id="secure_code_length" value="{{ $settings['secure_code_length'] }}">

                        @error('secure_code_length')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">{{ __('shaarli.settings.archiving.title') }}</div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="private_archive" id="private_archive" {{ $settings['private_archive'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="private_archive">{{ __('shaarli.settings.archiving.private_archive') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="link_archive_pdf" id="link_archive_pdf" {{ $settings['link_archive_pdf'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="link_archive_pdf">{{ __('shaarli.settings.archiving.link_archive_pdf') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="node_bin">{{ __('shaarli.settings.archiving.node_bin') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control {{ $errors->has('node_bin') ? ' is-invalid' : '' }}" name="node_bin" id="node_bin" value="{{ $settings['node_bin'] }}">
                            <div class="input-group-append">
                                <check-archive type="pdf"></check-archive>
                            </div>
                        </div>
                        @error('node_bin')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="link_archive_media" id="link_archive_media" {{ $settings['link_archive_media'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="link_archive_media">{{ __('shaarli.settings.archiving.link_archive_media') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="youtube_dl_bin">{{ __('shaarli.settings.archiving.youtube_dl_bin') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control {{ $errors->has('youtube_dl_bin') ? ' is-invalid' : '' }}" name="youtube_dl_bin" id="youtube_dl_bin" value="{{ $settings['youtube_dl_bin'] }}">
                            <div class="input-group-append">
                                <check-archive type="media"></check-archive>
                            </div>
                        </div>
                        @error('youtube_dl_bin')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">{{ __('shaarli.settings.backup.title') }}</div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="backup_enabled" id="backup_enabled" {{ $settings['backup_enabled'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="backup_enabled">{{ __('shaarli.settings.backup.enabled') }}</label>
                        </div>
                        <span class="text-muted">{{ __('shaarli.settings.backup.enabled_help') }}</span>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="backup_only_database" id="backup_only_database" {{ $settings['backup_only_database'] ? ' checked' : '' }}>
                            <label class="custom-control-label" for="backup_only_database">{{ __('shaarli.settings.backup.only_database') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="backup_period">{{ __('shaarli.settings.backup.period') }}</label>
                        <select name="backup_period" id="backup_period" class="form-control custom-select">
                            <option value="daily"{{ $settings['backup_period'] == 'daily' ? ' selected' : '' }}>{{ __('shaarli.settings.backup.period_daily') }}</option>
                            <option value="weekly"{{ $settings['backup_period'] == 'weekly' ? ' selected' : '' }}>{{ __('shaarli.settings.backup.period_weekly') }}</option>
                        </select>
                        @error('backup_period')
                        <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
