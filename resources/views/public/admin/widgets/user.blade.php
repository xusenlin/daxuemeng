<?php
use App\Model\User;
if ( ! isset($users) ) $users = User::getAllUserName();
if ( ! isset($select_name) ) $select_name = 'user';
?>
@section('style')
    @parent
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/select2/select2.min.css') }}">
@endsection
<select name="{{ $select_name }}" class="js_select form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
    <option value="">请选择</option>
    @foreach($users as  $user)
        <option value="{{ $user->id }}" {{ $user->id == @$defaults ? "selected" : "" }}>{{$user->cellphone}}({{ $user->nickname }})</option>
    @endforeach
</select>
@section('js')
    @parent
    <script src="{{ asset('AdminLTE/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $(function () {
            $(".js_select").select2();
        })
    </script>
@endsection

