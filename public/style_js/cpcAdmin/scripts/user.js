
var EcommerceOrders = function () {
    var initPickers = function () {
        //init date pickers

        // $(".form_meridian_datetime").datetimepicker({
        //     language: 'zh-CN',
        //     isRTL: App.isRTL(),
        //     format: "yyyy-mm-dd hh:ii",
        //     showMeridian: false,
        //     autoclose: true,
        //     fontAwesome: true,
        //     setDate:new Date(),
        //     pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
        // });

    }

    var handleOrders = function () {
        var grid = new Datatable();
        grid.init({
            src: $("#datatable_orders"),
            onSuccess: function (grid) {
                // console.log(grid);
                // execute some code after table records loaded
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
                    "url": "/admin/user/datalist", // ajax source
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
                    {'mData':'nickName'},
                    {'mData':function(lineData){
                        return '<img width="50px" src="'+lineData.avatarUrl+'">'
                    }},
                    {'mData':'status'},
                    { "mData": function(lineData){
                        var id = lineData.id;
                        var edit = '<button  class="btn btn-sm btn-info" onclick="edit(\''+id+'\')">编辑<i class="icon-minus"></i></button>';
                        return edit;
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
            var nickName = $("#nickName").val();
            var status = $("#status").val();
            grid.setAjaxParam("nickName", nickName);
            grid.setAjaxParam("status", status);
            grid.getDataTable().ajax.reload();
        });



    }

    return {
        //main function to initiate the module
        init: function () {
            // initPickers();
            handleOrders();
        }

    };

}();


if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        EcommerceOrders.init();
    });
}