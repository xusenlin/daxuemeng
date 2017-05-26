<?php
use App\Model\Timetable;
if ( ! isset($weekdays) ) $weekdays = Timetable::getWeekdayDesc();
if ( ! isset($select_name) ) $select_name = 'weekday';
?>
<select name="{{ $select_name }}" class="form-control select2" style="width: 100%;" {{ @$disabled?"disabled":"" }}>
    @foreach($weekdays as $val => $desc)
        <?php
            if(@$defaults && in_array($val, explode(",", $defaults))) $selected = "selected";
            else $selected = "";
        ?>
        <option value="{{ $val }}" {{$selected}}>{{ $desc }}</option>

    @endforeach
</select>

<script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
<script>
    $(function () {
        $(".select2").select2();
    })
</script>
