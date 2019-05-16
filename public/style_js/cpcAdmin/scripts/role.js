var EcommerceOrders = function () {
    var initPickers = function () {
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
    }

    var handleOrders = function () {
        var grid = new Datatable();
        var url = $("#dataTableUrl").val();
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
                    "url": url, // ajax source
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
                    {'mData':'name'},
                    {'mData':'description'},
                    {'mData':'powername'},
                    {'mData':'created_at'},
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

    }


    return {
        //main function to initiate the module
        init: function () {
            initPickers();
            handleOrders();
        }

    };

}();


var UITree = function () {
    var ajaxTreeSample = function() {
        var power = $("#form_power").val();
        $("#tree_1").jstree({
            'plugins': ["wholerow", "checkbox", "types"],
            'core': {
                "themes" : {
                    "responsive": false
                },
                'data' : {
                    'url' : function (node) {
                        return '/admin/role/tree?power='+power;
                    },
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder icon-state-warning icon-lg"
                },
                "file" : {
                    "icon" : "fa fa-file icon-state-warning icon-lg"
                }
            }
        });
    }

    // $("#tree_1").on("activate_node.jstree",function(e,data){
    //     var id = data.node.id;
    //     var tableUrl = $("#dataTableUrl").val();
    //     if(tableUrl.indexOf('?')>0){
    //         $("#dataTableUrl").val(tableUrl.split('?')[0]+'?id='+id);
    //     }else{
    //         $("#dataTableUrl").val(tableUrl+'?id='+id);
    //     }
    //
    //     $("#datatable_orders").DataTable().destroy();
    //
    // })

    return {
        init: function () {
            ajaxTreeSample();
        }
    };
}();




if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        UITree.init();
        EcommerceOrders.init();
    });
}