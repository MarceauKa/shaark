@extends('layouts.manage')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Export') }}</div>

            <div class="card-body">
                <p class="card-text">
                    Vous pouvez exporter vos <strong>liens</strong>, <strong>stories</strong> et <strong>coffres</strong>.
                    L'export se fait au format <code>.xslx</code> ou <code>.csv</code>.
                </p>
            </div>

            <div class="card-footer">
                <form method="POST" action="{{ route('manage.export') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="type">Source</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="links">{{ __('Links') }}</option>
                                    <option value="stories">{{ __('Stories') }}</option>
                                    <option value="chests">{{ __('Chests') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="format">Format</label>
                                <select name="format" id="format" class="form-control">
                                    <option value="xlsx">.xlsx</option>
                                    <option value="csv">.csv</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Export') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
