@extends('layouts.mobile')
@section('title', '用户注册')
@section('content')
    <div class="login-box">
        {{--<div class="login-logo">--}}
            {{--<a href="javascript:;">大学盟</a>--}}
        {{--</div>--}}
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">注册一个用户</p>
            <form action="{{ url('/register') }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback {{ $errors->has('cellphone') ? ' has-error' : '' }}">
                    <label>手机号：</label>
                    <input type="text" class="form-control" name="cellphone" placeholder="cellphone" required="required" value="{{ old('cellphone') }}">
                    @if ($errors->has('cellphone'))
                        <span class="help-block">
                        <strong>{{ $errors->first('cellphone') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('nickname') ? ' has-error' : '' }}">
                    <label>昵称：</label>
                    <input type="text" class="form-control" name="nickname" placeholder="nickname" required="required" value="{{ old('nickname') }}">
                    @if ($errors->has('nickname'))
                        <span class="help-block">
                        <strong>{{ $errors->first('nickname') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>用户密码：</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label>确认用户密码：</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="password_confirmation">
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">注册</button>
                    </div>
                    <div class="col-md-4 col-md-offset-4">
                        <a href="{{ url('/login') }}" class="btn btn-primary btn-block btn-flat">返回登陆</a>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <br/>

            {{--<a href="{{ url('/password/reset') }}">I forgot my password</a><br>--}}
            {{--<a href="{{ url('/register') }}" class="text-center">Register a new membership</a>--}}

        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
