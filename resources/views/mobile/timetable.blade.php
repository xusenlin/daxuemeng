@extends('layouts.mobile')
@section('title', '课程表')
@section('style')
    <style>

        .mint-navbar .mint-tab-item.is-selected{
            border-bottom: 0;
        }
        body{
            margin: 0;
        }
    </style>
@endsection
@section('content')
    <div id="app">
        <div style="height: 49px"></div>
        <div class="mint-header is-fixed timetable-top" style="padding: 0">
            <div class="week">星期一</div>
            <div class="week">星期二</div>
            <div class="week">星期三</div>
            <div class="week">星期四</div>
            <div class="week">星期五</div>
            <div class="week">星期六</div>
            <div class="week">星期日</div>
        </div>
        <div class="timetable-content ">
            @for($i=1;$i<=7;$i++)
                <div class="column">
                    @if(isset($data[$i]))
                        @foreach($data[$i] as $index => $timetable )
                            <div @click="course_details({{ $i }},{{ $index }})" class="course" style="background-color: #{{ $color[rand(0,14)] }}">{{ $timetable->name }}</div>
                        @endforeach
                    @endif
                </div>
            @endfor
        </div>
        <mt-popup
                v-model="popupCoursesVisible"
                position="bottom" style="width: 100%;height: 460px;overflow: auto;text-align: center;">

            <ul class="my-list-ul">
                <li style="font-size: 12px;box-shadow: 0 0 8px rgba(0,0,0,.3);">@{{ details.name }}</li>
                <li style="text-indent: 20px;text-align: left;">年级：@{{ details.grade }}</li>
                <li style="text-indent: 20px;text-align: left;">班级：@{{ details.class  }}</li>
                <li style="text-indent: 20px;text-align: left;">上课老师：@{{ details.teacher }}</li>
                <li style="text-indent: 20px;text-align: left;">上课地点：@{{  details.place  }}</li>
                <li style="text-indent: 20px;text-align: left;">单双周：@{{ type(details.type) }}</li>
                <li style="text-indent: 20px;text-align: left;">
                    上课时间：星期@{{ week(details.weekday)+'   ['+details.start_time+'~'+details.end_time+']' }}
                </li>
                <li style="text-indent: 20px;text-align: left;">总共课时： @{{ details.lessons }}</li>
                <li style="text-indent: 20px;line-height: 21px;height: 75px;text-align: left;">备注：
                    <br>
                    <div style="width: 100%;overflow: hidden;font-size: 12px;text-indent: 40px;">@{{ details.comment }}</div>
                </li>
            </ul>

        </mt-popup>
    </div>
@endsection
@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                popupCoursesVisible:false,
                details:{},
                course:{!! json_encode($data) !!}
            },
            methods: {
                course_details:function (week,index) {

                    this.details = this.course[week][index];
                    this.popupCoursesVisible = true;
                },
                type:function (type) {
                    if (type == 'every')
                        return '不限';
                    if (type == 'odd')
                        return '单周';
                    if (type == 'even')
                        return '双周';
                },
                week:function (i) {
                    switch (i){
                        case 1 :
                            return '一';
                        case 2 :
                            return '二';
                        case 3 :
                            return '三';
                        case 4 :
                            return '四';
                        case 5 :
                            return '五';
                        case 6 :
                            return '六';
                        case 7 :
                            return '日';
                    }
                }
            }
        });
    </script>
@endsection
