<!DOCTYPE html>
{{--auther 刘岩   后台登录显示模板--}}
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>后台登录</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="liuyan" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/style_js/cpcAdmin/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('/style_js/cpcAdmin/assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('/style_js/cpcAdmin/assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ asset('/style_js/cpcAdmin/assets/pages/css/login.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="/admin/login"> <img src="{{ asset('/img/logo-big1.png')}}" alt="" /> </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="/home/login" method="post">
        <h3 class="form-title font-green">欢迎渠道商登录</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Enter any username and password. </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">用户名</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="用户名" name="admin_name" /> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">密码</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="密码" name="passwd" /> </div>
        <div class="form-actions">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn green uppercase" id="form_submit">登录</button>
            {{--<label class="rememberme check mt-checkbox mt-checkbox-outline">--}}
                {{--<input type="checkbox" name="remember" value="1" />记住我--}}
                {{--<span></span>--}}
            {{--</label>--}}
            {{--<a href="javascript:;" id="forget-password" class="forget-password">忘记密码?</a>--}}
        </div>
        {{--<div class="login-options">--}}
            {{--<h4>Or login with</h4>--}}
            {{--<ul class="social-icons">--}}
                {{--<li>--}}
                    {{--<a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}

    </form>

</div>
{{--<div class="copyright"> <?php echo date('Y');?> © </div>--}}
<!--[if lt IE 9]>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/respond.min.js')}}"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/excanvas.min.js')}}"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/ie8.fix.min.js')}}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-toastr/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/style_js/cpcAdmin/assets/pages/scripts/ui-toastr.min.js')}}" type="text/javascript"></script>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{asset('/style_js/cpcAdmin/assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
<script>

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-center",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    @if (Session::has('message'))
        toastr.warning('{{Session::get('message')['content']}}', "提示")
    @endif

$("body").keydown(function(){
        //keyCode=13是回车键
        if (event.keyCode == "13") {
            $("#form_submit").click();
        }
    })
</script>
</body>

</html>