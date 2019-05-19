{{--
auther 刘岩
后台首页页面
--}}
@extends('admin.public')
@section('style')


@stop
@section('ptitle','渠道信息')

@section('title','修改密码')

@section('content')
    <div class="portlet-body">
        <div class="portlet light portlet-fit portlet-datatable ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">修改密码</span>
                </div>

            </div>
            <div class="portlet-body">
                <form action="#" class="form-horizontal" id="data_form">
                    <div class="form-body">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="id" value="{{$adminInfo['id']}}">
                        <div class="form-group">
                            <label class="col-md-3 control-label">渠道名称</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control"  disabled="disabled" value="{{$adminInfo['admin_name']}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">原密码<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="old" name="old">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">新密码<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="new" name="new">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">重复新密码<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="renew" name="renew">
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
            </div>
        </div>
    </div>
@stop

@section('javascript')

@stop

@section('page_javascript')
    <script>
        //绑定提交事件
        function BindEvent() {
            toastr.options = {   //初始化弹窗的属性
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
            postData = $("#data_form").serializeArray();

            var required = ['old','new','renew'];
            var newPw = $("#new").val();
            var renewPw = $("#renew").val();
            if(newPw != renewPw){
                toastr.warning('提交失败，两次新密码不同！', "提示")
                return false;
            }

            var result   = verify(required,postData);

            if(result){
                App.blockUI({
                    target: '.portlet-body',
                    animate: true
                });

                $.post('/home/changeWd', postData, function (data) {
                    App.unblockUI('.portlet-body');
                    if (data.success) {
                        toastr.success(data.msg, "提示")
                       window.location.reload();
                    }else {
                        toastr.warning(data.msg, "提示")
                    }

                },'json')

            }else {
                toastr.warning('提交失败，请检查必选项！', "提示")
            }
        }

        //验证必选项
        function  verify(required,postData){
            var length = postData.length;
            for(var i=0;i<length;i++){
                var l = required.length;
                for(var j=0;j<l;j++){
                    if((postData[i]['name'] == required[j]) && (postData[i]['value'] =="")){
                        return false;
                    }
                }
            }
            return true;
        }

    </script>

@stop