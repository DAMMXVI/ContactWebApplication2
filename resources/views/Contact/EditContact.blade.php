@extends('Shared._Layout')
@section('head')
    <title>{{__('resources.EditContactTitle')}}</title>
@endsection
@section('content')
    <div class="page-header"><h2>{{__('resources.EditContactTitle')}}</h2></div>
    <hr />
    <div class="col-md-4">
        {{ Form::open(['action' => ['ContactsController@update', $contact->id], 'method' => 'PUT']) }}
                <div class="form-group">
                    <b>{{Form::label('fullName', __('resources.name'))}}</b>
                    {{Form::text('fullName', $contact->fullName, ['class' => 'form-control', 'placeholder' => __('resources.name')])}}
                </div>
                <div class="form-group">
                    <b>{{Form::label('phoneNumber', __('resources.phoneNumber'))}}  </b>  
                    {{Form::text('phoneNumber', $contact->phoneNumber, ['class' => 'form-control', 'placeholder' => __('resources.phoneNumber')])}}
                </div>
                <div class="form-group">
                    <b>{{Form::label('address', __('resources.address'))}}  </b>  
                    {{Form::text('address', $contact->address, ['class' => 'form-control', 'placeholder' => __('resources.address')])}}
                </div>
                <div class="form-group">
                    <b>{{Form::label('note', __('resources.note'))}}  </b>  
                    {{Form::textarea('note', $contact->note, ['class' => 'form-control', 'placeholder' => __('resources.addNote'), 'rows' => '4'])}}
                </div>
                <div class="form-group">
                    <b>{{Form::label('birth_year', __('resources.birth_year'))}}  </b>  
                    {{Form::date('birth_year', $contact->birth_year, ['class' => 'form-control'])}}
                </div>
                @include('Shared._messages')
                {{Form::submit(__('resources.save'), ['class' => 'btn btn-success'])}}
            {{ Form::close() }}
        </div>

@endsection