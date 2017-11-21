@extends('layouts.admin',['active'=>'回收站'])
@section('title', '回收站-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1>
            回收站
            <small>回收站</small>
        </h1>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">回收站</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">被删除的文章</h3>
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
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ mb_substr($post->title,0,40).'...' }}</td>
                                    <td>{{ mb_substr($post->excerpt,0,70).'...' }}</td>
                                    <td>
                                        <span class="label label-danger">已删除</span>
                                    </td>
                                    <td>{{ $post->published_time }}</td>
                                    <td>{{ $post->view_count }}</td>
                                    <td>
                                        <a style="color: #00a65a" href="javascript:;" title="" onclick="recover_post({{ $post->id }})" data-toggle="tooltip" data-placement="right" class="depart-list" data-original-title="恢复到草稿">
                                            <span class="glyphicon glyphicon-circle-arrow-right"></span>
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
        function recover_post(post_id) {
            $.get("{{ route('admin.recover_post') }}"+"/"+post_id, function(data){
                var data = JSON.parse(data);
                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.recycle_bin') }}";
                    },500);
                }
            });
        }
    </script>
@endsection