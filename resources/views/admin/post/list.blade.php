@extends('layouts.admin',$activeInfo)
@section('title', '文章列表-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <div class="pull-left btn_group_work">
            <a href="{{ route('admin.post_edit') }}" class="btn btn-success"  type="button"><i class="fa fa-plus"></i> 添加文章</a>
        </div>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> {{ $activeInfo['active'] }}</a></li>
            <li class="active">{{ $activeInfo['highlight'] }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">文章列表</h3>
                        <div class="box-tools">
                            选择分类
                            <select style="display: inline-block;width: 150px" name="category_id" class="form-control" onchange="selectCategory(this.value)">
                                <option value="">未选择分类</option>
                                @foreach($categorys as $category)
                                    @if($category->id == $id)
                                        <option selected value="{{ $category->id }}">{{ $category->name }}    ----{{ $category->description }}</option>
                                    @else
                                        <option value="{{ $category->id }}">{{ $category->name }}    ----{{ $category->description }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <th width="400px">标题</th>
                                <th>摘要</th>
                                <th width="180px" style="text-align: center">分类</th>
                                <th>状态</th>
                                <th>发布时间</th>
                                <th>浏览量</th>
                                <th>操作</th>
                            </tr>
                            @foreach($posts as $info)
                                <tr>
                                    <td style="{{ $info->is_top==0?'':'color: red' }}">{{ $info->id }}</td>
                                    <td>{{ mb_substr($info->title,0,40).'...' }}</td>
                                    <td>{{ mb_substr($info->excerpt,0,60).'...' }}</td>
                                    <th style="text-align: center">{{ $info->category_name }}</th>
                                    <td>
                                        {!!  $info->status == 'draft' ? '<span class="label label-warning">草稿</span>' : '<span class="label label-success">已发布</span>' !!}
                                    </td>
                                    <td>{{ $info->created_at }}</td>
                                    <td style="text-align: center">{{ $info->view_count }}</td>
                                    <td>
                                        <a href="{{ route('admin.post_edit').'/'.$info->id }}" title="" data-toggle="tooltip" data-placement="left" class="depart-list" data-original-title="编辑信息">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a style="color: #f00" href="javascript:;" title="" onclick="post_delete({{ $info->id }})" data-toggle="tooltip" data-placement="right" class="depart-list" data-original-title="放入回收站">
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
                            {!! $posts->links() !!}
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
        function selectCategory(val) {
            if (val)
                window.location.href = "{{ route('admin.posts_list') }}"+"/"+val;
            else
                window.location.href = "{{ route('admin.posts_list') }}";
        }
        function post_delete(id) {
            $.get("{{ route('admin.post_delete') }}"+"/"+id, function(data){
                var data = JSON.parse(data);
                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.posts_list') }}";
                    },500);
                }
            });
        }
    </script>
@endsection