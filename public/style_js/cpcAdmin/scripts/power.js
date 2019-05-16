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

                "paging":false,
                "dom": "t",
                "sAjaxDataProp" : "data",
                "ordering":false,
                "ajax": {
                    "type":'post',
                    "url": url, // ajax source
                },
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
                    {'mData':'title'},
                    {'mData':'name'},
                    {'mData':'sort'},
                    {'mData':'created_at'},
                    { "mData": function(lineData){
                        var id = lineData.id;
                        var del = '<button  class="btn btn-sm btn-danger" onclick="del(\''+id+'\')">删除<i class="icon-minus"></i></button>';
                        var edit = '<button  class="btn btn-sm btn-info" onclick="edit(\''+id+'\',\''+lineData.pid+'\')">编辑<i class="icon-minus"></i></button>';
                        var add = '<button  class="btn btn-sm green" onclick="add(\''+id+'\')">新增<i class="icon-minus"></i></button>';
                        return add +" "+del +" " +edit;
                    } }
                ],
                "aoColumnDefs": [
                    {
                        "defaultContent": "",
                        "targets": "_all"
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
        var url = '/admin/power/tree?temp='+Math.random();
        $("#tree_1").jstree({
            "core" : {
                "themes" : {
                    "responsive": false
                },
                // so that create works
                "check_callback" : true,
                'data' : {
                    'url' : function (node) {
                        return url;
                    },
                    'data' : function (node) {
                        return { 'parent' : node.id };
                    }
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder icon-state-warning icon-lg"
                },
                "file" : {
                    "icon" : "fa fa-file icon-state-warning icon-lg"
                }
            },
            "state" : { "key" : "demo3" },
            "plugins" : [ "dnd", "state", "types" ]
        });

    }

    $("#tree_1").on("activate_node.jstree",function(e,data){
        var id = data.node.id;
        var tableUrl = $("#dataTableUrl").val();
        if(tableUrl.indexOf('?')>0){
            $("#dataTableUrl").val(tableUrl.split('?')[0]+'?id='+id);
        }else{
            $("#dataTableUrl").val(tableUrl+'?id='+id);
        }

        $("#datatable_orders").DataTable().destroy();
        EcommerceOrders.init();
    })

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