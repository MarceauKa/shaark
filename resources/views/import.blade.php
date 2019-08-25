@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Import') }}</div>

                <div class="card-body">
                    <div class="alert alert-warning">
                        Attention, l'import a été testé avec la version <code>0.0.41</code> de Shaarli. Faites une sauvegarde avant toute tentative.
                    </div>

                    <p class="card-text">
                        Vous pouvez importer votre contenu depuis le <strong>Shaarli originel</strong>. Importez le fichier <code>data/datastore.php</code> (par défaut)
                        et vérifiez qu'il commence par <code>&lt;?php /* </code> et se termine par <code>*/ ?&gt;</code>.
                    </p>
                </div>

                <div class="card-footer">
                    <form method="POST" action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="file">Fichier d'import</label>
                            <input type="file" class="form-control-file {{ $errors->has('file') ? ' is-invalid' : '' }}" name="file" id="file" accept=".php">
                            @error('file')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="ignore_tags" id="ignore_tags">
                                        <label class="custom-control-label" for="ignore_tags">Ignorer les tags ?</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="get_extras" id="get_extras">
                                        <label class="custom-control-label" for="get_extras">Chercher les extras ?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="refresh_search" id="refresh_search">
                                        <label class="custom-control-label" for="refresh_search">Actualiser recherche ?</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary">{{ __('Importer') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
