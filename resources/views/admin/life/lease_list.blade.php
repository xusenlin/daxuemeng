@extends('layouts.admin',['active'=>'生活管理','highlight'=>'租赁'])
@section('title', '租赁-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <div class="pull-left btn_group_work">
            <a href="{{ route('admin.leases_add') }}" class="btn btn-success"  type="button"><i class="fa fa-plus"></i> 添加租赁</a>
        </div>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">租赁</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">租赁列表</h3>
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
                                <th>租赁单价</th>
                                <th>产品数量</th>
                                <th>已租数量</th>
                                <th>剩余数量</th>
                                <th>状态</th>
                                <th>产品所有者</th>
                                <th>操作</th>
                            </tr>
                            @foreach($leases as $lease)
                                <tr>
                                    <td>{{ $lease->id }}</td>
                                    <td>{{ $lease->name }}</td>
                                    <td>{{ $lease->title }}</td>
                                    <td>{{ $lease->description }}</td>
                                    <td><span class="label label-success">{{ $lease->tag }}</span></td>
                                    <td>{{ $lease->unit_price }}</td>
                                    <td>{{ $lease->total_qty }}</td>
                                    <td>{{ $lease->sale_qty }}</td>
                                    <td>{{ $lease->left_qty }}</td>
                                    <td>
                                        {!!
                                            $lease->status == 'published' ? '<span class="label label-success">已发布</span>' : '<span class="label label-warning">未发布</span>'
                                         !!}

                                    </td>
                                    <td>{{ $lease->owner }}</td>
                                    <td>
                                        <a href="{{ route('admin.leases_add').'/'.$lease->id }}" title="" data-toggle="tooltip" data-placement="left" class="depart-list" data-original-title="编辑租赁">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a style="color: #f00" href="javascript:;" title="" onclick="lease_delete({{ $lease->id }})" data-toggle="tooltip" data-placement="right" class="depart-list" data-original-title="删除租赁">
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
                            {!! $leases->links() !!}
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
        function lease_delete(lease_id) {
            $.get("{{ route('admin.lease_delete') }}"+"/"+lease_id, function(data){
                var data = JSON.parse(data);
                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.leases_list') }}";
                    },500);
                }
            });
        }
    </script>
@endsection