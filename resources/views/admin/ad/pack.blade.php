@extends('admin.public')
@section('style')
    <link href="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
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
        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
            width: 294px;
            border: 1px #c2cad8 solid;
            border-radius: 3px;
        }
        .select2-dropdown{
            width:294px;
        }
    </style>
@stop
@section('ptitle','广告管理')

@section('title','渠道包列表')

@section('content')
    <div class="portlet-body">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">渠道包列表 </span>
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        <label class="btn btn-transparent green btn-outline btn-outline btn-sm active" onclick="add()">
                            <input type="radio" name="options" class="toggle" >新增
                        </label>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <div class="table-actions-wrapper">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;" placeholder="广告名称" id="ad_name">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;" placeholder="广告公司" id="ad_company">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;" placeholder="渠道包名" id="pack_name">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;" placeholder="渠道公司" id="channel_company">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;" placeholder="渠道名称" id="channel_name">
                        <select class="bs-select form-control" id="ad_type" style="margin-right: 8px;width:118px;float: left">
                            <option value="">广告类型</option>
                            <option value="1">ios</option>
                            <option value="2">android</option>
                        </select>
                        <select class="bs-select form-control" id="status" style="margin-right: 8px;width:118px;float: left">
                            <option value="">渠道包状态</option>
                            <option value="1">正常</option>
                            <option value="2">禁用</option>
                        </select>
                        <button class="btn btn-sm btn-default table-group-action-submit"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_orders">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">ID</th>
                            <th width="10%">渠道包名</th>
                            <th width="7%">广告名称</th>
                            <th width="7%">广告公司</th>
                            <th width="7%">广告类型</th>
                            <th width="10%">渠道名称</th>
                            <th width="10%">渠道公司</th>
                            <th width="10%">单价</th>
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
                                    <label class="col-md-3 control-label">所属广告</label>
                                    <div class="col-md-6">
                                        <select class="js-example-basic-single form-control" name="ad_id">
                                            <option value="">-请选择-</option>
                                            @foreach($adInfo as $k=>$v)
                                                <option value="{{$k}}">{{$v}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">渠道包名</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="pack_name" placeholder="渠道包名">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">所属渠道</label>
                                    <div class="col-md-6">
                                        <select class="js-example-basic-single form-control" name="channel_id">
                                            <option value="">-请选择-</option>
                                            @foreach($channelInfo as $k1=>$v1)
                                                <option value="{{$k1}}">{{$v1}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">单价</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="price" placeholder="单位：元">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
@stop

@section('page_javascript')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({"width":294});
            $('.js-example-basic-single').on("select2:select",function(e){
                var value = $(this).select2("val");
                var text = $(this).select2("data").text;
                console.log(value,text);
            });
        });
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



        var EcommerceOrders = function () {

            var handleOrders = function () {
                var grid = new Datatable();
                grid.init({
                    src: $("#datatable_orders"),
                    onSuccess: function (grid) {
                    },
                    onError: function (grid) {
                        // execute some code on network or other general error
                    },
                    loadingMessage: 'Loading...',
                    dataTable: {
                        "dom": "<'row'<'col-md-12 col-sm-12'<'table-group-actions pull-left'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                        "lengthMenu": [
                            [10, 20, 50, 100, 150],
                            [10, 20, 50, 100, 150] // change per page values here
                        ],
                        "sAjaxDataProp" : "data",
                        "pageLength": 10, // default record count per page
                        "ajax": {
                            "url": "/admin/pack/datalist", // ajax source
                            "type": "POST",
                            "data": function (d) {
                                d._token = "{{csrf_token()}}";
                                d.ad_name = $("#ad_name").val();
                                d.ad_type = $("#ad_type").val();
                                d.ad_company = $("#ad_company").val();
                                d.channel_name = $("#channel_name").val();
                                d.channel_company = $("#channel_company").val();
                                d.status = $("#status").val();
                                d.pack_name = $("#pack_name").val();
                            }
                        },
                        'sort': false,
                        "sPaginationType": "full_numbers",      //翻页界面类型
                        "oLanguage": {                          //汉化
                            "sLengthMenu": "每页显示 _MENU_ 条记录",
                            "sZeroRecords": "没有检索到数据",
                            "sInfo": "当前数据为从第 _START_ 到第 _END_ 条数据；总共有 _TOTAL_ 条记录",
                            "sInfoEmtpy": "没有数据",
                            "sProcessing": "正在加载数据...",
                            "oPaginate": {
                                "sFirst": "首页",
                                "sPrevious": "前页",
                                "sNext": "后页",
                                "sLast": "尾页"
                            }
                        },
                        'aoColumns':[
                            {'mData':'id'},
                            {'mData':'pack_name'},
                            {'mData':'ad_name'},
                            {'mData':'ad_company'},
                            {'mData':function(lineData){
                                if(lineData.ad_type == 1){
                                    return "ios";
                                }else if(lineData.ad_type == 2){
                                    return "android"
                                }
                            }},
                            {'mData':'channel_name'},
                            {'mData':'channel_company'},
                            {'mData':'price'},
                            {'mData':function(lineData){
                                if(lineData.status == 1){
                                    return "<span style='color:green'>正常</span>";
                                }else if(lineData.status == 2){
                                    return "<span style='color:red'>禁用</span>";
                                }
                            }},
                            { "mData": function(lineData){
                                var id = lineData.id;
                                var del = '<button  class="btn btn-sm btn-danger" onclick="del(\''+id+'\')">删除<i class="icon-minus"></i></button>';
                                var edit = '<button  class="btn btn-sm btn-info" onclick="edit(\''+id+'\')">编辑<i class="icon-minus"></i></button>';
                                return del +" " +edit;
                            } }
                        ],

                        "aoColumnDefs": [
                            {
                                'orderable': false,
                                'targets': '_all'
                            }
                        ],
                    }
                });
                grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
                    //自己定义的搜索框，可以是时间控件，或者checkbox 等等
                    grid.getDataTable().ajax.reload();
                });
            }

            return {

                init: function () {
                    handleOrders();
                }

            };

        }();

        if (App.isAngularJsApp() === false) {
            jQuery(document).ready(function() {
                EcommerceOrders.init();
            });
        }


        function add(pid){
            $("#data_form").find("input[name='pack_name']").removeAttr("disabled");
            $("#data_form").find("select[name='channel_id']").removeAttr("disabled");
            $("#data_form").find("select[name='ad_id']").removeAttr("disabled");
            $("#form-title").html("新增菜单");
            var _token = "{{csrf_token()}}";
            var datas = '{"ad_id":"","channel_id":"","pack_name":"","status":"1","price":"0","_token":"'+_token+'"}';
            var datas = eval('('+datas+')');
            fillField('data_form',datas);     //自定义的表单数据填充函数
            $("#stack1").modal("show");
            url = '/admin/pack';
        }

        //编辑框初始化 设置url
        function edit(id){
            $.get('/admin/pack/edit/'+id,function(data){
                $('#data_form')[0].reset()
                $("#form-title").html("编辑");
                fillField('data_form',data);
                $("#data_form").find("input[name='pack_name']").attr("disabled","disabled");
                $("#data_form").find("select[name='channel_id']").attr("disabled","disabled");
                $("#data_form").find("select[name='ad_id']").attr("disabled","disabled");
                $("#data_form").find("input[name='_token']").val('{{csrf_token()}}');
                $("#stack1").modal("show");
                url = '/admin/pack/update/'+id;
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
            $('#'+form).find("input[type='password']").each(function(){
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

        //删除数据方法
        function del(id){
            swal({
                title: "警示",
                text: "您确认要删除本条数据吗？删除后影响数据录入",
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
                    $.post("/admin/pack/delete/"+id,{'_token':"{{csrf_token()}}"}, function (data) {
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