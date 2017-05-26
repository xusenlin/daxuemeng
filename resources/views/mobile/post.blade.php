@extends('layouts.mobile')
@section('title', '帖子')
@section('content')
    <div id="app" style="padding: 8px">
        <a class="mint-cell post-list">
            <div class="user_avatar">
                <img class="avatar-middle"  src="{{ asset('Backend/image/user.jpg') }}">
            </div>
            <div class="post-title">js 中的for循环 怎么每循环一次睡眠3秒? 怎么每循环一次睡眠3秒???_已解决_博问_博客园</div>
            <i class="mint-cell-allow-right"></i>
        </a>
        <a class="mint-cell post-list">
            <div class="user_avatar">
                <img class="avatar-middle"  src="{{ asset('Backend/image/user.jpg') }}">
            </div>
            <div class="post-title">js 中的_博问_博客园js 中的for循环 怎么每循环一次睡眠3秒???_已解决_博问_博客园</div>
            <i class="mint-cell-allow-right"></i>
        </a>
        <a class="mint-cell post-list">
            <div class="user_avatar">
                <img class="avatar-middle"  src="{{ asset('Backend/image/user.jpg') }}">
            </div>
            <div class="post-title"> 中的for循环 怎么每循环一次睡眠3秒???_已解决_博问_博客园</div>
            <i class="mint-cell-allow-right"></i>
        </a>
    @include('public.mobile.nav',['active'=>'帖子'])
    </div>
@endsection
@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data:{

            },
            methods: {}
        });

    </script>
@endsection
