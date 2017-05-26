@extends('layouts.mobile')
@section('title', $data->title)
@section('content')
    <div id="app" class="details">
        <h1>{{ $data->name }}</h1>
        <div class="details-data">{{ substr($data->created_at,0,10) }}</div>
        <div class="details-tag">兼职</div>

        <div class="details-content">
            {{ $data->position_desc  }}
        </div>
        <ul class="details-job-ul">
            <li>职位类别:{{ $data->position_type }}</li>
            <li>薪资水平:{{ $data->salary }}</li>
            <li>招聘人数:{{ $data->person_count }}</li>
            <li>性别要求:{{ get_sex($data->sex) }}</li>
            <li>工作地点:{{ $data->work_place }}</li>
            <li>工作时间:{{ $data->work_time }}</li>
            <li>联系人:{{ $data->contact }}</li>
            <li>联系电话:{{ $data->contact_phone }}</li>
            <li>QQ:{{ $data->qq }}</li>
            <li>邮箱:{{ $data->email }}</li>
            <li>备注:{{ $data->comment }}</li>
        </ul>
    </div>
@endsection
@section('js')
    <script>
        new Vue({
            el: '#app',
            data:{
                selected:'1'
            },
            methods: {

            }
        })
    </script>
@endsection
