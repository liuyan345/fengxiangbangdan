{{--
auther 刘岩
后台管理员页面
--}}
@extends('admin.public')
@section('style')
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .search_laber{
            float: left;
        }
        .search_header{
            float: left;
        }
    </style>
@stop
@section('ptitle','网站管理')

@section('title','管理员管理')

@section('content')
    <div class="portlet-body">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">管理员管理 </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <label class="btn btn-transparent green btn-outline btn-outline btn-sm active" id="option1">
                            <input type="radio" name="options" class="toggle" >新增
                        </label>
                    </div>
                    {{--<div class="btn-group">--}}
                        {{--<a class="btn red btn-outline btn-circle" href="javascript:;" data-toggle="dropdown">--}}
                            {{--<i class="fa fa-share"></i>--}}
                            {{--<span class="hidden-xs"> 工具 </span>--}}
                            {{--<i class="fa fa-angle-down"></i>--}}
                        {{--</a>--}}
                        {{--<ul class="dropdown-menu pull-right">--}}
                            {{--<li>--}}
                                {{--<a href="javascript:;"> 导出Excel </a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <div class="table-actions-wrapper">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;" placeholder="真实姓名" id="input1">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;" placeholder="账号名" id="input2">
                        <select class="bs-select form-control" id="input3" style="margin-right: 8px;width:118px;float: left">
                            <option value="">用户角色</option>
                            @foreach($role as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                        {{--<div class="search_header">--}}
                            {{--<span class="search_laber">真实姓名：</span>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<span class="search_laber">账号名：</span>--}}
                        {{--</div>--}}
                        {{--<div>--}}
                            {{--<span class="search_laber">用户角色：</span><select class="bs-select form-control" id="input3" style="margin-right: 8px;width:118px;float: left">--}}
                                {{--<option value="">用户角色</option>--}}
                                {{--<option value="1">是</option>--}}
                                {{--<option value="0">否</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        <button class="btn btn-sm btn-default table-group-action-submit"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_orders">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">ID</th>
                            <th width="10%">登录账户</th>
                            <th width="10%">真实名称</th>
                            <th width="10%">用户角色</th>
                            <th width="10%">手机号</th>
                            <th width="10%">QQ</th>
                            <th width="10%">最后登录时间</th>
                            <th width="10%">最后登录ip</th>
                            <th width="10%">账户状态</th>
                            <th width="15%">操作</th>
                        </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
    <div id="stack1" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width: 680px;">
            <div class="modal-content" style="overflow: auto;border-radius: 0px;">{{--height:550px;--}}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;<span id="form-title"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form action="#" class="form-horizontal" id="data_form">
                            <div class="form-body">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">用户角色</label>
                                    <div class="col-md-6">
                                        <select name="role_id" class="form-control">
                                            <option value="">-请选择-</option>
                                            @foreach($role as $k=>$v)
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endforeach

                                        </select>
                                        <span class="help-block">（管理员隶属于那一个权限组） </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">账户名</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="admin_name" placeholder="例：xiaofei">
                                        <span class="help-block">（用于登录后台的账号） </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">密码</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="passwd" placeholder="例：123456" id="aaaa">
                                        <span class="help-block">（用于登录后台的密码） </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">真实名称</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="nick_name" placeholder="例：李世民">
                                        <span class="help-block">（管理员的真实名称） </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">手机号</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="mobile" placeholder="例：18689692210" maxlength="11">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">QQ号</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="qq" placeholder="例：1234">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">账户状态</label>
                                    <div class="col-md-6">
                                        <select name="status" class="form-control">
                                            <option value="">-请选择-</option>
                                            <option value="1">启用</option>
                                            <option value="2">禁用</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="form-actions top">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <span type="submit" class="btn green" onclick="BindEvent()">提交</span>
                                        <button type="button" data-dismiss="modal" class="btn default">取消</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')

    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/pages/scripts/table-datatables-editable.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/scripts/admin.js')}}" type="text/javascript"></script>
@stop

@section('page_javascript')
    <script>
        var url;
        var check = true;

//        $("#aaaa").click(function(){
//            console.log(22222);
//        })

        //新增框初始化 设置url
        $("#option1").click(function(){
            $('#data_form')[0].reset();
            $("#form-title").html("新增");
            $("#stack1").modal("show");
            var data = '{"role_id":"","admin_name":"","nick_name":"","passwd":"","mobile":"","qq":"","status":"1","_token":"{{csrf_token()}}"}';
            data = eval('('+data+')');
            fillField('data_form',data);
            url = '/admin/admin';
        })

        //编辑框初始化 设置url
        function edit(id){
            $.get('/admin/admin/edit/'+id,function(data){
                $('#data_form')[0].reset()
                $("#form-title").html("编辑");
                fillField('data_form',data);
                $("#data_form").find("input[name='_token']").val('{{csrf_token()}}');
                $("#stack1").modal("show");
                url = '/admin/admin/update/'+id;
            },'json')
        }
        //自定义的表单数据填充函数
        function fillField(form,data){
            $('#'+form).find("input[type='text']").each(function(){
                var field = $(this).attr('name');
                $(this).val(data[field]);
            })

            $('#'+form).find("input[type='hidden']").each(function(){
                var field = $(this).attr('name');
                $(this).val(data[field]);
            })

            $('#'+form).find("input[type='radio']").each(function(){
                var val = $(this).val()
                var field = $(this).attr('name');
                if(data[field] == val){
                    $(this).attr('checked',true);
                    $(this).parent().addClass('checked');
                }else{
                    $(this).attr('checked',false);
                    $(this).parent().removeClass('checked');
                }
            })

            $('#'+form).find("input[type='checkbox']").each(function(){
                var val   = $(this).val()
                var field = $(this).attr('name').split('[]')[0];
                var flags = false;

                for(var j=0;j<data[field].length;j++){
                    if(data[field][j] == val){
                        flags = true;
                    }
                }

                if(flags){
                    $(this).attr('checked',true);
                    $(this).parent().addClass('checked');
                }else{
                    $(this).attr('checked',false);
                    $(this).parent().removeClass('checked');
                }

            })

            $('#'+form).find("select").each(function(){
                var content = $(this).html();
                content = content.replace(/selected=\"selected\"/, "")
                var field = $(this).attr('name');
                if(data[field]){
                    var str = 'value="'+data[field]+'"';
                    content = content.replace(str,str+' selected="selected"');
                }
                $(this).html(content);
            })
            $('#'+form).find("textarea").each(function(){
                var field = $(this).attr('name');
                $(this).val(data[field]);
            })
        }

        //绑定提交事件
        function BindEvent() {
            App.blockUI({
                target: '.modal-dialog',
                animate: true
            });
            if(check){
                check = false;
                var postData = $("#data_form").serializeArray();
                $.post(url, postData, function (data) {
                    App.unblockUI('.modal-dialog');
                    check = true;
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
                    if (data.success) {
                        $("#stack1").modal("hide");
                        toastr.success(data.msg, "提示")
                        $("#datatable_orders").DataTable().ajax.reload(null,false); //刷新数据
                    }else {
                        toastr.warning(data.msg, "提示")
                    }

                },'json')
            }else{
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
                toastr.warning('正在提交请稍后！', "提示")
            }

        }

        //删除数据方法
        function del(id){
            swal({
                title: "警示",
                text: "您确认要删除本条数据吗？",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ea5460",
                cancelButtonText: "取消",
                confirmButtonText: "执行删除！",
                confirmButtonClass:"btn-danger",
                closeOnConfirm: true
            }, function (r) {
                //判断是否正在删除
                if(r){
                    $.post("/admin/admin/delete/"+id,{'_token':"{{csrf_token()}}"}, function (data) {
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
                        if (data.success) {
                            toastr.success(data.msg, "提示")
                            $("#datatable_orders").DataTable().ajax.reload();
                        }else {
                            toastr.warning(data.msg, "提示")
                        }
                    },'json')
                }
            });
        }

    </script>

@stop