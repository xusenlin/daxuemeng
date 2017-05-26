<?php
if ( ! isset($departments) ) $departments = \App\Model\Department::all();
if ( ! isset($select_name) ) $select_name = 'department';
?>
@section('style')
    @parent
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2/select2.min.css') }}">
@endsection
<select name="{{ $select_name }}" class="js_select form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="selected_department(this)">
    <option value="">请选择</option>
    @foreach($departments as  $department)
        <option value="{{ $department->id }}" {{ $department->id == @$default ? "selected" : "" }}>{{$department->name}}</option>
    @endforeach
</select>
@section('js')
    @parent
    <script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $(".js_select").select2();
        })
        function selected_department(obj) {
            @if($callback) {{ $callback }}(obj.value);
        }
    </script>
@endsection

