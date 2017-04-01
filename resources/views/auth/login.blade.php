<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>系统后台管理</title>
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
        <p class="login-box-msg">登录后台管理</p>

        <form action="{{ url('/login') }}" method="post">
            {!! csrf_field() !!}
            <div class="form-group has-feedback {{ $errors->has('cellphone') ? ' has-error' : '' }}">
                <label>手机号或者昵称：</label>
                <input type="text" class="form-control" name="cellphone" placeholder="cellphone" required="required">
                @if ($errors->has('cellphone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('cellphone') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                <label>密码：</label>
                <input type="password" class="form-control" name="password" placeholder="Password">
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck login-check">
                        <label>
                            <input type="checkbox" name="remember"> 记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">登录</button>
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








