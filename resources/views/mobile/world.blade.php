@extends('layouts.mobile')
@section('title', '世界')
@section('content')
<div id="app">
    <div style="height: 49px"></div>
    <mt-navbar v-model="selected " class="mint-header is-fixed" style="height: unset;padding: 0">
        <mt-tab-item id="1">最新</mt-tab-item>
        <mt-tab-item id="2">自拍</mt-tab-item>
        <mt-tab-item id="3">全景</mt-tab-item>
    </mt-navbar>

    <!-- tab-container -->
    <mt-tab-container v-model="selected">
        <mt-tab-container-item id="1">
            <mt-swipe :auto="4000" style="   height: 200px;    padding: 10px 10px 0;">
                <mt-swipe-item><div style="width: 100%;height: 100%;background-color: #26a2ff;color:#fff">1</div></mt-swipe-item>
                <mt-swipe-item><div style="width: 100%;height: 100%;background-color: #0daadd;color:#fff">2</div></mt-swipe-item>
                <mt-swipe-item><div style="width: 100%;height: 100%;background-color: #aaa7d0;color:#fff">3</div></mt-swipe-item>
            </mt-swipe>

            <ul class="list-ul">
                @if(@$data['lease'])
                    @foreach($data['lease'] as $item)
                        <li class="list-li">
                            <a href="{{ route('details_lease',$item->id) }}" class="item-content">
                                <div class="item-media">
                                    <img class="item-img" src="{{ asset($item->cover) }}">
                                </div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">{{ $item->title }}</div>
                                    </div>
                                    <div class="item-text" style="color: #56cbb8">租赁单价￥{{ $item->unit_price  }}</div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @endif
                @if(@$data['market'])
                        @foreach($data['market'] as $item)
                            <li class="list-li">
                                <a href="{{ route('details_market',$item->id) }}" class="item-content">
                                    <div class="item-media">
                                        <img class="item-img" src="{{ asset($item->cover) }}">
                                    </div>
                                    <div class="item-inner">
                                        <div class="item-title-row">
                                            <div class="item-title">{{ $item->title }}</div>
                                        </div>
                                        <div class="item-text" style="color: #56cbb8">二手单价￥{{ $item->original_price  }}</div>
                                        <div class="item-text-r" >已售{{ $item->sale_qty  }}</div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                @endif
            </ul>
        </mt-tab-container-item>
        <mt-tab-container-item id="2">
           <div class="zipai" id="zipai">
               <div class="zipai_con" style="padding-right: 4px">

                   {{--<div class="img_block">--}}
                       {{--<img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1493280768772&di=a114d76eec1e31494e6e654835f5424b&imgtype=0&src=http%3A%2F%2Fwww.3987.com%2Fdesk%2Fuploadfile%2F2013%2F0507%2F20130507102826593.jpg" alt="">--}}
                       {{--<div class="zp_msg">无聊啊啊啊佛挡杀佛东方饭店的方式多福多寿防守打法啊啊啊啊</div>--}}
                       {{--<div class="zp_info">--}}
                           {{--<div class="user_avatar">--}}
                               {{--<a href="">--}}
                                   {{--<img class="avatar-middle"  src="{{ asset('Backend/image/user.jpg') }}">--}}
                               {{--</a>--}}
                           {{--</div>--}}
                           {{--<div class="lease_user">--}}
                               {{--<h2 class="name">名字<i class="iconfont  icon-sex icon-nv"></i></h2>--}}
                               {{--<div class="address" style="    margin: 0 9px 0;">--}}
                                   {{--<span class="photo-address ellipsis" style="margin-left: 0">来自[花溪大学]</span>--}}
                               {{--</div>--}}
                           {{--</div>--}}
                       {{--</div>--}}
                   {{--</div>--}}
               </div>
               <div class="zipai_con" style="padding-left: 4px"></div>
           </div>
        </mt-tab-container-item>
        <mt-tab-container-item id="3">
            <ul class="list-ul">
                <li class="list-li">
                    <a href="http://720yun.com/t/b9ejOswatw8" class="item-content">
                        <div class="item-media">
                            <img class="item-img" src="{{ asset('Mobile/img/pb.png') }}">
                        </div>
                        <div class="item-inner">
                            <div class="item-title-row">
                                <div class="item-title">平坝樱花农场720云</div>
                            </div>
                            <div class="item-text">2017.04.01</div>
                        </div>
                    </a>
                </li>
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
                selected:'2',

            },
            methods: {

            }
        });
        (function () {
            var zipaiData = {!! json_encode($data['zipai']?:[]) !!};
            var zipai = document.querySelectorAll('#zipai .zipai_con');
            for (var i =0 ;i<zipaiData.length;i++){

                var thisObj = zipaiData[i];
                var html = '<a href="{{ route('details_photo') }}/'+thisObj.id+'" style="display: table;color:#000;" class="img_block"><img src="';
                html += ((thisObj.photo).split(','))[0];
                html += '" alt="">';
                html += '<div class="zp_msg">'+thisObj.message+'</div>';
                html += '<div class="zp_info"> <div class="user_avatar"> <img class="avatar-middle"  src="';
                html += thisObj.avatar? thisObj.avatar: '{{ asset('Backend/image/user.jpg') }}';
                html += '"> </div> <div class="lease_user"> <h2 class="name">';
                html += thisObj.nickname;
                html += '<i class="iconfont  icon-sex ';
                html += (thisObj.sex==1) ? 'icon-nan' : 'icon-nv';
                html += '"></i></h2> <div class="address" style="    margin: 0 9px 0;"> <span class="photo-address ellipsis" style="margin-left: 0">来自[花溪大学]</span> </div> </div>';
                html += '</div>';
                html += '';
                html += '';
                html +='</a>';
                zipai[min_index(zipai[0].offsetHeight,zipai[1].offsetHeight)].innerHTML += html;

            }
        })();
        function min_index(a,b){
            var min = 0;
            min = Math.min.apply(null, [a,b]);
            if (min==a)return 0;
            if (min==b)return 1;
        }

    </script>
@endsection
