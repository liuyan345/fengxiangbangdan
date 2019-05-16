{{--
auther 刘岩
用户角色页面
--}}
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

@section('title','角色管理')

@section('content')
    <div class="portlet-body">
        <input type="hidden" id="dataTableUrl" value="/admin/role/datalist">
        <div class="portlet light ">
            <div id="#table_reload" style="display: none"></div>
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">角色管理 </span>
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
                <div class="portlet-body col-md-12">
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_orders">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="7%">ID</th>
                            <th width="10%">角色名称</th>
                            <th width="12%">描述</th>
                            <th width="41%">角色权限</th>
                            <th width="20%">添加时间</th>
                            <th width="10%">操作</th>
                        </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div id="stack1" class="modal fade" tabindex="-1">
            <div class="modal-dialog" style="width: 680px;">
                <div class="modal-content" style="overflow: auto;height:400px;border-radius: 0px;">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title"><i class="fa fa-edit"></i>&nbsp;<span id="form-title"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="#" class="form-horizontal" id="data_form">

                                <div class="portlet-body col-md-6">
                                    <div class="form-body">
                                        <input type="hidden" name="id" id="form_id">
                                        <input type="hidden" name="power" id="form_power">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">角色名称</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="name" placeholder="例：商务分组">
                                                <span class="help-block">（用于后台用户权限划分） </span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">角色描述</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" rows="3" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="portlet-body col-md-6">
                                    <div class="cata">页面+功能</div>
                                    <div id="tree_1" class="tree-demo"> </div>
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
    <script src="{{asset('/style_js/cpcAdmin/scripts/role.js')}}" type="text/javascript"></script>
@stop

@section('page_javascript')
    <script>
        // 重复提交标识变量
        var check = true;
        //页面提交地址
        var url;

        //新增框初始化 设置url
        function add(pid){
            $("#detail_div").html('');
            $("#form-title").html("新增菜单");
            var _token = "{{csrf_token()}}";
            var datas = '{id:"","name":"","description":"","power":"","_token":"'+_token+'"}';
            var datas = eval('('+datas+')');
            fillField('data_form',datas);
            $("#tree_1").jstree().destroy();
            UITree.init();
            $("#stack1").modal("show");
            url = '/admin/role';
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
        function edit(id){
            $.get('/admin/role/edit/'+id,function(data){
                $('#data_form')[0].reset();
                $("#form-title").html("编辑角色");
                fillField('data_form',data);
                $("#data_form").find("input[name='_token']").val("{{csrf_token()}}");
                var power = $("#form_power").val();
                $("#tree_1").jstree().destroy(); //销毁
                UITree.init(); //重新初始化
                $("#stack1").modal("show");
                url = '/admin/role/update/'+id;
            },'json')
        }

        //绑定提交事件
        function BindEvent() {
            var power = $("#tree_1").jstree('get_selected').join(',');
            $("#form_power").val(power);
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
                    $.post("/admin/role/delete/"+id,{'_token':"{{csrf_token()}}"}, function (data) {
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