@extends('layouts.admin',['active'=>'文章管理','highlight'=>'编辑文章'])
@section('title', $post['title'].'-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1>
            文章管理
            <small>{{ $post['title'] }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 文章管理</a></li>
            <li class="active">{{ $post['title'] }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $post['title'] }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>标题</label>
                                        <input type="text" name="title" class="form-control" value="{{ @$post['data']->title }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>标签</label>
                                        <input type="text" name="tag" class="form-control" value="{{ @$post['data']->tag }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>选择分类</label>
                                        <select name="category_id" class="form-control">
                                            <option value="">未选择分类</option>
                                            @foreach($categorys as $category)
                                                @if($category->id == @$post['data']->category_id)
                                                    <option selected value="{{ $category->id }}">{{ $category->name }}    ----{{ $category->description }}</option>
                                                @else
                                                    <option value="{{ $category->id }}">{{ $category->name }}    ----{{ $category->description }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>封面图片</label>
                                        <small style="margin-left: 30px">为显示美观,图片大小必须500k以下,尺寸比例820px*356px,请将图片拖到下面区域</small>
                                        <textarea id="cover" class="orm-control lease_cover" disabled>{{ @$post['data']->cover }}</textarea>
                                        <input id="cover_data" type="hidden" name="cover" value="{{ @$post['data']->cover }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>封面预览</label>
                                        <div id="cover_box" class="orm-control lease_cover" style="border-color:#fff;">{!! @$post['data']->cover ? '<img src="'.asset('').@$post['data']->cover.'" style="height:100px;width:100%;">' : '' !!}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>摘要</label>
                                <textarea  class="form-control" name="excerpt" rows="3" placeholder="Enter ...">{{ @$post['data']->excerpt }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>内容</label>
                                <textarea  class="form-control" name="content" rows="5" placeholder="Enter ...">{{ @$post['data']->content }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">状态</label>
                                        <div class="radio">
                                            <label>
                                                <input  type="radio" name="status" value="published" {{ @$post['data']->status=='published' ? 'checked="checked"' : '' }}>
                                                立即发布,
                                            </label>
                                            <label>
                                                <input  type="radio" name="status" value="draft" {{ @$post['data']->status=='draft' ? 'checked="checked"' : '' }}>
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
                                                <input  type="radio" name="is_top" value="1" {{ @$post['data']->is_top!=0 ? 'checked="checked"' : '' }}>
                                                是,
                                            </label>
                                            <label>
                                                <input  type="radio" name="is_top" value="0" {{ @$post['data']->is_top==0 ? 'checked="checked"' : '' }}>
                                                否。
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group ">
                                        <label>文章图片</label>
                                        <small style="margin-left: 30px">建议尺寸比例820px*356px,大小必须500k以下,请将图片依次拖到下面区域</small>
                                        <textarea id="images" class="orm-control lease_cover" disabled>{{ @$post['data']->meta_data }},</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>图片预览</label>
                                        <div id="images_box" class="orm-control lease_cover" style="border-color: #fff">
                                            @if(@$post['data']->meta_data)
                                                @foreach(explode(',',$post['data']->meta_data) as $image)
                                                    <div style="position: relative;display: inline-block;">
                                                        <img src="{{ asset($image) }}" style="height:100px;width:178px;padding: 4px" url="{{ $image }}">
                                                        <i class="fa fa-trash delete-lease-photo" onclick="delete_photo(this)"></i>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        {{--<input id="images_data" type="hidden" name="images" value="{{ @$lease['data']->images }}">--}}
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
                        <input type="hidden" name="id" value="{{ @$post['id'] }}">
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

        $(function() {
            $('#images').inlineattachment({
                uploadUrl: '{{ route('photo_add') }}',
                uploadFieldName: 'photo',
                urlText: '{{ asset('') }}'+'{filename}',
                extraParams:{
                    '_token': '{{ csrf_token() }}'
                },
                onFileReceived:function () {
                    $('#cover').val(',');
                },
                onFileUploaded:function (filename) {
                    $('#images_box').append(
                            '<div style="position: relative;display: inline-block;">'+
                            '<img src="{{ asset('') }}'+filename+'" style="height:100px;width:178px;padding: 4px" url="'+filename+'">'+
                            '<i class="fa fa-trash delete-lease-photo" onclick="delete_photo(this)"></i></div>'
                    );
                }
            });
        });
        function save() {

            var imagesData = '';
            $('#images_box img').each(function () {
                imagesData += $(this).attr('url')+',';
            });
            var postData = $("#form").serialize()+"&meta_data="+imagesData;

            $.post("{{ route('admin.post_save') }}",postData , function(data){

                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.posts_list') }}";
                    },500);
                }
            },'json');
        }
        function delete_photo(this_obj) {
            $(this_obj).parent().remove();
        }
    </script>
@endsection