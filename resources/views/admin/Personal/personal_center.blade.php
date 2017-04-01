@extends('layouts.admin',['active'=>'个人中心','highlight'=>'我的信息'])
@section('title', '我的信息-'.Config::get('site.site_title'))
@section('content')
    <section class="content-header">
        <h1>
            个人中心
            <small>我的信息</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 个人中心</a></li>
            <li class="active">我的信息</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa  fa-info-circle"></i>
                        <h3 class="box-title">基础信息</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body box-profile">
                                <img class="profile-user-img img-responsive img-circle" src="{{ $user_info->avatar ? asset($user_info->avatar) : asset('Backend/image/user.jpg') }}" alt="User profile picture">
                                <h3 class="profile-username text-center">{{ $user_info->nickname }}</h3>

                                <p class="text-muted text-center">{{ $user_info->rank_name }}</p>

                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                        <b>手机</b> <a class="pull-right">{{ $user_info->cellphone }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>QQ：</b> <a class="pull-right">{{ $user_info->qq }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>E-mail:</b> <a class="pull-right">{{ $user_info->email }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>身份:</b> <a class="pull-right">{{  $user_info->type }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa  fa-gears"></i>
                        <h3 class="box-title">一般信息</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td>性别</td>
                                        <td>{{ get_sex($user_info->sex) }}</td>
                                    </tr>
                                    <tr>
                                        <td>爱好</td>
                                        <td>{{ $user_info->hobby }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="content">
                                    <h4>个人简介：</h4>
                                    <br>
                                    <p style="text-indent: 2em;">
                                        {{ $user_info->signature }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section class="content">

    </section>
@endsection