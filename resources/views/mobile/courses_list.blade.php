@extends('layouts.mobile')
@section('title', '选择班级')
@section('style')
    <style>
        .iconfont{
            font-size: 28px;
            margin-bottom: 6px;
            display: inline-block;
        }
        .mint-navbar .mint-tab-item.is-selected{
            border-bottom: 0;
        }
        body{
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <div id="app">
        <ul class="my-list-ul">
            <li class="ellipsis" style="font-size: 12px;box-shadow: 0 0 8px rgba(0,0,0,.3);">
                {{ $data['name'] }}>班级</li>
            @foreach($data['grade_and_class'] as $grade_name => $grade)
                @foreach($grade as $class)
                    <li style="text-indent: 20px"><a href="{{ route('timetables',$data['major_id']).'/'.$grade_name.'/'.$class }}" style="display: block;color: #000">{{ $grade_name }}>{{ $class }}</a></li>
                @endforeach
            @endforeach
        </ul>

    </div>
@endsection

