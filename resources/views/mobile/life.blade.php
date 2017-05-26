@extends('layouts.mobile')
@section('title', '生活')
@section('style')
    <style>
        .iconfont{
            font-size: 28px;
            margin-bottom: 6px;
            display: inline-block;
        }
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
        <div style="height: 68px"></div>
        <div style="background: #efefef;height: 20px" ></div>
        <mt-navbar v-model="selected" class="mint-header is-fixed" style="height: unset">
            <mt-tab-item id="5">
                <i class="iconfont icon-kecheng" style="color: #f39e34"></i><br>
                课程表
            </mt-tab-item>
            <mt-tab-item id="1">
                <i class="iconfont icon-shichang"  style="color: #eb6365"></i><br>
                二手市场
            </mt-tab-item>
            <mt-tab-item id="2">
                <i class="iconfont icon-dairuzhi"  style="color: #8b90f8"></i><br>
                兼职
            </mt-tab-item>
            <mt-tab-item id="3">
                <i class="iconfont icon-dingshichang"  style="color: #fbd033"></i><br>
                租赁
            </mt-tab-item>
            <mt-tab-item id="4">
                <i class="iconfont icon-shijiaqingqiu"  style="color: #f39e34"></i><br>
                驾校
            </mt-tab-item>

        </mt-navbar>

        <!-- tab-container -->
        <mt-tab-container v-model="selected">
            <mt-tab-container-item id="1">
                <ul class="list-ul">
                    @foreach(@$data['market'] as $item)
                        <li class="list-li">
                            <a href="{{ route('details_market',$item->id) }}" class="item-content">
                                <div class="item-media">
                                    <img class="item-img" src="{{ asset($item->cover) }}">
                                </div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">{{ $item->title }}</div>
                                    </div>
                                    <div class="item-text" style="color: #56cbb8">￥{{ $item->original_price  }}</div>
                                    <div class="item-text-r" >已售{{ $item->sale_qty  }}</div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </mt-tab-container-item>
            <mt-tab-container-item id="2">
                @foreach(@$data['jobs'] as $item)
                    <a class="mint-cell" href="{{ route('details_job',$item->id) }}">
                        <span class="mint-cell-mask"></span>
                        <div class="mint-cell-left"></div>
                        <div class="mint-cell-wrapper">
                            <div class="mint-cell-title">
                                <span class="mint-cell-text">{{ $item->name }}</span>
                                <span class="mint-cell-label">{{ $item->position_desc }}</span>
                                <div class="mint-cell-label">薪资水平：<span style="color: #ea1717">￥{{ $item->salary }}</span></div>
                            </div>
                        </div>
                        <div class="mint-cell-right"></div> <i class="mint-cell-allow-right"></i>
                    </a>
                @endforeach
            </mt-tab-container-item>
            <mt-tab-container-item id="3">
                <ul class="list-ul">
                    @foreach(@$data['lease'] as $item)
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
                </ul>
            </mt-tab-container-item>
            <mt-tab-container-item id="4">
                <ul class="list-ul">
                    @foreach(@$data['driving'] as $item)
                        <li class="list-li">
                            <a href="{{ route('details',$item->id) }}" class="item-content">
                                <div class="item-media">
                                    <img class="item-img" src="{{ asset($item->cover) }}">
                                </div>
                                <div class="item-inner">
                                    <div class="item-title-row">
                                        <div class="item-title">{{ $item->title }}</div>
                                    </div>
                                    <div class="item-text">{{  substr($item->created_at,0,10)  }}</div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <br><br>
            </mt-tab-container-item>
            <mt-tab-container-item id="5">

                <ul class="my-list-ul">
                    @foreach($data['tree'] as $id => $school)
                        <li style="text-indent: 20px" @click = "student_change({{ $id }})">{{ $school['name'] }}</li>
                    @endforeach
                </ul>
                <br><br>
            </mt-tab-container-item>
        </mt-tab-container>

        <mt-popup
                v-model="popupDepartmentVisible"
                position="bottom" style="width: 100%;height: 360px;overflow: auto;text-align: center;">
            <ul class="my-list-ul">
                <li>--请选择系--</li>
                <li @click = "department_change(key)" v-for="(department, key) in temporarilyVal.department" >@{{ department.name }}</li>
            </ul>

        </mt-popup>
        <mt-popup
                v-model="popupMajorsVisible"
                position="bottom" style="width: 100%;height: 360px;overflow: auto;text-align: center;">

            <ul class="my-list-ul">
                <li>--请选专业--</li>
                <li @click = "major_change(key)" v-for="(major, key) in temporarilyVal.major" >@{{ major.name }}</li>
            </ul>

        </mt-popup>

        @include('public.mobile.nav',['active'=>'生活'])
    </div>
@endsection
@section('js')
    <script>
        var app = new Vue({
            el: '#app',
            data:{
                selected:'5',
                popupDepartmentVisible:false,
                popupMajorsVisible:false,
                temporarilyVal:{
                    id:'',
                    department:'',
                    major:'',
                },
                tree:{!! json_encode($data['tree'] ?: [])  !!},
            },
            methods: {
                student_change: function(school_id) {
                    this.temporarilyVal.department = this.tree[school_id].department;
                    this.temporarilyVal.id = school_id;
                    this.popupDepartmentVisible = true;

                },
                department_change:function (department_id) {
                    this.popupDepartmentVisible = false;
                    this.temporarilyVal.major = this.tree[this.temporarilyVal.id].department[department_id].majors;
                    this.temporarilyVal.id = department_id;
                    this.popupMajorsVisible = true;
                },
                major_change:function (major_id) {
                    window.location.href="{{ route('courses_list') }}/"+major_id;
                },
            }
        });
    </script>
@endsection
