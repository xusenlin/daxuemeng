@extends('layouts.admin',['active'=>'生活管理'])
@section('title', $job['title'].'-'.Config::get('site.site_title'))
@section('style')
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datetimepicker/datetimepicker.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <h1>
            生活管理
            <small>{{ $job['title'] }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">{{ $job['title'] }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $job['title'] }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="job_form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>企业名称</label>
                                        <input type="text" name="name" class="form-control" value="{{ @$job['data']->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>职位类别</label>
                                        <input type="text" name="position_type" class="form-control" value="{{ @$job['data']->position_type }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>薪资水平</label>
                                        <input type="text" name="salary" class="form-control" value="{{ @$job['data']->salary }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>招聘人数</label>
                                        <input type="text" name="person_count" class="form-control" value="{{ @$job['data']->person_count }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>职位描述</label>
                                <textarea class="form-control" name="position_desc" rows="3" placeholder="Enter ...">{{ @$job['data']->position_desc }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>工作地点</label>
                                        <input type="text" name="work_place" class="form-control" value="{{ @$job['data']->work_place }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>工作时间</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" name="work_time" class="form-control date-picker" value="{{ @$job['data']->work_time }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">性别要求</label>
                                        <div class="radio">
                                            <label>
                                                <input  type="radio" name="sex" value="all" {{ @$job['data']->sex=='all' ? 'checked="checked"' : '' }}>
                                                不限,
                                            </label>
                                            <label>
                                                <input  type="radio" name="sex" value="male" {{ @$job['data']->sex=='male' ? 'checked="checked"' : '' }}>
                                                男,
                                            </label>
                                            <label>
                                                <input  type="radio" name="sex" value="female" {{ @$job['data']->sex=='female' ? 'checked="checked"' : '' }}>
                                                女,
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>联系人</label>
                                        <input type="text" name="contact" class="form-control" value="{{ @$job['data']->contact }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>联系电话</label>
                                        <input type="text" name="contact_phone" class="form-control" value="{{ @$job['data']->contact_phone }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>QQ</label>
                                        <input type="text" name="qq" class="form-control" value="{{ @$job['data']->qq }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>邮箱</label>
                                        <input type="email" name="email" class="form-control" value="{{ @$job['data']->email }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>备注</label>
                                <textarea class="form-control" name="comment" rows="3" placeholder="Enter ...">{{ @$job['data']->comment }}</textarea>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked="checked"  disabled> 同意本站协议。
                                </label>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <input type="hidden" name="job_id" value="{{ @$job['job_id'] }}">
                        <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                        <div class="box-footer">
                            <button type="button" class="btn btn-primary" onclick="save()">确认</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="{{ asset('AdminLTE/plugins/datetimepicker/datetimepicker.js') }}"></script>
    <script>
        $(function(){
            jQuery(".date-picker").datetimepicker({
                lang:'ch',
                timepicker:false,
                format:"Y-m-d",
                formatDate:"Y-m-d"
            });
        });

        function save() {
            $.post("{{ route('admin.part_time_job_save') }}", $("#job_form").serialize(), function(data){

                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.part_time_job') }}";
                    },500);
                }
            },'json');
        }
    </script>
@endsection