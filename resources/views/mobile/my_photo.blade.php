@extends('layouts.mobile')
@section('title', '我的照片')
@section('content')
    <div id="app">
        <div class="my-photo">
            @foreach($records as  $record)
                <div class="img_block">
                    <img src="{{ explode(',',$record['photo'])[0] }}" alt="">
                    <div class="zp_msg">{{ $record['message'] }}</div>
                </div>
            @endforeach
        </div>
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
