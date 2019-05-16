{{--
auther 刘岩
后台首页页面
--}}
@extends('admin.public')
@section('style')


@stop
@section('ptitle','后台首页')

@section('title','后台首页')

@section('content')
    <div class="portlet-body" style="max-height: 888px; overflow: hidden;">
        <div class="portlet light portlet-fit portlet-datatable ">
            <div class="portlet-body">
                <img src="{{asset('/style_js/cpcAdmin/assets/pages/img/welcome.jpg')}}"/>
            </div>

        </div>
    </div>
@stop

@section('javascript')

@stop

@section('page_javascript')
    <script>


    </script>

@stop