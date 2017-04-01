@extends('layouts.admin',['active'=>'权限管理','highlight'=>'角色权限'])
@section('title', '角色列表-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1>
            权限管理
            <small>角色列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 权限管理</a></li>
            <li class="active">角色列表</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">所有角色</h3>

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
                                <th>标识</th>
                                <th>角色名称</th>
                                <th>角色描述</th>
                                <th>创建日期</th>
                                <th>操作</th>
                            </tr>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->display_name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="" title="" data-toggle="tooltip" data-placement="left" class="depart-list" data-original-title="编辑角色">
                                            <span class="glyphicon glyphicon-edit"></span>
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
                            {!! $roles->links() !!}
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

    </script>
@endsection
