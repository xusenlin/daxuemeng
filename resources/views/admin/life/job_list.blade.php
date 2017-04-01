@extends('layouts.admin',['active'=>'生活管理','highlight'=>'兼职'])
@section('title', '兼职-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <div class="pull-left btn_group_work">
            <a href="{{ route('admin.part_time_job_add') }}" class="btn btn-success"  type="button"><i class="fa fa-plus"></i> 添加兼职</a>
        </div>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">兼职</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">兼职列表</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th>企业名称</th>
                                <th>职位类别</th>
                                <th>薪资水平</th>
                                <th>招聘人数</th>
                                <th>性别要求</th>
                                <th>操作</th>
                            </tr>
                            @foreach($jobs as $job)
                                <tr>
                                    <td>{{ $job->id }}</td>
                                    <td>{{ $job->name }}</td>
                                    <td>{{ $job->position_type }}</td>
                                    <td>{{ $job->salary }}</td>
                                    <td><span class="label label-success">{{ $job->person_count }}</span></td>
                                    <td>{{ get_sex($job->sex) }}</td>
                                    <td>
                                        <a href="{{ route('admin.part_time_job_add').'/'.$job->id }}" title="" data-toggle="tooltip" data-placement="left" class="depart-list" data-original-title="编辑兼职">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a style="color: #f00" href="javascript:;" title="" onclick="job_delete({{ $job->id }})" data-toggle="tooltip" data-placement="right" class="depart-list" data-original-title="删除兼职">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class=" pull-right">
                            {!! $jobs->links() !!}
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection

@section('js')
    @parent
    <script>
        function job_delete(job_id) {
            $.get("{{ route('admin.part_time_job_delete') }}"+"/"+job_id, function(data){
                var data = JSON.parse(data);
                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.part_time_job') }}";
                    },500);
                }
            });
        }
    </script>
@endsection