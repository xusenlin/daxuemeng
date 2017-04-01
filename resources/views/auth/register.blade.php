<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>系统后台用户注册</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('Icon/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('Icon/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/Skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Backend/css/style.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="javascript:;"><b>大学盟</b>v0.1</a>
    </div>
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
<!-- /.login-box -->

<!-- jQuery 1.1.1 -->
<script src="{{ asset('AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('AdminLTE/bootstrap/js/bootstrap.min.js') }}"></script>

</body>
</html>
