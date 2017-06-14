@extends('layouts.admin',['active'=>'生活管理','highlight'=>'720云'])
@section('title', '720云-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <div class="pull-left btn_group_work">

            <button class="btn btn-success" onclick="add_720(0)">
                <i class="fa fa-plus"></i>
                添加720云
            </button>
        </div>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">720云</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">720列表</h3>
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
                                <th>720云名称</th>
                                <th>720云Url</th>
                                <th>720云备注</th>
                                <th>720云封面 </th>
                                <th>操作</th>
                            </tr>
                            @foreach($panoramas as $panorama)
                                <tr>
                                    <td>{{ $panorama->id }}</td>
                                    <td>{{ $panorama->name }}</td>
                                    <td>{{ $panorama->url }}</td>
                                    <td>{{ $panorama->remarks }}</td>
                                    <td><img style="height: 25px;" src="{{ asset($panorama->cover) }}" alt=""></td>
                                    <td>
                                        <a href="javaScript:;" onclick="add_720({{ $panorama->id }})" data-toggle="tooltip" data-placement="left" class="depart-list" data-original-title="编辑720">
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
        function add_720(id) {
            var _action = id?'编辑720':'添加720';
            var _url = '{{route('admin.720_add')}}/'+id;
            $.get(_url, {}, function (data) {
                modal_form(_action, data, function () {
                    var form_data = $('#form_panorama').serialize();
                    form_data += '&id='+id;
                    var _url = '{{route('admin.720_save')}}';
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