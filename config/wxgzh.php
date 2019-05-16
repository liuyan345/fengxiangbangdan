<?php
//微信公众号配置文件
//AccessToken配置
return [
    'GrantType' => 'client_credential',//获取AccessToken的授权接口参数
    'AppID' => 'wxe591b9962a632752',//获取AccessToken的授权接口参数
    'AppSecret' => '672281b2ddc9e263ac5b5930e7826b4a',//获取AccessToken的授权接口参数
    'TemplateID' => 'Pf6V5RVm61ds9iwbuhzC5IcHxhBzce2m_02mPj8XKCs',//模板消息默认模板ID
    'XcxAppid' => 'wx0fefe7f022d239e6',//模板消息默认跳转小程序AppID
    'XcxPath' => 'pages/index/index',//模板消息默认跳转小程序页面
    'Url' => 'http://www.cunyucpc.com/regionGoods/list',//模板消息默认Url
    'Token' => 'myweixin',//微信服务器配置Token令牌
];
