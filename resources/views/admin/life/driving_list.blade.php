@extends('layouts.admin',['active'=>'生活管理','highlight'=>'驾校'])
@section('title', '驾校信息-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <div class="pull-left btn_group_work">
            <a href="{{ route('admin.driving_add') }}" class="btn btn-success"  type="button"><i class="fa fa-plus"></i> 添加信息</a>
        </div>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">驾校信息</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">信息列表</h3>
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
                                <th>标题</th>
                                <th>摘要</th>
                                <th>状态</th>
                                <th>发布时间</th>
                                <th>浏览量</th>
                                <th>操作</th>
                            </tr>
                            @foreach($driving as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ mb_substr($info->title,0,40).'...' }}</td>
                                    <td>{{ mb_substr($info->excerpt,0,70).'...' }}</td>
                                    <td>
                                        {!!  $info->status == 'draft' ? '<span class="label label-warning">草稿</span>' : '<span class="label label-success">已发布</span>' !!}
                                    </td>
                                    <td>{{ $info->published_time }}</td>
                                    <td>{{ $info->view_count }}</td>
                                    <td>
                                        <a href="{{ route('admin.driving_add').'/'.$info->id }}" title="" data-toggle="tooltip" data-placement="left" class="depart-list" data-original-title="编辑信息">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a style="color: #f00" href="javascript:;" title="" onclick="driving_delete({{ $info->id }})" data-toggle="tooltip" data-placement="right" class="depart-list" data-original-title="放入回收站">
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
                            {!! $driving->links() !!}
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
        function driving_delete(driving_id) {
            $.get("{{ route('admin.driving_delete') }}"+"/"+driving_id, function(data){
                var data = JSON.parse(data);
                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.driving_list') }}";
                    },500);
                }
            });
        }
    </script>
@endsection