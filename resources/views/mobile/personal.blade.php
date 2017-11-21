@extends('layouts.mobile')
@section('title', '个人信息')
@section('content')
    <div id="app" v-cloak>
            <div class="mine-heard">

                <div class="user-avatar">
                    <i @click="edit_avatar()" class="iconfont icon-fabiao" style="position: absolute; right: 13px; top: 3px;"></i>
                    <img :src=" user.avatar ? user.avatar : 'Backend/image/user.jpg'" alt="">
                </div>
                <h2 class="user-name">@{{ user.nickname }}</h2>
                <h3 class="user-name" style="font-size: 12px;color: #c8deea">@{{ user.signature }}</h3>
            </div>
            <ul class="mine-list personal">
                <li class="mint-cell">
                    姓名:@{{ user.name }}
                    <i @click="edit_info('name')" class="iconfont icon-edit2"></i>
                </li>
                <li class="mint-cell">
                    昵称:@{{ user.nickname }}
                    <i @click="edit_info('nickname')" class="iconfont icon-edit2" ></i>
                </li>
                <li class="mint-cell">
                    手机:@{{ user.cellphone }}
                    <i @click="edit_info('cellphone')" class="iconfont icon-edit2" ></i>
                </li>
                <li class="mint-cell">
                    邮箱:@{{ user.email }}
                    <i @click="edit_info('email')" class="iconfont icon-edit2"></i>
                </li>
                <li class="mint-cell">
                    QQ:@{{ user.qq }}
                    <i @click="edit_info('qq')" class="iconfont icon-edit2" ></i>
                </li>
                <li class="mint-cell">
                    性别:@{{ sex_value }}
                    <i @click="display_sex_change()" class="iconfont icon-edit2" ></i>

                </li>
                <li class="mint-cell" style="line-height: 24px">
                    个性签名: <div style="font-size: 12px;text-indent: 2em">@{{ user.signature }}</div>
                    <i @click="edit_info('signature')" style="top:0" class="iconfont icon-edit2"></i>
                </li>
                <li class="mint-cell" >
                    学校: @{{ school_info[0].school }}
                    <i @click="student_info()" class="iconfont icon-edit2"></i>
                </li>
                <li class="mint-cell" >
                    系: @{{ school_info[1].department }}
                </li>
                <li class="mint-cell" >
                    专业: @{{ school_info[2].major }}
                </li>
                <li class="mint-cell" >
                    年级: @{{ grade }}
                    <i @click="edit_info('student_grade')" class="iconfont icon-edit2"></i>
                </li>
                <li class="mint-cell" >
                    班级:  @{{ s_class }}
                    <i @click="edit_info('student_class')" class="iconfont icon-edit2"></i>
                </li>

                <input style="display: none" type="file"  accept="image/*" multiple="" id="img" @change="avatar_change()"  >
            </ul>
        <br>
        <mt-actionsheet
                :actions="sex_select"
                v-model="sheetVisible">
        </mt-actionsheet>
        <mt-popup
                v-model="popupSchoolVisible"
                position="bottom" style="width: 100%;height: 360px;overflow: auto;text-align: center;">
                <ul style="    list-style-type: none;padding: 0;margin: 0;">
                    <li style="height: 48px;line-height: 48px;border-bottom: 1px solid #eee;">---选择学校---</li>
                @foreach($data['tree'] as $id => $school)
                    <li @click = "student_change({{ $id }})" style="height: 48px;line-height: 48px;border-bottom: 1px solid #eee;">{{ $school['name'] }}</li>
                @endforeach
                </ul>
        </mt-popup>
        <mt-popup
                v-model="popupDepartmentVisible"
                position="bottom" style="width: 100%;height: 360px;overflow: auto;text-align: center;">
                <ul style="    list-style-type: none;padding: 0;margin: 0;">
                    <li style="height: 48px;line-height: 48px;border-bottom: 1px solid #eee;">---选择系---</li>
                    <li @click = "department_change(key,department.name)" v-for="(department, key) in temporarilyVal.department" style="height: 48px;line-height: 48px;border-bottom: 1px solid #eee;">@{{ department.name }}</li>
                </ul>

        </mt-popup>
        <mt-popup
                v-model="popupMajorsVisible"
                position="bottom" style="width: 100%;height: 360px;overflow: auto;text-align: center;">

                <ul style="    list-style-type: none;padding: 0;margin: 0;">
                    <li style="height: 48px;line-height: 48px;border-bottom: 1px solid #eee;">---选择专业---</li>
                    <li @click = "major_change(key,major.name)" v-for="(major, key) in temporarilyVal.major" style="height: 48px;line-height: 48px;border-bottom: 1px solid #eee;">@{{ major.name }}</li>

                    {{--<li @click = "student_change()" style="height: 48px;line-height: 48px;border-bottom: 1px solid #eee;"></li>--}}
                </ul>

        </mt-popup>
        @include('public.mobile.nav')
    </div>
