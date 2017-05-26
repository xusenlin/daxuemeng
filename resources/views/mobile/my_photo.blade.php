@extends('layouts.mobile')
@section('title', '我的照片')
@section('content')
    <div id="app">
        <?php
            if(count($records)%2 == 0) $pos = count($records)/2;
            else $pos = count($records)/2 + 1;
        ?>
        <div class="zipai_con" style="padding-right: 4px">
            @foreach(array_slice($records,0,$pos) as  $record)
                <div class="img_block">
                    <img src="{{ explode(',',$record['photo'])[0] }}" alt="">
                    <div class="zp_msg">{{ $record['message'] }}</div>
                </div>
            @endforeach
        </div>
        <div class="zipai_con" style="padding-left: 4px">
            @foreach(array_slice($records,$pos)  as  $record)
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
