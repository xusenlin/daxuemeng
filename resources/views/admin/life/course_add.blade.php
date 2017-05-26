<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datetimepicker/datetimepicker.css') }}">
<section class="content">
    <form id="form_course" role="form" method="post">
        {{ Form::token() }}
        <div class="form-group">
            <label>课程名称</label>
            {{ Form::text('name', $Course?$Course->name:"", array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label>所属学校</label>
            @include("public.admin.widgets.school", array('default'=>$Course?$Course->school_id:"",'callback'=>'selected_school_back'))
        </div>
        <div class="form-group">
            <label>所属院系</label>
            <?php
                $depart_options = [];
                if($Course) {
                    $departments = \App\Model\Department::getSchoolDeparts($Course->school_id);
                    foreach ($departments as $department) {
                        $depart_options[$department->id] = $department->name;
                    }
                }
            ?>
            {{ Form::select('department', $depart_options, $Course?$Course->department_id:"", array('class'=>'form-control','id'=>'_department', 'onchange'=>'selected_department_back(this.value)')) }}
        </div>
        <div class="form-group">
            <label>所属专业</label>
            <?php
            $major_options = [];
            if($Course) {
                $majors = \App\Model\Major::getDepartmentMajors($Course->department_id);
                foreach ($majors as $major) {
                    $major_options[$major->id] = $major->name;
                }
            }
            ?>
            {{ Form::select('major', $major_options, $Course?$Course->major_id:"", array('class'=>'form-control','id'=>'_major')) }}
        </div>
        <div class="form-group">
            <label>年级</label>
            {{ Form::text('grade', $Course?$Course->grade:"", array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label>班级（多个用逗号分隔，比如1班,2班）</label>
            {{ Form::text('class', $Course?$Course->class:"", array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label>上课时间</label>
            {{ Form::select('type', \App\Model\Timetable::getCourseTypeDesc(), $Course?$Course->type:"", array('class'=>'form-control','id'=>'_major')) }}
            @include("public.admin.widgets.weekday", array('defaults'=>$Course?$Course->weekday:""))
            从 {{ Form::text('start_time', $Course?date('H:i', strtotime($Course->start_time)):"", array('class'=>'form-control date-picker')) }}到 {{ Form::text('end_time', $Course?date('H:i', strtotime($Course->end_time)):"", array('class'=>'form-control date-picker')) }}
        </div>
        <div class="form-group">
            <label>上课老师</label>
            {{ Form::text('teacher', $Course?$Course->teacher:"", array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label>上课地点</label>
            {{ Form::text('place', $Course?$Course->place:"", array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label>备注</label>
            {{ Form::textarea('comment', $Course?$Course->timetable_comment:"", array('class'=>'form-control','rows'=>3)) }}
        </div>
    </form>
</section>
<script src="{{ asset('AdminLTE/plugins/datetimepicker/datetimepicker.js') }}"></script>
<script>
    $(function () {
        jQuery(".date-picker").datetimepicker({
            lang: 'ch',
            timepicker: true,
            datepicker: false,
            minTime:"6:55",
            maxTime:"23:05",
            step:5,
            format: "H:i",
            formatDate: "H:i"
        })
    })
    function selected_school_back(school_id) {
        if(!school_id){
            $('#_department').html('<option>请选择</option>');
            return ;
        }
        var _url = '{{ route('school_department') }}/'+school_id;
        $.get(_url, {}, function (data) {
            if(!data.success)return;
            var _options = '<option>请选择</option>';
            for(var i in data.data) {
                var department = data.data[i];
                _options += '<option value="'+department.id+'">'+department.name+'</option>';
            }
            $('#_department').html(_options);
            selected_department_back($('#_department').val());
        }, 'json');
    }

    function selected_department_back(department_id) {
        if(!department_id){
            $('#_major').html('<option>请选择</option>');
            return ;
        }
        var _url = '{{ route('department_major') }}/'+department_id;
        $.get(_url, {}, function (data) {console.log(data);
            if(!data.success)return;
            var _options = '<option>请选择</option>';
            for(var i in data.data) {
                var major = data.data[i];
                _options += '<option value="'+major.id+'">'+major.name+'</option>';
            }
            $('#_major').html(_options);
        }, 'json');
    }
</script>
