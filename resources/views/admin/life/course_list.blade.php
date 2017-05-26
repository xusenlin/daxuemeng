@extends('layouts.admin',['active'=>'生活管理','highlight'=>'课程表'])
@section('title', '课程表-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1 class="pull-left header-h1">课程表</h1>
        <div class="look-group">
            &nbsp;&nbsp;<button class="btn btn-success" onclick="course_add(0)">
                <i class="fa fa-plus"></i>
                添加课程表
            </button>
            <button class="btn btn-danger" onclick="course_del_all()">
                <i class="fa fa-remove"></i>
                清除所有课程表
            </button>
        </div>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">课程表</li>
        </ol>
    </section>
    <section class="content">
        <form action="" method="get">
            <table cellspacing="10px" cellpadding="5px" style="text-align: left">
                <tr style="text-align: left">
                    <?php
                        $request = \Illuminate\Support\Facades\Request::instance();
                        $depart_options = [];
                        if($request->s_school) {
                            $departments = \App\Model\Department::getSchoolDeparts($request->s_school);
                            foreach ($departments as $department) {
                                $depart_options[$department->id] = $department->name;
                            }
                        }
                        $major_options = [];
                        if( $request->s_department) {
                            $majors = \App\Model\Major::getDepartmentMajors($request->s_department);
                            foreach ($majors as $major) {
                                $major_options[$major->id] = $major->name;
                            }
                        }
                    ?>
                    <td width="3%">学校：</td><td width="8%" style="text-align: left">@include("public.admin.widgets.school", array('select_name'=>'s_school','default'=>$request->s_school,'callback'=>'selected_school_back2'))</td>
                    <td>
                        &nbsp;&nbsp;院系：{{ Form::select('s_department', $depart_options, $request->s_department, array('class'=>'','id'=>'s_department', 'onchange'=>'selected_department_back2(this.value)')) }}
                        &nbsp;&nbsp;专业：{{ Form::select('s_major', $major_options, $request->s_major, array('class'=>'','id'=>'s_major')) }}
                        &nbsp;&nbsp;课程名称：{{ Form::text('s_name', $request->s_name, array('class'=>'')) }}
                        &nbsp;<button name="search">查询</button>
                    </td>
                </tr>
            </table>
        </form>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>课程名称</th>
                                <th>上课年级</th>
                                <th>上课班级</th>
                                <th>上课时间</th>
                                <th>上课老师</th>
                                <th>上课地点</th>
                                <th>所属学校</th>
                                <th>所属院系</th>
                                <th>所属专业</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ $course->course_name }}</td>
                                    <td>{{ $course->grade }}</td>
                                    <td>{{ $course->class }}</td>
                                    <td nowrap>
                                        {{ \App\Model\Timetable::getCourseTypeDesc($course->type) }}<br>
                                        {{ \App\Model\Timetable::getWeekdayDesc($course->weekday) }}<br>
                                        {{ date('H:i', strtotime($course->start_time)) }}-{{ date('H:i', strtotime($course->end_time)) }}
                                    </td>
                                    <td>{{ $course->teacher }}</td>
                                    <td>{{ $course->place }}</td>
                                    <td>{{ $course->school_name }}</td>
                                    <td>{{ $course->department_name }}</td>
                                    <td>{{ $course->major_name }}</td>
                                    <td>{{ $course->timetable_comment?nl2br($course->timetable_comment):"" }}</td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="course_add({{$course->id}})" title="" class="depart-list">
                                            编辑
                                        </a>&nbsp;&nbsp;
                                        <a href="javascript:void(0)" onclick="course_del({{$course->id}})" title="" class="depart-list">
                                            删除
                                        </a>&nbsp;
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class=" pull-right">
                            {!! $courses->links() !!}
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection

    <script>
        function course_add(id) {
            var _action = id?'编辑课程表':'添加课程表';
            var _url = '{{route('admin.course_add')}}/'+id;
            $.get(_url, {}, function (data) {
                modal_form(_action, data, function () {
                    var form_data = $('#form_course').serialize();
                    form_data += '&id='+id;
                    var _url = '{{route('admin.course_save')}}';
                    $.post(_url, form_data, function (data) {
                        if (data.success) {
                            modal_show('提示','modal-success', '操作成功');
                            window.location.reload();
                        } else {
                            modal_show('提示','modal-danger', data.msg?data.msg:'操作失败');
                        }
                    }, 'json');
                });
            }, 'html');
        }

        function course_del(id) {
            modal_show('提示','modal-warning','确认删除此课程安排吗？',function () {
                $.post('{{ route('admin.course_del') }}',{id:id,_token:'{{ csrf_token()}}'},function (data) {
                    if(data.success){
                        modal_success("删除成功");
                    }else {
                        modal_show('错误','modal-danger',"删除失败");
                    }
                }, 'json');
            });
        }

        function course_del_all() {
            modal_show('提示','modal-warning','确认清除所有课程表吗，清除后将不可恢复？',function () {
                $.post('{{ route('admin.course_del') }}',{id:'all',_token:'{{ csrf_token() }}'},function (data) {
                    if(data.success){
                        modal_success("清除成功");
                    }else {
                        modal_show('错误','modal-danger',"清除失败");
                    }
                }, 'json');
            });
        }

        function selected_school_back2(school_id) {
            if(!school_id){
                $('#s_department').html('<option value="">请选择</option>');
                return ;
            }
            var _url = '{{ route('school_department') }}/'+school_id;
            $.get(_url, {}, function (data) {
                if(!data.success)return;
                var _options = '<option value="">请选择</option>';
                for(var i in data.data) {
                    var department = data.data[i];
                    _options += '<option value="'+department.id+'">'+department.name+'</option>';
                }
                $('#s_department').html(_options);
                selected_department_back($('#s_department').val());
            }, 'json');
        }

        function selected_department_back2(department_id) {
            if(!department_id){
                $('#s_major').html('<option value="">请选择</option>');
                return ;
            }
            var _url = '{{ route('department_major') }}/'+department_id;
            $.get(_url, {}, function (data) {console.log(data);
                if(!data.success)return;
                var _options = '<option value="">请选择</option>';
                for(var i in data.data) {
                    var major = data.data[i];
                    _options += '<option value="'+major.id+'">'+major.name+'</option>';
                }
                $('#s_major').html(_options);
            }, 'json');
        }
    </script>

