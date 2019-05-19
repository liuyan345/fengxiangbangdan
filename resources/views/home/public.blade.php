<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>分享榜单-渠道商</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="liuyan" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{--<link href="{{asset('/style_js/cpcAdmin/assets/fonts/font.css')}}" rel="stylesheet" type="text/css" />--}}
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{asset('/style_js/cpcAdmin/assets/global/css/components-rounded.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{asset('/style_js/cpcAdmin/assets/layouts/layout/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/layouts/layout/css/themes/darkblue.min.css')}}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{asset('/style_js/cpcAdmin/assets/layouts/layout/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- END THEME LAYOUT STYLES -->
    <!-- END HEAD -->
@section('style')
@show
<body class="page-header-fixed page-sidebar-closed-hide-logo">
<div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/admin/adminPlat">
                    <img src="{{asset('/img/logo1.png')}}" alt="logo" class="logo-default" /> </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="{{asset('/style_js/cpcAdmin/assets/layouts/layout/img/avatar3_small.jpg')}}" />
                            <span class="username username-hide-on-mobile"> @if(!empty(Session::get("home")['name'])){{Session::get("home")['name']}} @else {{Session::get("home")['name']}} @endif </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">

                            <li>
                                <a href="/home/logout">
                                    <i class="icon-key"></i> 注销 </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->

            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
                    <!--菜单开始-->
                    <li class="heading">
                        <h3 class="uppercase">菜单</h3>
                    </li>

                    <li class="nav-item  ">
                        <a href="/home/info" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">公司信息</span>
                            <span class="arrow"></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="/home/changePw" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">修改密码</span>
                            <span class="arrow"></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="/home/data" class="nav-link nav-toggle">
                            <i class="icon-book-open"></i>
                            <span class="title">数据列表</span>
                            <span class="arrow"></span>
                        </a>
                    </li>

                </ul>
                <!-- END SIDEBAR MENU -->
                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN PAGE TITLE-->
                <h1 class="page-title">  @yield('title')
                    <small>@yield('pageDiscription')</small>
                </h1>
                <!-- END PAGE TITLE-->
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <a href="/home/info">首页</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <span>@yield('ptitle')</span>
                        </li>
                    </ul>
                </div>
                <!-- END PAGE HEADER-->

                @section('content')
                @show

            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->

    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
</div>

<!-- BEGIN CORE PLUGINS -->
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
@section('javascript')
@show

@section('page_javascript')
@show
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{asset('/style_js/cpcAdmin/assets/layouts/layout2/scripts/layout.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/layouts/layout2/scripts/demo.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/layouts/global/scripts/quick-nav.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-toastr/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/pages/scripts/ui-toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/pages/scripts/ui-sweetalert.min.js')}}" type="text/javascript"></script>
{{--<script src="https://dn-bts.qbox.me/sdk/bugtags-1.0.3.js"></script>--}}
{{--<script>--}}
    {{--// VERSION_NAME 替换为项目的版本，VERSION_CODE 替换为项目的子版本--}}
    {{--new Bugtags('efa2bd0e1f4577e09025ad1fd55496ec','第一版','1.0');--}}
{{--</script>--}}


<script>
    $(document).ready(function()
    {
        $('#clickmewow').click(function()
        {
            $('#radio1003').attr('checked', 'checked');
        });
    })
</script>
</body>

</html>