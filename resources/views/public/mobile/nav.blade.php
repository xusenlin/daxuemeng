<?php
if ( ! isset($active) ) $active = '';
?>
<div class="mint-tabbar is-fixed">
    <a href="{{ $active == '世界' ? 'javascript:;' : route('home') }}" class="mint-tab-item {{ $active == '世界' ? 'is-selected':'' }}">
        <div class="mint-tab-item-icon">
            <i class="iconfont icon-fangzi"></i>
        </div>
        <div class="mint-tab-item-label">
            校园
        </div>
    </a>
    {{--<a href="{{ $active == '论坛' ? 'javascript:;' : route('post') }}" class="mint-tab-item {{ $active == '帖子' ? 'is-selected':'' }}">--}}
        {{--<div class="mint-tab-item-icon">--}}
            {{--<i class="iconfont icon-reply"></i>--}}
        {{--</div>--}}
        {{--<div class="mint-tab-item-label">--}}
            {{--帖子--}}
        {{--</div>--}}
    {{--</a>--}}
    <a href="{{ $active == '生活' ? 'javascript:;' : route('life') }}" class="mint-tab-item {{ $active == '生活' ? 'is-selected':'' }}">
        <div class="mint-tab-item-icon">
            <i class="iconfont icon-shenghuo1"></i>
        </div>
        <div class="mint-tab-item-label">
            生活
        </div>
    </a>
    <a href="{{ $active == '我的' ? 'javascript:;' : route('mine') }}" class="mint-tab-item {{ $active == '我的' ? 'is-selected':'' }}">
        <div class="mint-tab-item-icon">
            <i class="iconfont icon-wode"></i>
        </div>
        <div class="mint-tab-item-label">
            我的
        </div>
    </a>
</div>