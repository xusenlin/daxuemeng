@extends('layouts.mobile')
@section('title', '世界')
@section('content')
<div id="app" v-cloak>
    <div style="height: 49px"></div>
    <mt-navbar v-model="selected " class="mint-header is-fixed" style="height: unset;padding: 0" v-cloak>
        <mt-tab-item id="1">全景</mt-tab-item>
        <mt-tab-item id="2">自拍</mt-tab-item>
        <mt-tab-item id="3">社团</mt-tab-item>
    </mt-navbar>

    <!-- tab-container -->
    <mt-tab-container v-model="selected" v-cloak>
        <mt-tab-container-item id="1">
            <ul class="list-ul">
                @foreach($data['panoramas'] as $panoramas)
                    <li class="list-li">
                        <a href="{{ $panoramas->url }}" class="item-content">
                            <div class="item-media">
                                <img class="item-img" src="{{ asset($panoramas->cover) }}">
                            </div>
                            <div class="item-inner">
                                <div class="item-title-row">
                                    <div class="item-title">{{ $panoramas->name }}</div>
                                </div>
                                <div class="item-title" style="color: #717171;font-size: 12px">{{ $panoramas->remarks }}</div>
                                <div class="item-text">{{ $panoramas->created_at }}</div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </mt-tab-container-item>
        <mt-tab-container-item id="2">
           <div class="zipai" id="zipai">
                @foreach($data['zipai'] as $value)
                   <div class="img_block">
                       <a href="{{ route('details_photo',$value->id) }}"><img src="{{ explode(',',$value->photo)[0] }}" alt=""></a>
                       <div class="zp_msg">{{ $value->message }}</div>
                       <div class="zp_info">
                           <div class="user_avatar">
                               <a href="">
                                   <img class="avatar-middle"  src="{{ $value->avatar?:asset('Backend/image/user.jpg') }}">
                               </a>
                           </div>
                           <div class="lease_user">
                               <h2 class="name">{{ $value->nickname }}<i class="iconfont  icon-sex {{ $value->sex == 1 ? 'icon-nan' :'icon-nv' }}"></i></h2>
                               <div class="address" style="    margin: 0 9px 0;">
                                   <span class="photo-address ellipsis" style="margin-left: 0;top: 6px">{{ $value->place?:'花溪大学城' }}</span>
                               </div>
                           </div>
                       </div>
                   </div>
                @endforeach
           </div>
        </mt-tab-container-item>
        <mt-tab-container-item id="3">
            <mt-swipe :auto="4000" style="height: 200px;background: #fff;padding: 10px 10px 10px;">
                @for($i=0;$i<5;$i++)
                    <mt-swipe-item>
                        <a href="{{ route('details',@$data['league'][$i]->id) }}" style="width: 100%;height: 100%;background-color: #26a2ff;color:#fff">
                            <img style="width: 100%;height: 100%" src="{{ @asset($data['league'][$i]->cover) }}" alt="">
                        </a>
                    </mt-swipe-item>
                @endfor
            </mt-swipe>

            <ul class="list-ul">
                @if(@$data['league'])
                    @foreach($data['league'] as $item)
                        <li class="list-li">
                            <a href="{{ route('details',$item->id) }}" class="item-content">
                                <div class="item-media">
                                    <img class="item-img" src="{{ asset($item->cover) }}">
                                </div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">{{ $item->title }}</div>
                                    </div>
                                    <div class="item-title" style="color: #717171;font-size: 12px">{{ $item->excerpt }}</div>
                                    <div class="item-text">{{ $item->created_at }}</div>
                                </div>
                            </a>
                        </li>
                        {{--<li class="list-li">--}}
                            {{--<a href="{{ route('details_lease',$item->id) }}" class="item-content">--}}
                                {{--<div class="item-media">--}}
                                    {{--<img class="item-img" src="{{ asset($item->cover) }}">--}}
                                {{--</div>--}}
                                {{--<div class="item-inner">--}}
                                    {{--<div class="item-title-row">--}}
                                        {{--<div class="item-title">{{ $item->title }}</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="item-text" style="color: #56cbb8">租赁单价￥{{ $item->unit_price  }}</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    @endforeach
                @endif
                {{--@if(@$data['market'])--}}
                    {{--@foreach($data['market'] as $item)--}}
                        {{--<li class="list-li">--}}
                            {{--<a href="{{ route('details_market',$item->id) }}" class="item-content">--}}
                                {{--<div class="item-media">--}}
                                    {{--<img class="item-img" src="{{ asset($item->cover) }}">--}}
                                {{--</div>--}}
                                {{--<div class="item-inner">--}}
                                    {{--<div class="item-title-row">--}}
                                        {{--<div class="item-title">{{ $item->title }}</div>--}}
                                    {{--</div>--}}
                                    {{--<div class="item-text" style="color: #56cbb8">二手单价￥{{ $item->original_price  }}</div>--}}
                                    {{--<div class="item-text-r" >已售{{ $item->sale_qty  }}</div>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--@endforeach--}}
                {{--@endif--}}
            </ul>
        </mt-tab-container-item>
    </mt-tab-container>
    @include('public.mobile.nav',['active'=>'世界'])
</div>
@endsection
@section('js')
    <script>
        console.log({!! json_encode($data['zipai']) !!});
        new Vue({
            el: '#app',
            data:{
                selected:'3',

            },
            methods: {

            }
        });

        function min_index(a,b){
            var min = 0;
            min = Math.min.apply(null, [a,b]);
            if (min==a)return 0;
            if (min==b)return 1;
        }

    </script>
@endsection
