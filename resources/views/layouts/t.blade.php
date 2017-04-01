@extends('layouts.admin',['active'=>'首页'])
@section('title', '后台首页-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1>
            后台首页
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li class="active">用户列表</li>
        </ol>
    </section>
    <section class="content">

    </section>
@endsection