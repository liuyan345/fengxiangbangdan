var EcommerceOrders = function () {

    var initPickers = function () {
        //init date pickers
        $('.date-picker').datepicker({
            rtl: App.isRTL(),
            autoclose: true
        });
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
                    "url": '/admin/admin/datalist', // ajax source
                },
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
                    {'mData':'admin_name'},
                    {'mData':'nick_name'},
                    {'mData':'role'},
                    {'mData':'mobile'},
                    {'mData':'qq'},
                    {'mData':'last_login_time'},
                    {'mData':'last_login_ip'},
                    {'mData':'status'},
                    // {'mData':function(lineData){
                    //     var value = lineData.is_dev;
                    //     var text  = lineData.is_dev_text;
                    //     var str   = '<span value="'+value+'">'+text+'</span>';
                    //     return str;
                    // }},
                    // {'mData':function(lineData){
                    //     var value = lineData.hide;
                    //     var text  = lineData.hide_text;
                    //     var str   = '<span value="'+value+'">'+text+'</span>';
                    //     return str;
                    // }},
                    { "mData": function(lineData){
                        var id = lineData.id;
                        var del = '<button  class="btn btn-sm btn-danger" onclick="del(\''+id+'\')">删除<i class="icon-minus"></i></button>';
                        var edit = '<button  class="btn btn-sm btn-info" onclick="edit(\''+id+'\')">编辑<i class="icon-minus"></i></button>';
                        // if(lineData.hide == 1){
                        //     var change = '<button  class="btn btn-sm btn-success" onclick="change(\''+id+'\',0)">显示<i class="icon-minus"></i></button>';
                        // }else{
                        //     var change = '<button  class="btn btn-sm purple" onclick="change(\''+id+'\',1)">隐藏<i class="icon-minus"></i></button>';
                        // }
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

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            //自己定义的搜索框，可以是时间控件，或者checkbox 等等
            var args1 = $("#input1").val();
            var args2 = $("#input2").val();
            var args3 = $("#input3").val();

            grid.setAjaxParam("nick_name", args1);
            grid.setAjaxParam("admin_name", args2);
            grid.setAjaxParam("role_id", args3);

            grid.getDataTable().ajax.reload();
        });


        // grid.getTableWrapper().on( 'dblclick', 'tbody td', function (e) {
        //     var index  = $(this).index();
        //     var nRow   = $(this).parents('tr')[0];
        //     var jqTds  = $('>td', nRow);
        //     var id     = jqTds[0].innerHTML;
        //     var value  = jqTds[index].innerHTML;
        //
        //     if ( index == 4 ) {
        //         var className = "url"+id;
        //         var str = '<input type="text" style="width:150px" class="form-control input-inline data_input '+className+'" data-id="'+id+'" data-field="url" placeholder="菜单URL" data-old="'+value+'" value="'+value+'">';
        //     } else if ( index == 2 ) {
        //         var reg = /\d+/;
        //         var res = reg.exec(value);
        //         var className = "pid"+id;
        //         var content = $("#form_select").html();
        //         content = content.replace(/selected=\"selected\"/, "")
        //         var replace_str = 'value="'+res[0]+'"';
        //         content = content.replace(replace_str,replace_str+' selected="selected"');
        //
        //         var str = '<select class="bs-select form-control data_input '+className+'" data-id="'+id+'" data-field="pid" data-old="'+res[0]+'" style="width:118px">'+content+'</select>';
        //
        //     }else if( index == 7){
        //         var className = "is_dev"+id;
        //         var reg = /\d+/;
        //         var res = reg.exec(value);
        //         if(res[0] == 0){
        //             var str = '<select class="bs-select form-control data_input '+className+'" data-id="'+id+'" data-field="is_dev" data-old="'+res[0]+'" style="width:118px"> <option value="1">是</option><option value="0" selected="selected">否</option></select>';
        //         }else{
        //             var str = '<select class="bs-select form-control data_input '+className+'" data-id="'+id+'" data-field="is_dev" data-old="'+res[0]+'" style="width:118px"> <option value="1" selected="selected">是</option><option value="0">否</option></select>';
        //         }
        //     }else if(index == 8){
        //         var className = "hide"+id;
        //         var reg = /\d+/;
        //         var res = reg.exec(value);
        //         if(res[0] == 0){
        //             var str = '<select class="bs-select form-control data_input '+className+'" data-id="'+id+'" data-field="hide" data-old="'+res[0]+'" style="width:118px"> <option value="1">是</option><option value="0" selected="selected">否</option></select>';
        //         }else{
        //             var str = '<select class="bs-select form-control data_input '+className+'" data-id="'+id+'" data-field="hide" data-old="'+res[0]+'" style="width:118px"> <option value="1" selected="selected">是</option><option value="0">否</option></select>';
        //         }
        //     }
        //     $(this).html(str);
        //     $("."+className).focus();
        //
        // } );
        //
        // grid.getTableWrapper().on( 'blur', '.data_input', function (e) {
        //     var field     = $(this).data('field');
        //     var value     = $(this).val();
        //     var id        = $(this).data("id");
        //     var old_value = $(this).data('old');
        //     var td        = $(this).parents('td');
        //     var index     = td.index();
        //     var str       = value;
        //
        //     if(index == 2){
        //         var text  = $(this).find("option:selected").text();
        //         if(text.indexOf('└') !=-1){
        //             text = text.split('└')[1];
        //         }
        //         var str = '<span value="'+value+'">'+text+'</span>';
        //     }else if(index == 7 || index == 8){
        //         var text  = $(this).find("option:selected").text();
        //         var str = '<span value="'+value+'">'+text+'</span>';
        //     }
        //
        //     if(value != old_value){
        //         var editUrl = $("#editUrl").val();
        //         $.post(editUrl,{"id":id,"value":value,"field":field},function(data){
        //             if(!data.success){
        //                 toastr.options = {
        //                     "closeButton": true,
        //                     "debug": false,
        //                     "positionClass": "toast-top-center",
        //                     "onclick": null,
        //                     "showDuration": "1000",
        //                     "hideDuration": "1000",
        //                     "timeOut": "5000",
        //                     "extendedTimeOut": "1000",
        //                     "showEasing": "swing",
        //                     "hideEasing": "linear",
        //                     "showMethod": "fadeIn",
        //                     "hideMethod": "fadeOut"
        //                 }
        //                 toastr.warning(data.msg, "提示")
        //             }else{
        //                 grid.getDataTable().ajax.reload();
        //             }
        //         },'json');
        //     }
        //
        //     td.html(str);
        //
        // } );
    }


    return {
        //main function to initiate the module
        init: function () {
            initPickers();
            handleOrders();
        }

    };

}();

jQuery(document).ready(function() {
    EcommerceOrders.init();
});


