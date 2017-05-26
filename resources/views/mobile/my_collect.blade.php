@extends('layouts.mobile')
@section('title', '我的收藏')
@section('content')
    <div id="app">
        <div class="zipai_con" style="padding-right: 4px">
            @if(!isset($zipai))
                <span style="display: block;margin-top: 100px;text-align: center;">你还没有收藏照片!</span>
            @endif
        </div>
        <div class="zipai_con" style="padding-left: 4px"></div>
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

        (function () {
            var zipaiData = {!! json_encode(isset($zipai) ? $zipai : []) !!};
            var zipai = document.querySelectorAll('#app .zipai_con');
            for (var i =0 ;i<zipaiData.length;i++){

                var thisObj = zipaiData[i];
                var html = '<div class="img_block"><img src="';
                html += ((thisObj.photo).split(','))[0];
                html += '" alt="">';
                html += '<div class="zp_msg">'+thisObj.message+'</div>';
                html += '<div class="zp_info"> <div class="user_avatar"> <a href=""><img class="avatar-middle"  src="';
                html += thisObj.avatar? thisObj.avatar: '{{ asset('Backend/image/user.jpg') }}';
                html += '"> </a> </div> <div class="lease_user"> <h2 class="name">';
                html += thisObj.nickname;
                html += '<i class="iconfont  icon-sex ';
                html += (thisObj.sex==1) ? 'icon-nan' : 'icon-nv';
                html += '"></i></h2> <div class="address" style="    margin: 0 9px 0;"> <span class="photo-address ellipsis" style="margin-left: 0">来自[花溪大学]</span> </div> </div>';
                html += '</div>';
                html += '';
                html += '';
                html +='</div>';
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
