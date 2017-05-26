<section class="content">
    <form id="form_school" role="form" method="post">
        {{ Form::token() }}
        <div class="form-group">
            <label>学校名称</label>
            {{ Form::text('name', $School?$School->name:"", array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label>学校地址</label>
            {{ Form::text('address', $School?$School->address:"", array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label>学校描述</label>
            {{ Form::textarea('description', $School?$School->description:"", array('class'=>'form-control','rows'=>3)) }}
        </div>
    </form>
</section>
