@extends('layouts.mobile')
@section('title', '用户中心')
@section('content')
    <div id="app" v-cloak style="text-align: center">
        @if( !Auth::user())
            <span style="display: block;margin-top: 100px;text-align: center;">你还未登录,暂时没有用户中心!</span>
            <br>
            <a href="{{ url('/login') }}" style="text-align: center">登录/注册</a>
        @else
            <div class="mine-heard">
                <div class="user-avatar">
                    <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('Backend/image/user.jpg') }}" alt="">
                </div>
                <h2 class="user-name">{{ Auth::user()->nickname }}</h2>
                <h3 class="user-name" style="font-size: 12px;color: #c8deea">{{ Auth::user()->signature }}</h3>
            </div>
            <ul class="mine-list">
                <li class="line-mine"></li>
                <li class="">
                    <a class="" href="{{ route('personal') }}"><i class="iconfont icon-geren01" style="color: #d6b296;"></i>个人信息 <i class="iconfont icon-right"></i></a>
                </li>

                <li class="">
                    <a class="" href="{{ route('publish') }}"><i class="iconfont icon-zipai" style="color: #4CAF50;"></i>发表自拍<i class="iconfont icon-right"></i></a>
                </li>
                <li class="">
                    <a class="" href="{{ route('my_photo') }}"><i class="iconfont icon-tupian" style="color: #26a2ff;"></i>我的照片<i class="iconfont icon-right"></i></a>
                </li>
                <li class="">
                    <a class="" href="{{ route('my_collect') }}"><i class="iconfont icon-shoucang1" style="color: #ff7878;"></i>我收藏的照片<i class="iconfont icon-right"></i></a>
                </li>
                <li class="line-mine"></li>
                <li class="">
                    <a class="" href="{{ route('password_update_view') }}"><i class="iconfont icon-xiugai" style="color: #673AB7;"></i>修改密码<i class="iconfont icon-right"></i></a>
                </li>
                <li class="">
                    <a class="" href="{{ url('logout') }}"> <i class="iconfont icon-tuichu" style="color: #3c8dbc;"></i>退出登录<i class="iconfont icon-right"></i></a>
                </li>
                <li class="line-mine"></li>
            </ul>
        @endif
        @include('public.mobile.nav',['active'=>'我的'])
    </div>
@endsection
@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            methods: {
                handleClick: function() {
                    this.$toast('Hello world!')
                }
            }
        });

    </script>
@endsection
