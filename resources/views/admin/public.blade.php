<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>后台首页</title>
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
                    <img src="{{asset('/style_js/cpcAdmin/assets/layouts/layout/img/logo.png')}}" alt="logo" class="logo-default" /> </a>
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
                    <!-- BEGIN NOTIFICATION DROPDOWN -->

                    <!-- <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-bell"></i>
                            <span class="badge badge-default"> 7 </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>
                                    <span class="bold">12 pending</span> notifications</h3>
                                <a href="page_user_profile_1.html">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">just now</span>
                                            <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="fa fa-plus"></i>
                                                        </span> New user registered. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">3 mins</span>
                                            <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span> Server #12 overloaded. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">10 mins</span>
                                            <span class="details">
                                                        <span class="label label-sm label-icon label-warning">
                                                            <i class="fa fa-bell-o"></i>
                                                        </span> Server #2 not responding. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">14 hrs</span>
                                            <span class="details">
                                                        <span class="label label-sm label-icon label-info">
                                                            <i class="fa fa-bullhorn"></i>
                                                        </span> Application error. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">2 days</span>
                                            <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span> Database overloaded 68%. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">3 days</span>
                                            <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span> A user IP blocked. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">4 days</span>
                                            <span class="details">
                                                        <span class="label label-sm label-icon label-warning">
                                                            <i class="fa fa-bell-o"></i>
                                                        </span> Storage Server #4 not responding dfdfdfd. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">5 days</span>
                                            <span class="details">
                                                        <span class="label label-sm label-icon label-info">
                                                            <i class="fa fa-bullhorn"></i>
                                                        </span> System Error. </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <span class="time">9 days</span>
                                            <span class="details">
                                                        <span class="label label-sm label-icon label-danger">
                                                            <i class="fa fa-bolt"></i>
                                                        </span> Storage server failed. </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                    <!-- END NOTIFICATION DROPDOWN -->
                    <!-- BEGIN INBOX DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <!-- <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-envelope-open"></i>
                            <span class="badge badge-default"> 4 </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="external">
                                <h3>You have
                                    <span class="bold">7 New</span> Messages</h3>
                                <a href="app_inbox.html">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    <li>
                                        <a href="#">
                                                    <span class="photo">
                                                        <img src="{{asset('/style_js/cpcAdmin/assets/layouts/layout3/img/avatar2.jpg')}}" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                        <span class="from"> Lisa Wong </span>
                                                        <span class="time">Just Now </span>
                                                    </span>
                                            <span class="message"> Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                                    <span class="photo">
                                                        <img src="{{asset('/style_js/cpcAdmin/assets/layouts/layout3/img/avatar3.jpg')}}" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                        <span class="from"> Richard Doe </span>
                                                        <span class="time">16 mins </span>
                                                    </span>
                                            <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                                    <span class="photo">
                                                        <img src="{{asset('/style_js/cpcAdmin/assets/layouts/layout3/img/avatar1.jpg')}}" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                        <span class="from"> Bob Nilson </span>
                                                        <span class="time">2 hrs </span>
                                                    </span>
                                            <span class="message"> Vivamus sed nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                                    <span class="photo">
                                                        <img src="{{asset('/style_js/cpcAdmin/assets/layouts/layout3/img/avatar2.jpg')}}" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                        <span class="from"> Lisa Wong </span>
                                                        <span class="time">40 mins </span>
                                                    </span>
                                            <span class="message"> Vivamus sed auctor 40% nibh congue nibh... </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                                    <span class="photo">
                                                        <img src="{{asset('/style_js/cpcAdmin/assets/layouts/layout3/img/avatar3.jpg')}}" class="img-circle" alt=""> </span>
                                            <span class="subject">
                                                        <span class="from"> Richard Doe </span>
                                                        <span class="time">46 mins </span>
                                                    </span>
                                            <span class="message"> Vivamus sed congue nibh auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                    <!-- END INBOX DROPDOWN -->
                    <!-- BEGIN TODO DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                   <!--  <li class="dropdown dropdown-extended dropdown-tasks" id="header_task_bar">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <i class="icon-calendar"></i>
                            <span class="badge badge-default"> 3 </span>
                        </a>
                        <ul class="dropdown-menu extended tasks">
                            <li class="external">
                                <h3>You have
                                    <span class="bold">12 pending</span> tasks</h3>
                                <a href="app_todo.html">view all</a>
                            </li>
                            <li>
                                <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">New release v1.2 </span>
                                                        <span class="percent">30%</span>
                                                    </span>
                                            <span class="progress">
                                                        <span style="width: 40%;" class="progress-bar progress-bar-success" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">40% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Application deployment</span>
                                                        <span class="percent">65%</span>
                                                    </span>
                                            <span class="progress">
                                                        <span style="width: 65%;" class="progress-bar progress-bar-danger" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">65% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Mobile app release</span>
                                                        <span class="percent">98%</span>
                                                    </span>
                                            <span class="progress">
                                                        <span style="width: 98%;" class="progress-bar progress-bar-success" aria-valuenow="98" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">98% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Database migration</span>
                                                        <span class="percent">10%</span>
                                                    </span>
                                            <span class="progress">
                                                        <span style="width: 10%;" class="progress-bar progress-bar-warning" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">10% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Web server upgrade</span>
                                                        <span class="percent">58%</span>
                                                    </span>
                                            <span class="progress">
                                                        <span style="width: 58%;" class="progress-bar progress-bar-info" aria-valuenow="58" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">58% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">Mobile development</span>
                                                        <span class="percent">85%</span>
                                                    </span>
                                            <span class="progress">
                                                        <span style="width: 85%;" class="progress-bar progress-bar-success" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">85% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                                    <span class="task">
                                                        <span class="desc">New UI release</span>
                                                        <span class="percent">38%</span>
                                                    </span>
                                            <span class="progress progress-striped">
                                                        <span style="width: 38%;" class="progress-bar progress-bar-important" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100">
                                                            <span class="sr-only">38% Complete</span>
                                                        </span>
                                                    </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->

                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    {{--<li class="dropdown dropdown-user">--}}
                        {{--<a href="/like/user" class="dropdown-toggle">--}}
                            {{--<span class="username username-hide-on-mobile"> 喜欢值得买 </span>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="{{asset('/style_js/cpcAdmin/assets/layouts/layout/img/avatar3_small.jpg')}}" />
                            <span class="username username-hide-on-mobile"> @if(!empty(Session::get("admin")['nick_name'])){{Session::get("admin")['nick_name']}} @else {{Session::get("admin")['admin_name']}} @endif </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <!-- <li>
                                <a href="">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="icon-calendar"></i> My Calendar </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="icon-envelope-open"></i> My Inbox
                                    <span class="badge badge-danger"> 3 </span>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="icon-rocket"></i> My Tasks
                                    <span class="badge badge-success"> 7 </span>
                                </a>
                            </li>
                            <li class="divider"> </li>
                             -->
                            {{--<li>--}}
                                {{--<a href="/like/user?income=1">--}}
                                    {{--<i class="icon-basket"></i>喜欢值得买 </a>--}}
                            {{--</li>--}}
                            <li>
                                <a href="/admin/logout">
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
                    <?php
                    $name = '/'.Request::path();
                    $info = DB::table("node")->where("name",$name)->select("path")->first();
                    if(!empty($info)){
                        $path = explode('_',$info->path);
                        $pid  = $path[1];
                    }else{
                        $tempName = explode("/",$name);
                        if($tempName[2] == 'channelReport'){
                            $pid = '10021';
                        }else if($tempName[2] == 'advReport'){
                            $pid = "10021";
                        }else{
                            $pid = "";
                        }
                    }
                    ?>


                    @foreach(Session::get("adminMenu") as $val)
                        <li class="nav-item  @if($pid == $val["id"])active open @endif">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="{{$val['icon']}}"></i>
                                <span class="title">{{$val['title']}}</span>
                                @if($pid == $val["id"])
                                    <span class="selected"></span>
                                    <span class="arrow open"></span>
                                @else
                                    <span class="arrow"></span>
                                @endif
                            </a>
                            <ul class="sub-menu">
                                @foreach($val['childrens'] as $v)
                                    <li class="nav-item  @if('/'.Request::path() == $v["name"])active open @endif">
                                        <a href="{{$v['name']}}" class="nav-link ">
                                            <span class="title"> {{$v['title']}}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach





                    {{--<li class="nav-item  active open">--}}
                    {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                    {{--<i class="icon-puzzle"></i>--}}
                    {{--<span class="title">Components</span>--}}
                    {{--<span class="selected"></span>--}}
                    {{--<span class="arrow open"></span>--}}
                    {{--</a>--}}
                    {{--<ul class="sub-menu">--}}
                    {{--<li class="nav-item  active open">--}}
                    {{--<a href="components_date_time_pickers.html" class="nav-link ">--}}
                    {{--<span class="title">Date &amp; Time Pickers</span>--}}
                    {{--<span class="selected"></span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item  ">--}}
                    {{--<a href="components_color_pickers.html" class="nav-link ">--}}
                    {{--<span class="title">Color Pickers</span>--}}
                    {{--<span class="badge badge-danger">2</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}

                    {{--<li class="nav-item  ">--}}
                    {{--<a href="components_bootstrap_select_splitter.html" class="nav-link ">--}}
                    {{--<span class="title">Select Splitter</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item  ">--}}
                    {{--<a href="components_clipboard.html" class="nav-link ">--}}
                    {{--<span class="title">Clipboard</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item  ">--}}
                    {{--<a href="components_typeahead.html" class="nav-link ">--}}
                    {{--<span class="title">Typeahead Autocomplete</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}


                    {{--</ul>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item ">--}}
                    {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                    {{--<i class="icon-settings"></i>--}}
                    {{--<span class="title">网站管理</span>--}}
                    {{--<span class="arrow"></span>--}}
                    {{--</a>--}}
                    {{--<ul class="sub-menu">--}}
                    {{--<li class="nav-item  ">--}}
                    {{--<a href="/admin/power" class="nav-link ">--}}
                    {{--<span class="title">栏目管理</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item  ">--}}
                    {{--<a href="/admin/role" class="nav-link ">--}}
                    {{--<span class="title">角色管理</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item  ">--}}
                    {{--<a href="/admin/admin" class="nav-link ">--}}
                    {{--<span class="title">管理员管理</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item  ">--}}
                    {{--<a href="ui_colors.html" class="nav-link ">--}}
                    {{--<span class="title">网站配置</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item  ">--}}
                    {{--<a href="javascript:;" class="nav-link nav-toggle">--}}
                    {{--<span class="title">Datatables</span>--}}
                    {{--<span class="arrow"></span>--}}
                    {{--</a>--}}
                    {{--<ul class="sub-menu">--}}
                    {{--<li class="nav-item ">--}}
                    {{--<a href="table_datatables_managed.html" class="nav-link "> Managed Datatables </a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item ">--}}
                    {{--<a href="table_datatables_buttons.html" class="nav-link "> Buttons Extension </a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item ">--}}
                    {{--<a href="table_datatables_colreorder.html" class="nav-link "> Colreorder Extension </a>--}}
                    {{--</li>--}}
                    {{--<li class="nav-item ">--}}
                    {{--<a href="table_datatables_rowreorder.html" class="nav-link "> Rowreorder Extension </a>--}}
                    {{--</li>--}}

                    {{--</ul>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--</li>--}}
                    {{--<!--菜单开始结束-->--}}
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
                            <a href="/admin/admin">首页</a>
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
        <div class="page-footer-inner"> <?php echo date('Y');?> &copy; 北京微赢互动科技有限公司
            {{--<a target="_blank" href="http://keenthemes.com">Keenthemes</a> &nbsp;|&nbsp;--}}
            {{--<a href="http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" title="Purchase Metronic just for 27$ and get lifetime updates for free" target="_blank">Purchase Metronic!</a>--}}
        </div>
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