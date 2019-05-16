@extends('admin.public')
@section('style')
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <style>
        .search_laber {
            float: left;
        }

        .search_header {
            float: left;
        }

        .table > tbody > tr > td {
            text-align: center;

        }

        /* dataTables表头居中 */
        .table > thead:first-child > tr:first-child > th {
            text-align: center;
        }

        .form-time {
            float: left;
            margin-right: 6px;
        }

        .label {
            color: #00a2d4;
        }

        #datatable_orders tbody tr td a div {
            width:180px;height:90px;border-radius:5px;display: table-cell;vertical-align: middle;text-align: center;
            background-repeat:no-repeat; background-size:100% 100%;-moz-background-size:100% 100%;
        }

        #datatable_orders tbody tr td a div img {
            width:50px;
            height:50px;
            border-radius: 5px;
        }
    </style>
@stop
@section('ptitle','用户管理')

@section('title','用户列表')

@section('content')
    <div class="portlet-body">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">用户列表 </span>
                </div>
                {{--<div class="actions">--}}
                    {{--<div class="btn-group btn-group-devided" data-toggle="buttons">--}}
                        {{--<label class="btn btn-transparent green btn-outline btn-outline btn-sm active" id="option1">--}}
                            {{--<input type="radio" name="options" class="toggle" >新增--}}
                        {{--</label>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <div class="table-actions-wrapper">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;" placeholder="用户昵称" id="nickName">
                        <select class="bs-select form-control" id="status" style="margin-right: 8px;width:118px;float: left">
                            <option value="">状态</option>
                            <option value="1">正常</option>
                            <option value="2">禁用</option>
                        </select>
                        <button class="btn btn-sm btn-default table-group-action-submit"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_orders">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">ID</th>
                            <th width="7%">用户昵称</th>
                            <th width="10%">用户头像</th>
                            <th width="7%">状态</th>
                            <th width="10%">操作</th>
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
                                    <label class="col-md-3 control-label">用户昵称</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="nickName" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">用户性别</label>
                                    <div class="col-md-6">
                                        <input type="radio" name="gender" value="1"> 男
                                        <input type="radio" name="gender" value="2"> 女
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">用户省份</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="province" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">状态</label>
                                    <div class="col-md-6">
                                        <select name="status" class="form-control">
                                            <option value="">-请选择-</option>
                                            <option value="1">正常</option>
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
    <script src="{{asset('/style_js/cpcAdmin/scripts/user.js')}}" type="text/javascript"></script>

@stop

@section('page_javascript')
    <script>
        var url;
        var check = true;
        var toastr = {};
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
        };



        //编辑框初始化 设置url
        function edit(id){
            $.get('/admin/user/edit/'+id,function(data){
                $('#data_form')[0].reset()
                $("#form-title").html("编辑");
                fillField('data_form',data);
                $("#data_form").find("input[name='_token']").val('{{csrf_token()}}');
                $("#stack1").modal("show");
                url = '/admin/user/update/'+id;
            },'json')
        }

        //绑定提交事件
        function BindEvent() {
            var postData = $("#data_form").serializeArray();
            App.blockUI({
                target: '.modal-dialog',
                animate: true
            });
            if (check) {
                check = false;
                $.post(url, postData, function (data) {
                    App.unblockUI('.modal-dialog');
                    check = true;
                    if (data.success) {
                        $("#stack1").modal("hide");
                        toastr.success(data.msg, "提示")
                        $("#datatable_orders").DataTable().ajax.reload(null, false); //刷新数据
                    } else {
                        toastr.warning(data.msg, "提示")
                    }

                }, 'json')
            } else {
                toastr.warning('正在提交请稍后！', "提示")
            }
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


        //验证必选项
        function verify(required, postData) {
            var length = postData.length;
            for (var i = 0; i < length; i++) {
                var l = required.length;
                for (var j = 0; j < l; j++) {
                    if ((postData[i]['name'] == required[j]) && (postData[i]['value'] == "")) {
                        return false;
                    }
                }
            }
            return true;
        }

        {{--//删除数据方法--}}
        {{--function del(id){--}}
            {{--swal({--}}
                {{--title: "警示",--}}
                {{--text: "您确认要删除本条数据吗？",--}}
                {{--type: "warning",--}}
                {{--showCancelButton: true,--}}
                {{--confirmButtonColor: "#ea5460",--}}
                {{--cancelButtonText: "取消",--}}
                {{--confirmButtonText: "执行删除！",--}}
                {{--confirmButtonClass:"btn-danger",--}}
                {{--closeOnConfirm: true--}}
            {{--}, function (r) {--}}
                {{--//判断是否正在删除--}}
                {{--if(r){--}}
                    {{--$.post("/admin/daily_times/delete/"+id,{'_token':"{{csrf_token()}}"}, function (data) {--}}
                        {{--toastr.options = {--}}
                            {{--"closeButton": true,--}}
                            {{--"debug": false,--}}
                            {{--"positionClass": "toast-top-center",--}}
                            {{--"onclick": null,--}}
                            {{--"showDuration": "1000",--}}
                            {{--"hideDuration": "1000",--}}
                            {{--"timeOut": "5000",--}}
                            {{--"extendedTimeOut": "1000",--}}
                            {{--"showEasing": "swing",--}}
                            {{--"hideEasing": "linear",--}}
                            {{--"showMethod": "fadeIn",--}}
                            {{--"hideMethod": "fadeOut"--}}
                        {{--}--}}
                        {{--if (data.success) {--}}
                            {{--toastr.success(data.msg, "提示")--}}
                            {{--$("#datatable_orders").DataTable().ajax.reload();--}}
                        {{--}else {--}}
                            {{--toastr.warning(data.msg, "提示")--}}
                        {{--}--}}
                    {{--},'json')--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}

    </script>

@stop