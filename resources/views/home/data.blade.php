@extends('home.public')
@section('style')
    <link href="{{asset('/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
    <style>
        .search_laber {
            float: left;
            width: 257px;
            margin-right: 20px;
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
        /*粘贴自add.blade.php */
        #datatable_orders tbody tr td a div {
            width:180px;height:90px;border-radius:5px;display: table-cell;vertical-align: middle;text-align: center;
            background-repeat:no-repeat; background-size:100% 100%;-moz-background-size:100% 100%;
        }

        #datatable_orders tbody tr td a div img {
            width:50px;
            height:50px;
            border-radius: 5px;
        }
        .input-container{
            width: 500px;
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: reverse;
            -ms-flex-flow:column-reverse;
            flex-flow: column-reverse;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            margin: 100px auto;
        }
        .input-container input{
            -webkit-box-ordinal-group: 11;
            order: 10;
            -ms-flex-order: 10;
            outline: none;
            border: none;
            width: 100%;
            padding: 10px 0;
            font-size: 20px;
            border-bottom: 1px solid #d5d5d5;
            text-indent: 10px;
        }
        .checkbox-box{
            display: inline-block;
            width: 15px;
            height: 22px;
            border-radius: 3px;
            border: 2px solid #1aafcc;
            vertical-align: middle;
            position: absolute;
            left: 238px;
            top: 60px;
        }
        .p-one{
            font-size: 18px;
            color: red;
            margin-top: 6px;
        }
    </style>
    {{--<link rel="stylesheet" href="{{asset('/css/bootstrap-datetimepicker.min.css')}}">--}}
@stop
@section('ptitle','数据管理')

@section('title','数据列表')

@section('content')

    <div class="portlet-body">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">数据列表</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <div class="table-actions-wrapper">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;float: left" placeholder="广告名称" id="ad_name">
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;float: left" placeholder="渠道包" id="pack_name">

                        <div class="search_laber">
                            <div class="input-group date form_datetime" data-date=""  data-date-format="yyyy-mm-dd" data-link-format="yyyy-mm-dd" data-link-field="start_time">
                                <input class="form-control" type="text" placeholder="开始日期" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="start_time" name="start_time" value="" />
                        </div>
                        <div class="search_laber">
                            <div class="input-group date form_datetime" data-date=""  data-date-format="yyyy-mm-dd" data-link-format="yyyy-mm-dd" data-link-field="end_time">
                                <input class="form-control"  type="text" placeholder="结束日期" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                            <input type="hidden" id="end_time" name="end_time" value="" />
                        </div>
                            <button class="btn btn-sm btn-default table-group-action-submit"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_orders">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">id</th>
                            <th width="10%">数据日期</th>
                            <th width="7%">渠道名称</th>
                            <th width="7%">广告名称</th>
                            <th width="7%">渠道包</th>
                            <th width="7%">系统</th>
                            <th width="7%">单价</th>
                            <th width="7%">注册数</th>
                            <th width="7%">收益</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->

    </div>
    <!-- end: deduct add -->
    </div>
@stop

@section('javascript')
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/icheck/icheck.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('/datetimepicker/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
    <script type="text/javascript" src="{{asset('/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js')}}" charset="UTF-8"></script>

@stop
@section('page_javascript')
    <script>

        var EcommerceOrders = function () {

            var handleOrders = function () {
                var grid = new Datatable();
                grid.init({
                    src: $("#datatable_orders"),
                    onSuccess: function (grid) {
                        $('.form_datetime').datetimepicker({
                            language:  'zh-CN',
                            weekStart: 1,
                            todayBtn:  1,
                            autoclose: 1,
                            todayHighlight: 1,
                            startView: 2,
                            minView: 2,
                            forceParse: 0,
                            setDate: new Date()
                        });
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
                            "url": "/home/datalist", // ajax source
                            "type": "POST",
                            "data": function (d) {
                                d._token = "{{csrf_token()}}";
                                d.ad_name = $("#ad_name").val();
                                d.pack_name = $("#pack_name").val();
                                d.start_time = $("#start_time").val();
                                d.end_time = $("#end_time").val();
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
                            {'mData':'cdate'},
                            {'mData':'channel_name'},
                            {'mData':'ad_name'},
                            {'mData':'pack_name'},
                            {'mData':'type'},
//                            {'mData':function(lineData){
//                                if(lineData.status == 1){
//                                    return "<span style='color:green'>上架</span>";
//                                }else if(lineData.status == 2){
//                                    return "<span style='color:red'>下架</span>";
//                                }
//                            }},
                            {'mData':'price'},
                            {'mData':'data'},
                            {'mData':'money'},
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



    </script>

@stop