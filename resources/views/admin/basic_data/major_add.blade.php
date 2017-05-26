<section class="content">
    <form id="form_major" role="form" method="post">
        {{ Form::token() }}
        <div class="form-group">
            <label>所属学校</label>
            @include("public.admin.widgets.school", array('default'=>$Major?$Major->school_id:"",'callback'=>'selected_school_back'))
        </div>
        <div class="form-group">
            <label>所属院系</label>
            <?php
                $options = [];
                if($Major) {
                    $departments = \App\Model\Department::getSchoolDeparts($Major->school_id);
                    foreach ($departments as $department) {
                        $options[$department->id] = $department->name;
                    }
                }
            ?>
            {{ Form::select('department', $options, $Major?$Major->department_id:"", array('class'=>'form-control','id'=>'_department')) }}
        </div>
        <div class="form-group">
            <label>专业名称</label>
            {{ Form::text('name', $Major?$Major->name:"", array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label>专业描述</label>
            {{ Form::textarea('description', $Major?$Major->description:"", array('class'=>'form-control','rows'=>3)) }}
        </div>
    </form>
</section>
<script>
    function selected_school_back(school_id) {
        var _url = '{{ route('school_department') }}/'+school_id;
        $.get(_url, {}, function (data) {
            if(!data.success)return;
            var _options = '';
            for(var i in data.data) {
                var department = data.data[i];
                _options += '<option value="'+department.id+'">'+department.name+'</option>';
            }
            $('#_department').html(_options);
        }, 'json');
    }
</script>
