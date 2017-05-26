@extends('layouts.mobile')
@section('title', '密码重置')
@section('content')
    <div class="login-box">
        <?php
            //dd(session()->all());
            ?>
        <div class="login-box-body">
            <p class="login-box-msg">密码重置</p>
            <form action="{{ route('password_update') }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label>原始密码：</label>
                    <input type="text" class="form-control" name="password" placeholder="cellphone" required="required" value="{{ old('cellphone') }}">
                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('error') ? ' has-error' : '' }}">
                    <label>新密码：</label>
                    <input type="password" class="form-control" name="new_password" placeholder="Password" required="required">

                    @if ($errors->has('error'))
                        <span class="help-block">
                            <strong>{{ $errors->first('error') }}</strong>
                        </span>
                    @endif
                </div>
                <span class="help-block">
                    <strong>{{ session('password_update_error') }}</strong>
                    <?php session(['password_update_error' => '']);; ?>
                </span>
                <div class="form-group has-feedback">
                    <label>重复新密码：</label>
                    <input type="password" class="form-control" name="new_password_r" placeholder="Password" required="required">
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block" >确认</button>
                        <br>


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
