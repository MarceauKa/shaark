@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
            <chest-form submit-url="{{ $submit }}"
                       @if(isset($chest))
                       :chest="{{ json_encode(\App\Http\Resources\ChestResource::make($chest)) }}"
                       @endif
                       method="{{ $method }}"
            ></chest-form>
        </div>
    </div>
</div>
@endsection
