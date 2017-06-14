@extends('layouts.mobile')
@section('title', '发表')
@section('content')
    <div id="app" style="padding: 8px">
        @if( !Auth::user())
            <span style="display: block;margin-top: 100px;text-align: center;">你还未登录,暂时无法发表内容!</span>
            <br>
            <a href="{{ url('/login') }}" style="display: block;text-align: center">登录/注册</a>
        @else
            <div class="form-group">
                <label>留言：</label>
                <input type="text" class="form-control" name="message" placeholder="说点什么吧！" required="required" value="" v-model="form_data.user_message">
            </div>

            <div class="form-group clearfix">
                <label>上传图片：</label>
                <small class="tishi_zp">提示：第一张将作为展示的封面！</small>
                <div class="uploader_files" id="uploader_files_list">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="weui_uploader_input_wrp" @click="uploader()">
                    <input style="display: none" type="file"  accept="image/*" multiple="" id="img" @change="img_change('img')"  >
                    <input style="display: none" type="file" accept="image/*"  capture="camera" id="camera" @change="img_change('camera')">
                </div>
            </div>
            {{--<label>上传地点：</label>--}}
            {{--<div class="address">--}}
                {{--<i style="color: #a7a7a7" class="iconfont icon-address"></i><span class="photo-address">贵州省贵阳市花溪区花溪大学城</span>--}}
            {{--</div>--}}
    <br><br><br>
             <button type="submit" class="btn btn-primary btn-block" @click="submit_data">确认发表</button>
    <div  style="height: 55px"></div>
            <mt-actionsheet
                    :actions="actions"
                    v-model="sheetVisible">
            </mt-actionsheet>
        @endif
    </div>
@endsection
@section('js')
    <script src="{{ asset('Mobile/js/lrz.all.bundle.js') }}" type="application/javascript"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                sheetVisible:false,
                actions:[],
                form_data:{
                    user_message:'',
                    city:'贵州省贵阳市花溪区花溪大学城',
                },
                photo:[],
            },
            methods: {
                uploader:function () {
                  this.sheetVisible = true;
                },
                camera:function () {
                    document.getElementById('camera').click();
                },
                photo_click:function () {
                    document.getElementById('img').click();
                },
                img_change:function (id) {
                    var _sel = this;
                    this.$indicator.open({
                        text: '图片压缩中...',
                        spinnerType: 'fading-circle'
                    });
                    var photo_con = document.querySelectorAll('#uploader_files_list div');
                    lrz(document.getElementById(id).files[0])
                    .then(function (rst) {
                        var html = '<img src="'+rst.base64+'" alt="">';
                        _sel.photo.push(rst.base64);
                        photo_con[min_index(photo_con[0].offsetHeight,photo_con[1].offsetHeight,photo_con[2].offsetHeight)].innerHTML += html;

                    })
                    .catch(function (err) {
                        _sel.$indicator.close();
                        // 处理失败会执行
                    })
                    .always(function () {
                        // 不管是成功失败，都会执行
                        _sel.$indicator.close();
                    });

                },
                submit_data:function () {
                    var _sel = this;
                    if ((_sel.form_data.user_message).length<4){
                        _sel.$toast('留言必须大于四个字符！');
                        return;
                    }
                    if ((_sel.form_data.user_message).length>100){
                        _sel.$toast('留言必须小于100个字符！');
                        return;
                    }
                    this.$indicator.open({
                        text: '图片上传中...',
                        spinnerType: 'fading-circle'
                    });
                    axios.post('{{ route('photo_upload') }}', {
                            form_data: _sel.form_data,
                            photo: _sel.photo,
                    })
                    .then(function (response) {
                        _sel.$indicator.close();
                        var res = response.data;
                        if(res.success){
                            _sel.$toast(res.msg);
                            window.location.href='{{ route('home') }}';
                        }
                        _sel.$toast(res.msg);
                    })
                    .catch(function (error) {
                        _sel.$indicator.close();
                        _sel.$toast('出错！');
                        console.log(error);
                    });

                }
            },
        });
        app.actions = [
            {name:"拍照",method:app.camera},
            {name:"从相册中选择",method:app.photo_click}
        ];

        function min_index(a,b,c){
            var min = 0;
            min = Math.min.apply(null, [a,b,c]);
            if (min==a)return 0;
            if (min==b)return 1;
            if (min==c)return 2;
        }
    </script>
@endsection
