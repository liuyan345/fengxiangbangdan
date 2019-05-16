{{--auther 刘岩   后台菜单功能显示模板--}}
@extends('admin.public')
@section('style')
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/icheck/skins/all.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/jstree/dist/themes/default/style.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .detailPower{
            float:left;
            margin: 0px 5px 3px 0px;
            width: 119px;
        }
    </style>

@stop
@section('ptitle','网站设置')

@section('title','栏目管理')

@section('content')
    <div class="portlet-body">
        <input type="hidden" id="dataTableUrl" value="/admin/power/table">
        <div class="portlet light ">
            <div id="#table_reload" style="display: none"></div>
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">栏目管理 </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <label class="btn btn-transparent green btn-outline btn-outline btn-sm active" onclick="add(0)">
                            <input type="radio" name="options" class="toggle" >新增
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="portlet-body col-md-3">
                    <div class="cata">目录</div>
                    <div id="tree_1" class="tree-demo"> </div>
                </div>
                <div class="portlet-body col-md-9">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_orders">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="10%">ID</th>
                            <th width="15%">栏目名称</th>
                            <th width="15%">url</th>
                            <th width="7%">排序</th>
                            <th width="27%">添加时间</th>
                            <th width="26%">操作</th>
                        </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div id="stack1" class="modal fade" tabindex="-1" data-width="400">
            <div class="modal-dialog">
                <div class="modal-content" style="overflow: auto;border-radius: 0px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;<span id="form-title"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="#" class="form-horizontal" id="data_form">
                                <div class="form-body">
                                    <input type="hidden" name="pid" id="form_pid">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">菜单名称</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="title" placeholder="例：网站配置">
                                            <span class="help-block">（用于后台显示的菜单名称） </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">路由地址</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name" placeholder="例：/admin/login">
                                            <span class="help-block">（跳转链接） </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">icon</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="icon" placeholder="例：icon-settings">
                                            <span class="help-block">（主菜单图标） </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">排序</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="sort" placeholder="例：99">
                                            <span class="help-block">（值越大越靠前） </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">权限细分</label>
                                        <div class="col-md-6">
                                            <a href="javascript:void(0);" data-repeater-create="" class="btn btn-success mt-repeater-add" onclick="add_power()">
                                                <i class="fa fa-plus" ></i> 添加</a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"></label>
                                        <div class="col-md-6" id="detail_div">
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

    </div>
@stop

@section('javascript')
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/icheck/icheck.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/jstree/dist/jstree.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/scripts/power.js?time='.time())}}" type="text/javascript"></script>
@stop

@section('page_javascript')
    <script>
        // 重复提交标识变量
        var check = true;
        //页面提交地址
        var url;

        //增加细分权限
        function add_power(){
            var str = '<div class="input-group detailPower"><input type="text" name="smallpower[]" class="form-control"><span class="input-group-addon" onclick="detail_close(event)"> <i class="fa fa-close"></i> </span></div>';
            $("#detail_div").append(str);
        }

        //删除细分权限
        function detail_close(e){
            var that = $(e.target);
            that.parents('.detailPower').remove();
        }

        //新增框初始化 设置url
        function add(pid){
            $("#detail_div").html('');
            $("#form-title").html("新增菜单");
            var _token = "{{csrf_token()}}";
            var datas = '{"pid":"'+pid+'","name":"","title":"","icon":"","sort":"","_token":"'+_token+'"}';
            var datas = eval('('+datas+')');
            fillField('data_form',datas);
            $("#stack1").modal("show");
            url = '/admin/power/store';
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

        //编辑框初始化 设置url
        function edit(id,pid){
            $("#detail_div").html('');
            $.get('/admin/power/edit/'+id,function(data){

                $('#data_form')[0].reset();
                $("#form-title").html("编辑菜单");
                fillField('data_form',data);
                $("#data_form").find("input[name='_token']").val("{{csrf_token()}}");
                if(data.smallpower){
                    var smallpower = eval('(' + data.smallpower + ')');
                    if(smallpower.length>0){
                        for(var i=0;i<smallpower.length;i++){
                            var str = '<div class="input-group detailPower"><input type="text" name="smallpower[]" class="form-control" value="'+smallpower[i]+'"><span class="input-group-addon" onclick="detail_close(event)"> <i class="fa fa-close"></i> </span></div>';
                            $("#detail_div").append(str);
                        }
                    }
                }else{
                    $("#detail_div").html('');
                }


                $("#stack1").modal("show");
                url = '/admin/power/update/'+id;
            },'json')
        }

        //绑定提交事件
        function BindEvent() {
            if(check){
                check = false;
                var postData = $("#data_form").serializeArray();
                $.post(url, postData, function (data) {
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
                        window.location.reload(true)
//                        $("#datatable_orders").DataTable().ajax.reload(); //刷新数据
//                        $("#tree_1").jstree().refresh(); //刷新数据

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
                    $.post("/admin/power/delete/"+id,{'_token':"{{csrf_token()}}"}, function (data) {
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
                            window.location.reload(true)
//                            $("#datatable_orders").DataTable().ajax.reload();
//                            $("#tree_1").jstree().refresh(); //刷新数据
                        }else {
                            toastr.warning(data.msg, "提示")
                        }
                    },'json')
                }
            });
        }

    </script>
@stop
