@extends('layouts.admin',['active'=>'生活管理','highlight'=>'二手市场'])
@section('title', '二手市场-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <div class="pull-left btn_group_work">
            <a href="{{ route('admin.secondary_add') }}" class="btn btn-success"  type="button"><i class="fa fa-plus"></i> 添加二手产品</a>
        </div>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">二手</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">二手列表</h3>
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
                                <th>产品名称</th>
                                <th>租赁标题</th>
                                <th>租赁描述</th>
                                <th>标签</th>
                                <th>产品原价</th>
                                <th>产品售价</th>
                                <th>产品数量</th>
                                <th>已售数量</th>
                                <th>状态</th>
                                <th>产品所有者</th>
                                <th>操作</th>
                            </tr>
                            @foreach($secondary as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ mb_substr($info->name,0,30).'...' }}</td>
                                    <td>{{ mb_substr($info->title,0,40).'...' }}</td>
                                    <td>{{ mb_substr($info->description,0,50).'...' }}</td>
                                    <td><span class="label label-success">{{ $info->tag }}</span></td>
                                    <td>{{ $info->original_price }}</td>
                                    <td>{{ $info->sale_price }}</td>
                                    <td>{{ $info->total_qty }}</td>
                                    <td>{{ $info->sale_qty }}</td>
                                    <td>
                                        {!!
                                            $info->status == 'published' ? '<span class="label label-success">已发布</span>' : '<span class="label label-warning">未发布</span>'
                                         !!}
                                    </td>
                                    <td>{{ $info->owner }}</td>
                                    <td>
                                        <a href="{{ route('admin.secondary_add').'/'.$info->id }}" title="" data-toggle="tooltip" data-placement="left" class="depart-list" data-original-title="编辑二手">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a style="color: #f00" href="javascript:;" title="" onclick="secondary_delete({{ $info->id }})" data-toggle="tooltip" data-placement="right" class="depart-list" data-original-title="删除二手">
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
                            {!! $secondary->links() !!}
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
        function secondary_delete(secondary_id) {
            $.get("{{ route('admin.secondary_delete') }}"+"/"+secondary_id, function(data){
                var data = JSON.parse(data);
                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.secondary_list') }}";
                    },500);
                }
            });
        }
    </script>
@endsection