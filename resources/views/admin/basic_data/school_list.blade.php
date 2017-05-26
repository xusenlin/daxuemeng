@extends('layouts.admin',['active'=>'基础数据','highlight'=>'学校管理'])
@section('title', '学校管理-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1 class="pull-left header-h1">学校管理</h1>
        <div class="look-group">
            &nbsp;&nbsp;<button class="btn btn-success" onclick="school_add(0)">
                <i class="fa fa-plus"></i>
                添加学校
            </button>
        </div>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 基础数据</a></li>
            <li class="active">学校列表</li>
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
                                <th>学校名称</th>
                                <th>学校地址</th>
                                <th>操作</th>
                            </tr>
                            @foreach($schools as $school)
                                <tr>
                                    <td>{{ $school->name }}</td>
                                    <td>{{ $school->address }}</td>
                                    <td>
                                        <a href="javascript:void(0)" onclick="school_add({{$school->id}})" title="" class="depart-list">
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
                            {!! $schools->links() !!}
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
        function school_add(id) {
            var _action = id?'编辑学校':'添加学校';
            var _url = '{{route('admin.school_add')}}/'+id;
            $.get(_url, {}, function (data) {
                modal_form(_action, data, function () {
                    var form_data = $('#form_school').serialize();
                    form_data += '&id='+id;
                    var _url = '{{route('admin.school_save')}}';
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
