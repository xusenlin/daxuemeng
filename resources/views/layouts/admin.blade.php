
@include('public.admin.head')

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">
    @include('public.admin.nav')

    @include('public.admin.sidebar')

    <div class="content-wrapper">
        @yield('content')
        @include('public.admin.widgets.form')
        @include('public.admin.widgets.modal')
    </div>

    @include('public.admin.foot')

    @include('public.admin.side')

</div>

@include('public.admin.footer')