@extends('adminlte::layouts.app')
@section('htmlheader_title')
    {{ __('cities.city') }}
@endsection
@section('contentheader_title')
    {{ __('cities.city') }}
@endsection
@section('contentheader_description')
    
@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url("admin") }}"><i class="fa fa-home"></i> {{ __("message.dashboard") }}</a></li>
        <li><a href="{{ url('/cities') }}">{{ __('cities.city') }}</a></li>
        <li class="active">{{ __('message.edit_title') }}</li>
    </ol>
@endsection

@section('main-content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('message.edit_title') }}</h3>
            <div class="box-tools">
                <a href="{{ url('/cities') }}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> <span class="hidden-xs">{{ __('message.lists') }}</span></a>
            </div>
        </div>

        {!! Form::model($city, [
            'method' => 'PATCH',
            'url' => ['/cities', $city->id],
            'class' => 'form-horizontal',
            'files' => true
        ]) !!}

        @include ('cities.form', ['submitButtonText' => __('message.update')])

        {!! Form::close() !!}
    </div>
@endsection