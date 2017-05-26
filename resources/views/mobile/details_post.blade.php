@extends('layouts.mobile')
@section('title', $data->title)
@section('content')
    <div id="app" class="details">
        {{--<header class="mint-header is-fixed">--}}
            {{--<div class="mint-header-button is-left">--}}
                {{--<a href="/" class="router-link-active">--}}
                    {{--<button class="mint-button mint-button--default mint-button--normal">--}}
                        {{--<span class="mint-button-icon"><i class="mintui mintui-back"></i></span>--}}
                        {{--<label class="mint-button-text">返回</label></button></a></div>--}}
            {{--<h1 class="mint-header-title">{{ $data->title }}</h1>--}}
            {{--<div class="mint-header-button is-right">--}}
                {{--<button class="mint-button mint-button--default mint-button--normal">--}}
                    {{--<span class="mint-button-icon"><i class="mintui mintui-more"></i></span> <label class="mint-button-text"></label>--}}
                {{--</button>--}}
            {{--</div>--}}
        {{--</header>--}}
        {{--<div style="height: 42px"></div>--}}

        <h1>{{ $data->title }}</h1>
        <div class="details-data">{{ substr($data->created_at,0,10) }}</div>
        <div class="details-tag">驾校</div>

        <div class="details-content">
            {{ $data->content  }}
        </div>

    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data:{
                selected:'1'
            },
            methods: {

            }
        })
    </script>
@endsection