@endsection
@section('js')
    <script src="{{ asset('Mobile/js/lrz.all.bundle.js') }}" type="application/javascript"></script>
    <script>
console.log({!! json_encode($data ?: []) !!});
        var app = new Vue({
            el: '#app',
            data:{
                popupSchoolVisible:false,
                popupDepartmentVisible:false,
                popupMajorsVisible:false,
                sheetVisible:false,
                sex_select:[],
                sex_value:'',
                user:{!! json_encode(Auth::user()) !!},
                user_other:{!! json_encode($data ?: []) !!},
                school_info:[
                    {school:'未选择',school_id:''},
                    {department:'未选择',department_id:''},
                    {major:'未选择',major_id:''},
                ],
                grade:'',
                s_class:'',

                temporarilyVal:{
                    school:'',
                    school_id:0,
                    department_name:'',
                    department_id:'',
                    major_name:'',
                    major_id:'',
                    department:{},
                    major:{}
                },


            },
            methods: {
                edit_info: function(column) {
                    var _sel = this;
                    _sel.$messagebox.prompt('请输入你的信息！',inputValue='').then(function (value) {
                        var inputVal = value.value;
                        if (inputVal==null || inputVal.length<2){
                            _sel.$toast('输入的字符小于2个字符');
                            return;
                        }

                        axios.get('{{ route('user_edit') }}', {
                            params: {
                                column: column,
                                columnVal:inputVal,
                            }
                        })
                        .then(function (response) {
                            var res = response.data;
                            if (res.success){
                                _sel.$toast(res.msg);
                                if (column == 'student_grade' ){
                                    _sel.grade = inputVal;
                                    return;
                                }
                                if (column == 'student_class' ){
                                    _sel.s_class = inputVal;
                                    return;
                                }
                                _sel.user[column] = inputVal;
                                return;
                            }
                            _sel.$toast(res.msg);

                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                        }, function (action ) {

                        });
                },
                display_sex_change:function () {
                    this.sheetVisible = true;
                },
                sex_change:function (str) {
                    var _sel =this;
                    axios.get('{{ route('user_edit') }}', {
                        params: {
                            column: 'sex',
                            columnVal:str,
                        }
                    })
                    .then(function (response) {

                        var res = response.data;
                        if (res.success){
                            _sel.$toast(res.msg);
                            _sel.sex_value = get_sex(str);
                            return;
                        }
                        _sel.$toast(res.msg);

                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                },
                edit_avatar:function () {
                    document.getElementById('img').click();
                },
                avatar_change:function () {
                    var _sel = this;
                    this.$indicator.open({
                        text: '图片压缩中...',
                        spinnerType: 'fading-circle'
                    });
                    lrz(document.getElementById('img').files[0])
                    .then(function (rst) {
                        _sel.user.avatar = rst.base64;
                        axios.post('{{ route('user_edit') }}', {
                            column: 'avatar',
                            columnVal:rst.base64
                        })
                        .then(function (response) {

                            var res = response.data;
                            if (res.success){
                                _sel.$toast(res.msg);

                                return;
                            }
                            _sel.$toast(res.msg);

                        })
                        .catch(function (error) {
                            console.log(error);
                        });

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
                student_change:function (school_id) {
                    var _sel = this;
                    //点击学校之后把值保存在临时值里面，后面一起保存
                    _sel.temporarilyVal.school = _sel.user_other.tree[school_id].name;
                    _sel.temporarilyVal.school_id = school_id;
                    _sel.popupSchoolVisible = false;

                    _sel.temporarilyVal.department = _sel.user_other.tree[school_id].department;
                    _sel.popupDepartmentVisible = true;



                    //this.popupDepartmentVisible = false;
                    this.popupMajorsVisible = false;


                },
                student_info:function () {
                        this.popupSchoolVisible = true;
                },
                department_change:function (department_id,department_name) {
                    var _sel = this;
                    //点击系之后把值保存在临时值里面，后面一起保存
                    _sel.temporarilyVal.department_name = department_name;
                    _sel.temporarilyVal.department_id = department_id;
                    _sel.popupDepartmentVisible = false;

                    _sel.temporarilyVal.major = _sel.temporarilyVal.department[department_id].majors;
                    _sel.popupMajorsVisible = true;
                },
                major_change:function (major_id,major_name) {
                    var _sel = this;
                    //点击系之后把值保存在临时值里面，后面一起保存
                    _sel.temporarilyVal.major_name = major_name;
                    _sel.temporarilyVal.major_id = major_id;
                    _sel.popupMajorsVisible = false;

                    axios.get('{{ route('user_edit') }}', {
                        params: {
                            column: 'change_school',
                            columnVal:[
                                _sel.temporarilyVal.school_id,
                                _sel.temporarilyVal.department_id,
                                _sel.temporarilyVal.major_id,
                            ],
                        }
                    })
                    .then(function (response) {
                        var res = response.data;

                        if (res.success){
                            _sel.school_info[0].school = _sel.temporarilyVal.school;
                            _sel.school_info[1].department = _sel.temporarilyVal.department_name;
                            _sel.school_info[2].major = _sel.temporarilyVal.major_name;
                        }
                        _sel.$toast(res.msg);
                    })
                    .catch(function (error) {
                        window.location.href=window.location.href;
                    });

                    _sel.school_info[0].school = _sel.temporarilyVal.school;
                    _sel.school_info[1].department = _sel.temporarilyVal.department_name;
                    _sel.school_info[2].major = _sel.temporarilyVal.major_name;

                },

            }
        });


        app.sex_value = get_sex(app.user.sex);
        if(app.user_other.student){
            var school_id =  app.user_other.student.school_id;
            var department_id = app.user_other.student.department_id;
            var major_id = app.user_other.student.major_id;
            if(app.user_other.tree.hasOwnProperty(school_id) && school_id){
                app.school_info[0] = {school:app.user_other.tree[school_id].name,school_id:school_id};
                if(app.user_other.tree[school_id].hasOwnProperty('department') && department_id){
                    app.school_info[1] = {department:app.user_other.tree[school_id].department[department_id].name,department_id:department_id};
                    if(app.user_other.tree[school_id].department[department_id].hasOwnProperty('majors') && major_id)
                    app.school_info[2] = {major:app.user_other.tree[school_id].department[department_id].majors[major_id].name,majors_id:major_id};
                }
            }
        }

        app.grade = app.user_other.student.grade;
        app.s_class = app.user_other.student.class;
        app.sex_select =[
            {name:'男',method:function () {app.sex_change(1)}},
            {name:'女',method:function () {app.sex_change(2)}},
            {name:'保密',method:function () {app.sex_change(3)}}
        ];
        function get_sex(i) {
            if (i==1)
                return '男';
            if (i==2)
                return '女';

            return '保密';
        }
    </script>
@endsection
