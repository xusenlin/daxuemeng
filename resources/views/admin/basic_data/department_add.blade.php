<section class="content">
    <form id="form_department" role="form" method="post">
        {{ Form::token() }}
        <div class="form-group">
            <label>所属学校</label>
            @include("public.admin.widgets.school", array('default'=>$Department?$Department->school_id:""))
        </div>
        <div class="form-group">
            <label>院系名称</label>
            {{ Form::text('name', $Department?$Department->name:"", array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label>院系描述</label>
            {{ Form::textarea('description', $Department?$Department->description:"", array('class'=>'form-control','rows'=>3)) }}
        </div>
    </form>
</section>
