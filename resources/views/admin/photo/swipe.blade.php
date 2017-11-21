@extends('layouts.admin',['active'=>'照片管理','highlight'=>'首页轮播图'])
@section('title', '首页轮播图-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <div class="pull-left btn_group_work">

            <button class="btn btn-success" onclick="add_swipe('null')">
                <i class="fa fa-plus"></i>
                添加轮播图
            </button>
        </div>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">添加轮播图</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">轮播图列表</h3>
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

                                <th>图片名称</th>
                                <th>图片Url</th>
                                <th>图片预览</th>
                                <th>操作</th>
                            </tr>
                            @foreach($swipes as $index => $swipe)
                                <tr>

                                    <td>{{ $index }}</td>
                                    <td>{{ $swipe }}</td>
                                    <td><img style="height: 25px;" src="{{ asset($swipe) }}" alt=""></td>
                                    <td>
                                        <a href="javaScript:;" onclick="add_swipe({{ $index }})" data-toggle="tooltip" data-placement="left" class="depart-list" data-original-title="编辑720">
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
                            {{--{!! $jobs->links() !!}--}}
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
        function add_swipe(name) {
            var _action = name ?'编辑720':'添加720';
            var _url = '{{route('admin.swipe_add')}}/'+name;
            $.get(_url, {}, function (data) {
                modal_form(_action, data, function () {
                    var form_data = $('#form_720').serialize();
                    form_data += '&name='+name;
                    var _url = '{{route('admin.swipe_save')}}';
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
    </script>
@endsection