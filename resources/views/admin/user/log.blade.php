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

@section('title','用户场次列表')

@section('content')
    <div class="portlet-body">
        <!-- Begin: life time stats -->
        <div class="portlet light portlet-fit portlet-datatable ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">用户场次列表 </span>
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
                        <input type="text" class="form-control input-inline" style="margin-right: 8px;" placeholder="场次名称" id="title">
                        <select class="bs-select form-control" id="type" style="margin-right: 8px;width:118px;float: left">
                            <option value="">场次类型</option>
                            <option value="1">大乱斗</option>
                            <option value="2">红包</option>
                        </select>
                        <select class="bs-select form-control" id="is_finish" style="margin-right: 8px;width:118px;float: left">
                            <option value="">是否完成</option>
                            <option value="1">完成</option>
                            <option value="0">未完成</option>
                        </select>
                        <button class="btn btn-sm btn-default table-group-action-submit"><i class="fa fa-search"></i> 搜索</button>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_orders">
                        <thead>
                        <tr role="row" class="heading">
                            <th width="5%">ID</th>
                            <th width="5%">UID</th>
                            <th width="7%">用户昵称</th>
                            <th width="15%">参与场次</th>
                            <th width="7%">场次类型</th>
                            <th width="7%">是否完成</th>
                            <th width="7%">本场分成</th>
                            <th width="7%">本场是否终止</th>
                            <th width="10%">参与时间</th>
                        </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>

@stop

@section('javascript')

    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/assets/pages/scripts/table-datatables-editable.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/style_js/cpcAdmin/scripts/userlog.js')}}" type="text/javascript"></script>

@stop

@section('page_javascript')
    <script>

    </script>

@stop