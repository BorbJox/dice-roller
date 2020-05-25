@extends('layout')

@section('includes')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
@endsection


@section('content')
    @parent

    <div class="containter p-5">
        <div class="row justify-content-center">
            <div class="col p-4 shadow cork-board" style="max-width: 400px;">

                @yield('form-content')

            </div>
        </div>
    </div>
@endsection
