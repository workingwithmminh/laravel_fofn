@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.register') }}
@endsection

@section('content')

    <body class="hold-transition">
        <div id="app" class="register-page row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
            <div class="register-box-company">
                <div class="register-logo">
                    <a href="{{ url('/') }}">{!! Config("settings.app_logo") !!}</a>
                </div>
                @if (Session::has('flash_info'))
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="fa fa-fw fa-check"></i> {{ Session::get('flash_info') }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p><i class="fa fa-fw fa-check"></i> {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="register-box-body">
                    <h4 class="login-box-msg" style="color: #0052ad;text-transform: uppercase;">{{ trans('adminlte_lang::message.registermember') }}</h4>
                    <form action="{{ url('/register') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        {{--<h4>{{ __('message.user.account_info') }}</h4>--}}
                        {{--<h5>THÔNG TIN CÁ NHÂN</h5>--}}
                        <div class="row">
                        <div class="col-sm-6">
                            @if (config('auth.providers.users.field','email') === 'username')
                                <div class="form-group has-feedback">
                                    <label for="username">{{ trans('adminlte_lang::message.username') }}: <font color="red">*</font></label>
                                    <input type="text" class="form-control" placeholder="{{ trans('adminlte_lang::message.phone') }}" required name="username" id="username" value="{{ old('username') }}" autofocus/>
                                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                </div>
                            @endif
                            <div class="form-group has-feedback">
                                <label for="password">{{ trans('adminlte_lang::message.password') }}: <font color="red">*</font></label>
                                <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" required name="password" id="password"/>
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="password_confirmation">{{ trans('adminlte_lang::message.retypepassword') }}: <font color="red">*</font></label>
                                <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.retypepassword') }}" required name="password_confirmation" id="password_confirmation"/>
                                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="name">{{ trans('adminlte_lang::message.fullname') }}: <font color="red">*</font></label>
                                <input type="text" class="form-control" placeholder="{{ trans('adminlte_lang::message.fullname') }}" required name="name" id="name" value="{{ old('name') }}" />
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group has-feedback">
                                <label for="email">{{ trans('adminlte_lang::message.email') }}: <font color="red">*</font></label>
                                <input type="email" class="form-control" placeholder="{{ trans('adminlte_lang::message.email') }}" required name="email" id="email" value="{{ old('email') }}"/>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="profile_birthday">{{ trans('message.user.birthday') }}: </label>
                                <input type="date" class="form-control" placeholder="{{ trans('message.user.birthday') }}" name="profile[birthday]" id="profile_birthday" value="{{ old('profile.birthday') }}"/>
                                <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="profile_address">{{ trans('message.user.address') }}: </label>
                                <input type="text" class="form-control" placeholder="{{ trans('message.user.address') }}" name="profile[address]" id="profile_address" value="{{ old('profile.address') }}"/>
                                <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label></label>
                                <div class="checkbox_register icheck">
                                    <label>
                                        <input type="radio" name="role" {{ old('role') !== config('settings.roles.agent_admin') ? "checked" : ""}} value="{{ config('settings.roles.customer') }}"/>
                                        {{ __('message.role.role_customer') }}
                                    </label>
                                    &nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="role" {{ old('role') === config('settings.roles.agent_admin') ? "checked" : ""}} value="{{ config('settings.roles.agent_admin') }}" />
                                        {{ __('message.role.role_agent') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label>
                                <div class="checkbox_register icheck">
                                    <label>
                                        <input type="checkbox" name="terms" required />
                                    </label>
                                </div>
                            </label>
                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#termsModal">{{ trans('adminlte_lang::message.terms') }}</button>
                        </div>
                        <div class="form-group">
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary  btn-flat">{{ trans('adminlte_lang::message.register') }}</button>
                                <a href="{{ url('/login') }}" class="text-center">{{ trans('adminlte_lang::message.membreship') }}</a>
                            </div>
                        </div>
                    </form>

                    {{--@include('adminlte::auth.partials.social_login')--}}


                </div><!-- /.form-box -->
            </div><!-- /.register-box -->
        </div>
    </div>

    @include('adminlte::layouts.partials.scripts_auth')

    @include('adminlte::auth.terms')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%'
            });
        });
    </script>

    </body>
@endsection
