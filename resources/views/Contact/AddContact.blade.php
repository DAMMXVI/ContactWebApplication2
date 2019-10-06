@extends('Shared._layout')
@section('head')
<title>{{__('resources.AddContactTitle')}}</title>  
@endsection
@section('content')
    <div class="page-header"><h1>{{__('resources.AddContactTitle')}}</h1></div>
    <hr />
    <div class="col-md-4">
        {{ Form::open(['action' => 'ContactsController@store', 'method' => 'POST']) }}
            <div class="form-group">
                <b>{{Form::label('fullName', __('resources.name'))}}</b>
                {{Form::text('fullName', '', ['class' => 'form-control', 'placeholder' => __('resources.name')])}}
            </div>
            <div class="form-group">
                <b>{{Form::label('phoneNumber', __('resources.phoneNumber'))}}  </b>  
                {{Form::text('phoneNumber', '', ['class' => 'form-control', 'placeholder' => __('resources.phoneNumber')])}}
            </div>
            <div class="form-group">
                <b>{{Form::label('address', __('resources.address'))}}  </b>  
                {{Form::text('address', '', ['class' => 'form-control', 'placeholder' => __('resources.address')])}}
            </div>
            <div class="form-group">
                <b>{{Form::label('note', __('resources.note'))}}  </b>  
                {{Form::textarea('note', '', ['class' => 'form-control', 'placeholder' => __('resources.addNote'), 'rows' => '4'])}}
            </div>
            <div class="form-group">
                <b>{{Form::label('birth_year', __('resources.birth_year'))}}  </b>  
                {{Form::date('birth_year', '', ['class' => 'form-control'])}}
            </div>
            @include('Shared._messages')
            {{Form::submit(__('resources.add'), ['class' => 'btn btn-success'])}}
        {{ Form::close() }}
    </div>
@endsection
