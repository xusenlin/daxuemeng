@extends('layouts.admin',['active'=>'生活管理'])
@section('title', $secondary['title'].'-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1>
            生活管理
            <small>{{ $secondary['title'] }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 生活管理</a></li>
            <li class="active">{{ $secondary['title'] }}</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $secondary['title'] }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" id="secondary_form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>产品名称</label>
                                        <input type="text" name="name" class="form-control" value="{{ @$secondary['data']->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>产品标题</label>
                                        <input type="text" name="title" class="form-control" value="{{ @$secondary['data']->title }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>标签</label>
                                        <input type="text" name="tag" class="form-control" value="{{ @$secondary['data']->tag }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>产品所有者</label>
                                        @include('public.admin.widgets.user',array('select_name'=>'owner','defaults'=>@$secondary['data']->owner?@$secondary['data']->owner:""))
                                        {{--<input type="text" name="owner" class="form-control" value="{{ @$lease['data']->owner }}">--}}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label>封面图片</label>
                                        <small style="margin-left: 30px">大小必须500k以下,请将图片拖到下面区域</small>
                                        <textarea id="cover" class="orm-control lease_cover" disabled>{{ @$secondary['data']->cover }}</textarea>
                                        <input id="cover_data" type="hidden" name="cover" value="{{ @$secondary['data']->cover }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>封面预览</label>
                                        <div id="cover_box" class="orm-control lease_cover" style="border-color:#fff;">{!! @$secondary['data']->cover ? '<img src="'.asset('').@$secondary['data']->cover.'" style="height:100px;width:100%;">' : '' !!}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>产品描述</label>
                                <textarea  class="form-control" name="description" rows="3" placeholder="Enter ...">{{ @$secondary['data']->description }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>原价单价</label>
                                                <input type="text" name="original_price" class="form-control" value="{{ @$secondary['data']->original_price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>售价单价</label>
                                                <input type="text" name="sale_price" class="form-control" value="{{ @$secondary['data']->sale_price }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>产品数量</label>
                                        <input type="text" name="total_qty" class="form-control" value="{{ @$secondary['data']->total_qty }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputFile">状态</label>
                                        <div class="radio">
                                            <label>
                                                <input  type="radio" name="status" value="published" {{ @$secondary['data']->status=='published' ? 'checked="checked"' : '' }}>
                                                立即发布,
                                            </label>
                                            <label>
                                                <input  type="radio" name="status" value="pending" {{ @$secondary['data']->status=='pending' ? 'checked="checked"' : '' }}>
                                                保存草稿。
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>联系电话</label>
                                        <input type="text" name="cellphone" class="form-control" value="{{ @$secondary['data']->cellphone }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>产品图片</label>
                                <small style="margin-left: 30px">建议尺寸200px*200px,大小必须500k以下,请将图片依次拖到下面区域</small>
                                <textarea id="images" class="orm-control lease_cover" disabled>{{ @$secondary['data']->images }},</textarea>
                            </div>
                            <div class="form-group">
                                <label>图片预览</label>
                                <div id="images_box" class="orm-control lease_cover" style="border-color: #fff">
                                    @if(@$secondary['data']->images)
                                        @foreach(explode(',',$secondary['data']->images) as $image)
                                            <div style="position: relative;display: inline-block;">
                                                <img src="{{ asset($image) }}" style="height:100px;width:178px;padding: 4px" url="{{ $image }}">
                                                <i class="fa fa-trash delete-lease-photo" onclick="delete_photo(this)"></i>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                {{--<input id="images_data" type="hidden" name="images" value="{{ @$lease['data']->images }}">--}}
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" checked="checked"  disabled> 同意本站协议。
                                </label>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <input type="hidden" name="secondary_id" value="{{ @$secondary['secondary_id'] }}">
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

        //添加产品图片
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
            var posrData = $("#secondary_form").serialize()+"&images="+imagesData;
            $.post("{{ route('admin.secondary_save') }}",posrData , function(data){

                if( ! data.success){
                    modal_show('警告','modal-danger',data.msg);
                } else {
                    modal_show('提示','modal-primary',data.msg);
                    setTimeout(function () {
                        window.location.href="{{ route('admin.secondary_list') }}";
                    },500);
                }
            },'json');
        }

        //删除产品图片
        function delete_photo(this_obj) {
            $(this_obj).parent().remove();
        }
    </script>
@endsection