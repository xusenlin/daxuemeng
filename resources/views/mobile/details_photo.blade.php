@extends('layouts.mobile')
@section('title', $data->p_message)
@section('content')
    <div id="app" class="details">
        <div class="details_lease">
            <div class="user_avatar">
                <a href="JavaScript:;">
                    <img class="avatar-middle"  src="{{$data->u_avatar ? '/'.$data->u_avatar : asset('Backend/image/user.jpg') }}">
                </a>
            </div>
            <div class="lease_user">
                <h2 class="name">{{ $data->u_nickname }}<i class="iconfont  icon-sex {{ $data->u_sex == 1 ?'icon-nan': 'icon-nv' }}"></i></h2>
                <div class="address" style="    margin: 0 9px 0;">
                    <span class="photo-address" style="margin-left: 0">{{ $data->u_signature }}</span>
                </div>
            </div>
        </div>
        <div class="lease_sw">
            @foreach( explode(',',$data->p_photo)  as $img)
                <img src="{{ asset($img) }}" style="height: 100%;width: 100%">
            @endforeach
        </div>
        <br>
        <div class="lease_title">留言：{{ $data->p_message }}</div>
        <br>

        <div class="lease_comment">
            评论
        </div>
        <ul class="lease_comment_list">
            <li v-for="value in comment_list">
                <div class="details_lease">
                    <div class="user_avatar">
                        <a href="javascript:;">
                            <img class="avatar-middle"  :src="value.u_avatar ? '/'+value.u_avatar : '{{ asset('Backend/image/user.jpg') }}' ">
                        </a>
                    </div>
                    <div class="lease_user">
                        <h2 class="name">@{{ value.u_nickname }}<i :class="value.u_sex == 1 ?'icon-nan iconfont icon-sex': 'icon-nv iconfont icon-sex'"></i></h2>
                        <div class="address" style="    margin: 0 9px 0;">
                            <span class="photo-address" style="margin-left: 0">@{{ value.u_signature }}</span>
                        </div>
                    </div>
                </div>
                <div class="lease_comment_c">
                    <i class="iconfont icon-reply" style="color:#8cc0e7;    font-size: 20px; "></i>&nbsp;@{{ value.c_content }}
                </div>
            </li>
        </ul>
        <div class="lease-reply">
            <input class="" v-model="input">
            <div class="lease-reply-btn" @click = "comment()" >回复</div>
    </div>
    <mt-popup
            v-model="popupVisible"
            position="bottom" style="width: 100%">
        <div class="share-popup">
            <div  id="soshid" style="display: inline-block;"></div>
        </div>
    </mt-popup>
    </div>

@endsection
@section('js')
    <script src="{{ asset('Mobile/js/sosh.min.js') }}" type="application/javascript"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                popupVisible:false,
                selected:'1',
                input:'',
                comment_list:{!! json_encode($comments) !!} ,
                love_lease_color:'{{ isset($favorite)?'#f95f5f' : '#ababab' }}'
            },
            methods: {
                comment:function () {
                    var _sel = this;
                    if ((this.input).length<4){
                        _sel.$toast('回复的内容必须大于等于四个字符!');
                        return;
                    }
                    this.$indicator.open({
                        text: '提交中...',
                        spinnerType: 'fading-circle'
                    });
                    axios.post('{{ route('comment') }}', {
                                comment: _sel.input,
                                photo_id:{{ $data->p_id }},
                            })
                            .then(function (response) {
                                var res = response.data;
                                _sel.$indicator.close();

                                if(res.success){
                                    _sel.$toast(res.msg);
                                    _sel.comment_list.push({
                                        c_content: _sel.input,
                                        u_avatar: "{{ get_login_user('avatar') }}",
                                        u_nickname: "{{ get_login_user('nickname') }}",
                                        u_sex: "{{ get_login_user('sex') }}"
                                    });
                                    _sel.input = '';
                                }

                                _sel.$toast(res.msg);

                            })
                            .catch(function (error) {
                                _sel.$indicator.close();
                                _sel.$toast('服务器错误!');
                                console.log(error);
                            });
                },
                love_lease:function () {
                    var _sel = this;
                    this.$indicator.open({
                        text: '提交中...',
                        spinnerType: 'fading-circle'
                    });
                    axios.post('{{ route('lease_love') }}', {
                                lease_id:{{ $data->p_id }},
                            })
                            .then(function (response) {
                                var res = response.data;
                                _sel.$indicator.close();

                                if(res.success){
//                            _sel.$toast(res.msg);
                                    if (res.data){
                                        _sel.love_lease_color='#f95f5f';
                                        return;
                                    }
                                    _sel.love_lease_color='#ababab';
                                }

                                _sel.$toast(res.msg);
                            })
                            .catch(function (error) {
                                _sel.$indicator.close();
                                _sel.$toast('服务器错误!');
                                console.log(error);
                            });

                },
                share:function () {
                    var _sel = this;
                    _sel.popupVisible = true;
                }
            }
        });
        sosh('#soshid', {
            // 分享的链接，默认使用location.href
            url: location.href,
            // 分享的标题，默认使用document.title
            title: document.title,
            // 分享的摘要，默认使用<meta name="description" content="">content的值
            digest: '',
            // 分享的图片，默认获取本页面第一个img元素的src
            pic: '',
            // 选择要显示的分享站点，顺序同sites数组顺序，
            // 支持设置的站点有weixin,yixin,weibo,qzone,tqq,douban,renren,tieba
            sites: ['weixin,', 'weibo', 'douban', 'qzone','tieba','renren']
        })
    </script>
@endsection
