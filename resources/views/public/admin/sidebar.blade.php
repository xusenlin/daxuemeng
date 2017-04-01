<!-- 主（左）侧边栏 -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('Backend/image/user.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->nickname }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{ get_sex(Auth::user()->sex) }}</a>
            </div>
        </div>

        <ul class="sidebar-menu">
            @foreach(get_menu_data() as $group=>$item)
                <li class="header"></li>
                @foreach($item as $menu)
                    @if(@$active==$menu['name'])
                        <li class="treeview active">
                    @else<li class="treeview">{{--全部打开添加active类--}}
                        @endif
                        @if(@$menu['link'])<a href="{{ $menu['link'] == '/'? '/' : route($menu['link']) }}">
                            @else<a href="javascript:;">
                                @endif
                                <i class="fa {{ $menu['icon'] }}"></i> <span>{{ $menu['name'] }}</span>
                                @if(!@$menu['link'])
                                    <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                @foreach($menu['submenu'] as $submenu)
                                    <li><a href="{{ route($submenu['link']) }}"  {!! $submenu['name'] == @$highlight ? 'style="color: #c9302c;"' : '' !!}><i class="fa {{ $submenu['icon'] }}"></i> {{ $submenu['name'] }}</a></li>
                                @endforeach
                            </ul>
                            @else </a>
                        @endif
                    </li>
                    @endforeach
                @endforeach
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>