<script src="{{ asset('AdminLTE/plugins/InlineAttachment/inline-attachment.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/InlineAttachment/jquery.inline-attachment.js') }}"></script>
<section class="content">
    <form id="form_720" role="form" method="post">
        {{ Form::token() }}
        <div class="form-group">
            <label>图片名称</label>
            {{ Form::text('name', isset($name) ? $name:"",array('class'=>'form-control'))}}
        </div>
        <div class="form-group">
            <label>图片</label>
            <small style="margin-left: 30px">轮播图比例为宽度374px*200px,请将图片拖到下面区域</small>
            <textarea id="cover" class="orm-control lease_cover" disabled>{{ @$url }}</textarea>
            <input id="cover_data" type="hidden" name="cover" value="{{ @$url }}">
        </div>
        <div class="form-group">
            <label>图片预览</label>
            <div id="cover_box" class="orm-control lease_cover" style="border-color:#fff;">{!! @$url ? '<img src="'.asset('').@$url.'" style="height:100px;width:100%;">' : '' !!}</div>
        </div>
    </form>
</section>
<script>
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
</script>