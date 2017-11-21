<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>用户登录-大学盟</title>
    <!-- 引入样式 -->
    <link rel="stylesheet" href="{{ asset('Mobile/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('Mobile/css/my-style.css?v1') }}">
    <link rel="stylesheet" href="{{ asset('Mobile/font/iconfont.css') }}">
</head>

<body>
    <div class="login-box">
        <div class="login-logo" style="text-align: center">
            <i class="iconfont icon-daxue" style="position: relative;top: 21px;font-size: 56px;color: #3c8dbc;"></i>
            <a href="javascript:;">大学盟</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">登录</p>
            <form action="{{ url('/login') }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback {{ $errors->has('cellphone') ? ' has-error' : '' }}">
                    <label>手机号或者昵称：</label>
                    <input type="text" class="form-control" name="cellphone" placeholder="cellphone" required="required" value="{{ old('cellphone') }}">
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
                                {{--<input type="checkbox" name="remember"> 记住我--}}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block" >登录</button>
                        <br>
                        <a href="{{ url('register') }}"  class="btn btn-primary btn-block" >注册</a>

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

<script src="{{ asset('Mobile/js/vue.js') }}"></script>
<script src="{{ asset('Mobile/js/axios.min.js') }}"></script>
<!-- Mint UI -->
<script src="{{ asset('Mobile/js/mint.js') }}"></script>
</body>
</html>
