@extends('layouts.mobile')
@section('title', $data->s_title)
@section('content')
    <div id="app" class="details">
        <div class="details_lease">
            <div class="user_avatar">
                <a href="{{ $data->u_id }}">
                    <img class="avatar-middle"  src="{{$data->u_avatar ? $data->u_avatar : asset('Backend/image/user.jpg') }}">
                </a>
            </div>
            <div class="lease_user">
                <h2 class="name">{{ $data->u_nickname }}<i class="iconfont  icon-sex {{ $data->u_sex == 1 ?'icon-nan': 'icon-nv' }}"></i></h2>
                <div class="address" style="    margin: 0 9px 0;">
                    <span class="photo-address" style="margin-left: 0">一小时前 &nbsp; 来自[.....]</span>
                </div>
            </div>
        </div>
        <div class="lease_sw">
            @if($data->s_images)
            <mt-swipe :auto="4000" style="   height: 200px; margin: 10px 0">
                @foreach( explode(',',$data->s_images)  as $img)
                    <mt-swipe-item><img src="{{ asset($img) }}" style="width: 100%;height: 100%;"></mt-swipe-item>
                @endforeach
            </mt-swipe>
            @else
                <div class="no-photo">暂无图片</div>
            @endif
        </div>
        <div class="lease_price">
            <span>￥{{ $data->s_sale_price }}</span> <span style="color: #9c9c9c;font-size: 12px;">剩余{{ $data->s_total_qty - $data->s_sale_qty }}</span>
        </div>
        <div class="lease_title">{{ $data->s_title }}</div>
        <div class="lease_d">
            {{ $data->s_description }}
        </div>
        <div class="lease_c clearfix">
            <div class="phone"><i class="iconfont icon-shouji"></i>{{ $data->s_cellphone }}</div>
            <div class="tag">
                <div class="details-tag tag_red">{{ $data->s_tag }}</div>
                <div class="details-tag tag_yellow">包邮</div>
            </div>
        </div>
    </div>
    </div>

@endsection
@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data:{

            },
            methods: {

            }
        });

    </script>
@endsection
