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
                        <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                               name="name" id="name" value="{{ old('name', $settings['name']) }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="locale">{{ __('shaarli.settings.general.lang') }}</label>
                        <select name="locale" id="locale" class="form-control custom-select">
                            <option value="fr"{{ old('locale', $settings['locale']) == 'fr' ? ' selected' : '' }}>FR</option>
                            <option value="en"{{ old('locale', $settings['locale']) == 'en' ? ' selected' : '' }}>EN</option>
                            <option value="de"{{ old('locale', $settings['locale']) == 'de' ? ' selected' : '' }}>DE</option>
                            <option value="ja"{{ old('locale', $settings['locale']) == 'ja' ? ' selected' : '' }}>JA</option>
                        </select>
                        @error('locale')
                        <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input"
                                   name="is_private" id="is_private" {{ old('is_private', $settings['is_private']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="is_private">{{ __('shaarli.settings.general.private_help') }}</label>
                        </div>
                        @error('is_private')
                        <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input"
                                   name="private_download" id="private_download" {{ old('private_download', $settings['private_download']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="private_download">{{ __('shaarli.settings.general.private_download') }}</label>
                        </div>
                        @error('private_download')
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
                            <input type="checkbox" class="custom-control-input"
                                   name="is_dark" id="is_dark" {{ old('is_dark', $settings['is_dark']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="is_dark">{{ __('shaarli.settings.appearance.is_dark') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input"
                                   name="home_show_tags" id="home_show_tags" {{ old('home_show_tags', $settings['home_show_tags']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="home_show_tags">{{ __('shaarli.settings.appearance.home_show_tags') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input"
                                   name="home_show_chests" id="home_show_chests" {{ old('home_show_chests', $settings['home_show_chests']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="home_show_chests">{{ __('shaarli.settings.appearance.home_show_chests') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input"
                                   name="compact_cardslist" id="compact_cardslist" {{ old('compact_cardslist', $settings['compact_cardslist']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="compact_cardslist">{{ __('shaarli.settings.appearance.compact_cardslist') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('shaarli.settings.appearance.columns_count') }}</label>
                        <input type="number" class="form-control {{ $errors->has('columns_count') ? ' is-invalid' : '' }}" step="1" min="1" max="4"
                               name="columns_count" id="columns_count" value="{{ old('columns_count', $settings['columns_count']) }}">

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
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    {{ __('shaarli.settings.2fa.title') }}
                    <span>
                        <check-feature type="email" class="btn btn-sm btn-outline-secondary" text="{{ __('shaarli.settings.2fa.check_email') }}"></check-feature>
                    </span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="secure_login" id="secure_login" {{ old('secure_login', $settings['secure_login']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="secure_login">{{ __('shaarli.settings.2fa.secure_login') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('shaarli.settings.2fa.secure_code_expires') }}</label>
                        <input type="number" class="form-control {{ $errors->has('secure_code_expires') ? ' is-invalid' : '' }}" step="5"
                               name="secure_code_expires" id="secure_code_expires" value="{{ old('secure_code_expires', $settings['secure_code_expires']) }}">
                        @error('secure_code_expires')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('shaarli.settings.2fa.secure_code_length') }}</label>
                        <input type="number" class="form-control {{ $errors->has('secure_code_length') ? ' is-invalid' : '' }}" step="1"
                               name="secure_code_length" id="secure_code_length" value="{{ old('secure_code_length', $settings['secure_code_length']) }}">

                        @error('secure_code_length')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    {{ __('shaarli.settings.archiving.title') }}
                    <span>
                        <check-feature type="pdf" class="btn btn-sm btn-outline-secondary" text="{{ __('shaarli.settings.archiving.check_pdf_archiving') }}"></check-feature>
                        <check-feature type="media" class="btn btn-sm btn-outline-secondary" text="{{ __('shaarli.settings.archiving.check_media_archiving') }}"></check-feature>
                        <a href="{{ route('manage.archives') }}" class="btn btn-sm btn-outline-primary" >{{ __('Manage') }}</a>
                    </span>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input"
                                   name="link_archive_pdf" id="link_archive_pdf" {{ old('link_archive_pdf', $settings['link_archive_pdf']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="link_archive_pdf">{{ __('shaarli.settings.archiving.link_archive_pdf') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="node_bin">{{ __('shaarli.settings.archiving.node_bin') }}</label>
                        <input type="text" class="form-control {{ $errors->has('node_bin') ? ' is-invalid' : '' }}"
                               name="node_bin" id="node_bin" value="{{ old('node_bin', $settings['node_bin']) }}">
                        @error('node_bin')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input"
                                   name="link_archive_media" id="link_archive_media" {{ old('link_archive_media', $settings['link_archive_media']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="link_archive_media">{{ __('shaarli.settings.archiving.link_archive_media') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="youtube_dl_bin">{{ __('shaarli.settings.archiving.youtube_dl_bin') }}</label>
                        <input type="text" class="form-control {{ $errors->has('youtube_dl_bin') ? ' is-invalid' : '' }}"
                               name="youtube_dl_bin" id="youtube_dl_bin" value="{{ old('youtube_dl_bin', $settings['youtube_dl_bin']) }}">
                        @error('youtube_dl_bin')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="python_bin">{{ __('shaarli.settings.archiving.python_bin') }}</label>
                        <input type="text" class="form-control {{ $errors->has('python_bin') ? ' is-invalid' : '' }}"
                               name="python_bin" id="python_bin" value="{{ old('python_bin', $settings['python_bin']) }}">
                        @error('python_bin')
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
                            <input type="checkbox" class="custom-control-input"
                                   name="backup_enabled" id="backup_enabled" {{ old('backup_enabled', $settings['backup_enabled']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="backup_enabled">{{ __('shaarli.settings.backup.enabled') }}</label>
                        </div>
                        <span class="text-muted">{{ __('shaarli.settings.backup.enabled_help') }}</span>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input"
                                   name="backup_only_database" id="backup_only_database" {{ old('backup_only_database', $settings['backup_only_database']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="backup_only_database">{{ __('shaarli.settings.backup.only_database') }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="backup_period">{{ __('shaarli.settings.backup.period') }}</label>
                        <select name="backup_period" id="backup_period" class="form-control custom-select">
                            <option value="daily"{{ old('backup_period', $settings['backup_period']) == 'daily' ? ' selected' : '' }}>{{ __('shaarli.settings.backup.period_daily') }}</option>
                            <option value="weekly"{{ old('backup_period', $settings['backup_period']) == 'weekly' ? ' selected' : '' }}>{{ __('shaarli.settings.backup.period_weekly') }}</option>
                        </select>
                        @error('backup_period')
                        <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">{{ __('shaarli.settings.images.title') }}</div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input"
                                   name="images_original_resize" id="images_original_resize" {{ old('images_original_resize', $settings['images_original_resize']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="images_original_resize">{{ __('shaarli.settings.images.images_original_resize') }}</label>
                        </div>
                        @error('images_original_resize')
                        <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('shaarli.settings.images.images_original_resize_width') }}</label>
                        <input type="number" class="form-control {{ $errors->has('images_original_resize_width') ? ' is-invalid' : '' }}" step="100" min="500" max="5000"
                               name="images_original_resize_width" id="images_original_resize_width" value="{{ old('images_original_resize_width', $settings['images_original_resize_width']) }}">
                        @error('images_original_resize_width')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="images_thumb_format">{{ __('shaarli.settings.images.images_thumb_format') }}</label>
                        <select name="images_thumb_format" id="images_thumb_format" class="form-control custom-select">
                            <option value="square"{{ old('images_thumb_format', $settings['images_thumb_format']) == 'square' ? ' selected' : '' }}>{{ __('shaarli.settings.images.format_square') }}</option>
                            <option value="original"{{ old('images_thumb_format', $settings['images_thumb_format']) == 'original' ? ' selected' : '' }}>{{ __('shaarli.settings.images.format_original') }}</option>
                        </select>
                        @error('images_thumb_format')
                        <span class="text-danger" role="alert">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" name="images_thumb_queue"
                                   id="images_thumb_queue" {{ old('images_thumb_queue', $settings['images_thumb_queue']) ? ' checked' : '' }}>
                            <label class="custom-control-label" for="images_thumb_queue">{{ __('shaarli.settings.images.images_thumb_queue') }}</label>
                        </div>
                        @error('images_thumb_queue')
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
