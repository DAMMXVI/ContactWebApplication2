@extends('Shared._Layout')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
        <h1 class="h2">{{ __('resources.dashboard')}}</h1>
    </div>
    <canvas class="my-4" id="myChart" width="900" height="380"></canvas>
@endsection