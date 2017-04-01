@extends('layouts.admin',['active'=>'用户管理','highlight'=>'注册用户'])
@section('title', '用户列表-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1>
            用户管理
            <small>用户列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 用户管理</a></li>
            <li class="active">用户列表</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">注册用户</h3>

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
                                <th>姓名</th>
                                <th>昵称</th>
                                <th>邮箱</th>
                                <th>身份</th>
                                <th>签名</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->nickname }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="label label-success">{{ $user->type }}</span></td>
                                    <td>{{ $user->signature }}</td>
                                    <td>
                                        {!! $user->active ? '<span class="label label-success">正常登陆</span>' : '<span class="label label-danger">已禁用</span>' !!}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="" title="" data-toggle="tooltip" data-placement="left" class="depart-list" data-original-title="编辑用户">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        @if($user->active)
                                            <a style="color: #f00" href="javascript:;" title="" onclick="user_disabled({{ $user->id }})" data-toggle="tooltip" data-placement="right" class="depart-list" data-original-title="禁用用户">
                                                <span class="glyphicon glyphicon-ban-circle"></span>
                                            </a>
                                        @else
                                            <a style="color: #00a65a" href="javascript:;" title="" onclick="user_disabled({{ $user->id }})" data-toggle="tooltip" data-placement="right" class="depart-list" data-original-title="启用用户">
                                                <span class="glyphicon glyphicon-ok-circle"></span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <div class=" pull-right">
                            {!! $users->links() !!}
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
        function user_disabled(user_id) {
            $.get("{{ route('admin.users_disabled') }}"+"/"+user_id, function(data){
                var data = JSON.parse(data);
                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.users') }}";
                    },500);
                }
            });
        }
    </script>
@endsection
