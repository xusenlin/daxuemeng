<?php
if ( ! isset($schools) ) $schools = \App\Model\School::all();
if ( ! isset($select_name) ) $select_name = 'school';
?>
@section('style')
    @parent
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2/select2.min.css') }}">
@endsection
<select name="{{ $select_name }}" class="js_select form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="<?php if(@$callback) echo $callback."(this.value);"; ?>">
    <option value="">请选择</option>
    @foreach($schools as  $school)
        <option value="{{ $school->id }}" {{ $school->id == @$default ? "selected" : "" }}>{{$school->name}}</option>
    @endforeach
</select>
@section('js')
    <script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $(".js_select").select2();
        });
    </script>
@endsection

