@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.passwordreset') }}
@endsection

@section('content')

    <body class="login-page">

    <div id="app">
        <div class="login-box">
            <div class="login-logo">
                <a href="{{ url('/home') }}">{!! Config("settings.app_logo") !!}</a>
            </div><!-- /.login-logo -->

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p><i class="fa fa-fw fa-check"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="login-box-body">
                <p class="login-box-msg">{{ trans('adminlte_lang::message.passwordreset') }}</p>
                <form action="{{ url('/password/reset') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" autofocus/>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password confirm" name="password_confirmation"/>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-1">
                        </div><!-- /.col -->
                        <div class="col-xs-10">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.passwordreset') }}</button>
                        </div><!-- /.col -->
                    </div>
                </form>

                <a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a><br>
                <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a>

            </div><!-- /.login-box-body -->

        </div><!-- /.login-box -->
    </div>

    @include('adminlte::layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    </body>

@endsection