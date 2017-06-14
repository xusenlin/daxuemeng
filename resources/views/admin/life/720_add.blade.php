<script src="{{ asset('AdminLTE/plugins/InlineAttachment/inline-attachment.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/InlineAttachment/jquery.inline-attachment.js') }}"></script>
<section class="content">
    <form id="form_panorama" role="form" method="post">
        {{ Form::token() }}
        <div class="form-group">
            <label>720云名称</label>
            {{ Form::text('name', $panorama?$panorama->name:"",array('class'=>'form-control'))}}
        </div>
        <div class="form-group">
            <label>720云Url</label>
            {{ Form::text('url', $panorama?$panorama->url:"",array('class'=>'form-control'))}}
        </div>
        <div class="form-group">
            <label>720云备注</label>
            {{ Form::textarea('remarks', $panorama?$panorama->remarks:"",array('class'=>'form-control','rows'=>3)) }}
        </div>
        <div class="form-group">
            <label>720云封面</label>
            <small style="margin-left: 30px">大小必须500k以下,请将图片拖到下面区域</small>
            <textarea id="cover" class="orm-control lease_cover" disabled>{{ @$panorama->cover }}</textarea>
            <input id="cover_data" type="hidden" name="cover" value="{{ @$panorama->cover }}">
        </div>
        <div class="form-group">
            <label>720云封面预览</label>
            <div id="cover_box" class="orm-control lease_cover" style="border-color:#fff;">{!! @$panorama->cover ? '<img src="'.asset('').@$panorama->cover.'" style="height:100px;width:100%;">' : '' !!}</div>
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