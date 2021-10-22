@extends('adminlte::layouts.app')
@section('htmlheader_title')
    {{ __('theme::news.news') }}
@endsection
@section('contentheader_title')
    {{ __('theme::news.news') }}
@endsection
@section('contentheader_description')

@endsection
@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url("admin") }}"><i class="fa fa-home"></i> {{ __("message.dashboard") }}</a></li>
        <li><a href="{{ url('/admin/news') }}">{{ __('theme::news.news') }}</a></li>
        <li class="active">{{ __("message.detail") }}</li>
    </ol>
@endsection
@section('main-content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __("message.detail") }}</h3>
            <div class="box-tools">
                <a href="{{ !empty($backUrl) ? $backUrl : url('/admin/news') }}" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> <span class="hidden-xs">{{ trans('message.lists') }}</span></a>
                @can('NewsController@update')
                    <a href="{{ url('/admin/news/' . $news->id . '/edit') }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span class="hidden-xs">{{ __('message.edit') }}</span></a>
                @endcan
                @can('NewsController@destroy')
                    {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['admin/news', $news->id],
                        'style' => 'display:inline'
                    ]) !!}
                    {!! Form::button('<i class="fa fa-trash-o" aria-hidden="true"></i> <span class="hidden-xs">'.__('message.delete').'</span>', array(
                            'type' => 'submit',
                            'class' => 'btn btn-danger btn-sm',
                            'title' => __('message.delete'),
                            'onclick'=>'return confirm("'.__('message.confirm_delete').'")'
                    ))!!}
                    {!! Form::close() !!}
                @endcan
            </div>
        </div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <th> {{ trans('theme::news.title') }} </th>
                    <td> {{ $news->title }} </td>
                </tr>
                @empty(!$news->category)
                    <tr>
                        <th> {{ trans('theme::news.url') }} </th>
                        <td> <a href="{{ url(($news->category)->slug) }}/{{ $news->slug }}.html">{{ url(($news->category)->slug) }}/{{ $news->slug }}.html</a> </td>
                    </tr>
                @endempty
                <tr>
                    <th> {{ trans('theme::news.category') }} </th>
                    <td> {{ !empty($news->category) ? $news->category->title : '' }} </td>
                </tr>
                <tr>
                    <th> {{ trans('theme::news.image') }} </th>
                    <td>
                        @if(!empty($news->image))
                            <img width="100" src="{{ asset($news->image) }}" alt="{{ $news->title }}"/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th> {{ trans('theme::news.description') }} </th>
                    <td>{{ $news->description }}</td>
                </tr>
                <tr>
                    <th> {{ trans('theme::news.content') }} </th>
                    <td>{!! $news->content !!}</td>
                </tr>
                <tr>
                    <th> {{ trans('theme::news.updated_at') }} </th>
                    <td> {{ Carbon\Carbon::parse($news->updated_at)->format(config('settings.format.datetime')) }} </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection