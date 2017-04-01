@extends('layouts.admin',['active'=>'生活管理'])
@section('title', $driving['title'].'-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1>
            生活管理
            <small>{{ $driving['title'] }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">{{ $driving['title'] }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $driving['title'] }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="driving_form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>标题</label>
                                        <input type="text" name="title" class="form-control" value="{{ @$driving['data']->title }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>标签</label>
                                        <input type="text" name="tag" class="form-control" value="{{ @$driving['data']->tag }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>封面图片</label>
                                        <small style="margin-left: 30px">大小必须500k以下,请将图片拖到下面区域</small>
                                        <textarea id="cover" class="orm-control lease_cover" disabled>{{ @$driving['data']->cover }}</textarea>
                                        <input id="cover_data" type="hidden" name="cover" value="{{ @$driving['data']->cover }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>封面预览</label>
                                        <div id="cover_box" class="orm-control lease_cover" style="border-color:#fff;">{!! @$driving['data']->cover ? '<img src="'.asset('').@$driving['data']->cover.'" style="height:100px;width:100%;">' : '' !!}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>摘要</label>
                                <textarea  class="form-control" name="excerpt" rows="3" placeholder="Enter ...">{{ @$driving['data']->excerpt }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>内容</label>
                                <textarea  class="form-control" name="content" rows="5" placeholder="Enter ...">{{ @$driving['data']->content }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">状态</label>
                                        <div class="radio">
                                            <label>
                                                <input  type="radio" name="status" value="published" {{ @$driving['data']->status=='published' ? 'checked="checked"' : '' }}>
                                                立即发布,
                                            </label>
                                            <label>
                                                <input  type="radio" name="status" value="draft" {{ @$driving['data']->status=='draft' ? 'checked="checked"' : '' }}>
                                                保存草稿。
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>是否置顶</label>
                                        <div class="radio">
                                            <label>
                                                <input  type="radio" name="is_top" value="true" {{ @$driving['data']->is_top ? 'checked="checked"' : '' }}>
                                                是,
                                            </label>
                                            <label>
                                                <input  type="radio" name="is_top" value="false" {{ @$driving['data']->is_top ? 'checked="checked"' : '' }}>
                                                否。
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked="checked"  disabled> 同意本站协议。
                                </label>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <input type="hidden" name="driving_id" value="{{ @$driving['driving_id'] }}">
                        <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                        <div class="box-footer">
                            <button type="button" class="btn btn-primary" onclick="save()">确认</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    @parent
    <script src="{{ asset('AdminLTE/plugins/InlineAttachment/inline-attachment.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/InlineAttachment/jquery.inline-attachment.js') }}"></script>
    <script>

        //添加封面
        $(function() {
            $('#cover').inlineattachment({
                uploadUrl: '{{ route('photo_add') }}',
                uploadFieldName: 'photo',
                urlText: '{{ asset('') }}'+'{filename}',
                extraParams:{
                    '_token': '{{ csrf_token() }}'
                },
                onFileReceived:function () {
                        $('#cover').val('URL=');
                },
                onFileUploaded:function (filename) {
                    $('#cover_box').html(
                            '<img src="{{ asset('') }}'+filename+'" style="height:100px;width:100%;">'
                    );
                    $('#cover_data').val(filename);
                }
            });
        });


        function save() {


            var posrData = $("#driving_form").serialize();
            $.post("{{ route('admin.driving_save') }}",posrData , function(data){

                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.driving_list') }}";
                    },500);
                }
            },'json');
        }

    </script>
@endsection