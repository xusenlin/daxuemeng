@extends('layouts.admin',['active'=>'基础数据','highlight'=>'专业管理'])
@section('title', '专业管理-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1 class="pull-left header-h1">专业管理</h1>
        <div class="look-group">
            &nbsp;&nbsp;<button class="btn btn-success" onclick="major_add(0)">
                <i class="fa fa-plus"></i>
                添加专业
            </button>
        </div>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 基础数据</a></li>
            <li class="active">专业列表</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>专业名称</th>
                                <th>院系名称</th>
                                <th>所属学校</th>
                                <th>操作</th>
                            </tr>
                            @foreach($majors as $major)
                                <tr>
                                    <td>{{ $major->name }}</td>
                                    <td>{{ $major->department_name }}</td>
                                    <td>{{ $major->school_name }}</td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="major_add({{$major->id}})" title="" class="depart-list">
                                            编辑
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
                            {!! $majors->links() !!}
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
        function major_add(id) {
            var _action = id?'编辑专业':'添加专业';
            var _url = '{{route('admin.major_add')}}/'+id;
            $.get(_url, {}, function (data) {
                modal_form(_action, data, function () {
                    var form_data = $('#form_major').serialize();
                    form_data += '&id='+id;
                    var _url = '{{route('admin.major_save')}}';
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
