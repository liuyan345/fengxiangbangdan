{{--
auther 刘岩
后台首页页面
--}}
@extends('home.public')
@section('style')


@stop
@section('ptitle','渠道商信息')

@section('title','渠道商信息')

@section('content')
    <div class="portlet-body">
        <div class="portlet light portlet-fit portlet-datatable ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-green"></i>
                    <span class="caption-subject font-green sbold uppercase">渠道商信息</span>
                </div>

            </div>
            <div class="portlet-body">
                <form action="#" class="form-horizontal" id="data_form">
                    <div class="form-body">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" id="channelId" value="{{$channelInfo['id']}}">
                        <div class="form-group">
                            <label class="col-md-3 control-label">渠道商名称</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control"  disabled="disabled" value="{{$channelInfo['name']}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">公司名称</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control"  disabled="disabled" value="{{$channelInfo['company']}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">联系人<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="linkman" @if(!empty($channelInfo['linkman'])) value="{{$channelInfo['linkman']}}" @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">联系人手机号<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="linkmanMobile" @if(!empty($channelInfo['linkmanMobile'])) value="{{$channelInfo['linkmanMobile']}}" @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">联系人qq</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="qq" @if(!empty($channelInfo['qq'])) value="{{$channelInfo['qq']}}" @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">联系人邮箱</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" @if(!empty($channelInfo['email'])) value="{{$channelInfo['email']}}" @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">地区</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="area" @if(!empty($channelInfo['area'])) value="{{$channelInfo['area']}}" @endif>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">渠道类型</label>
                            <div class="col-md-6">
                                <select name="type" class="form-control">
                                    <option value="">-请选择-</option>
                                    <option value="1" @if(!empty($channelInfo['type']) && $channelInfo['type'] == 1) selected="selected" @endif>wap</option>
                                    <option value="2" @if(!empty($channelInfo['type']) && $channelInfo['type'] == 2) selected="selected" @endif>应用市场</option>
                                    <option value="3" @if(!empty($channelInfo['type']) && $channelInfo['type'] == 3) selected="selected" @endif>APP</option>
                                    <option value="4" @if(!empty($channelInfo['type']) && $channelInfo['type'] == 4) selected="selected" @endif>其他</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">下载地址<span class="required">*</span></label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="loadlink" @if(!empty($channelInfo['loadlink'])) value="{{$channelInfo['loadlink']}}" @endif>
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
            var postData = $("#data_form").serializeArray();
            var channelId = $("#channelId").val();
            var required = ['linkman','linkmanMobile','loadlink'];
            var result   = verify(required,postData);
            if(result){
                App.blockUI({animate: true});
                $.post('/home/info/'+channelId, postData, function (data) {
                    App.unblockUI();
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