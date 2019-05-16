
<?php
use App\Models\Admin;
use Illuminate\Support\Facades\Route;


/***
 * 自定义的公共函数库
 **/

/**
 * auther 刘岩
 * 密码加密
 * str 要加密的原密码
 * 返回加密后的密码
 */
function getmd5passwd($str){
    return substr(md5($str.getenv('TAIL_STR')),5,20);
}

/**
 * auther 刘岩
 * 二维数组排序
 * SORT_ASC 升序 SORT_DESC降序(不能带引号)
 * */
function multi_array_sort($multi_array,$sort_key,$sort=1){
    if(is_array($multi_array)){
        foreach ($multi_array as $row_array){
            if(is_array($row_array)){
                $key_array[] = $row_array[$sort_key];
            }else{
                return false;
            }
        }
    }else{
        return false;
    }
    if($sort == 1){
        array_multisort($key_array,SORT_DESC,$multi_array);
    }else if($sort == 2){
        array_multisort($key_array,SORT_ASC,$multi_array);
    }
    return $multi_array;
}

/**
 *  auther 刘岩
 *  获取 用户列表对应的数组
 *  param  role  要获取的角色分组  具体的管理员id
 *  return  一维数组
 */
function get_admin($role = "",$id = ""){
    $map = array();
    if(!empty($role)){
        $map[] = array("role_id",$role);
    }
    $admin = new Admin();
    $adminInfo = $admin->where($map)->where(function($query)use($id){
        if(!empty($id)){
            $query->where("id",$id);
        }
    })->select("id","admin_name","nick_name")->get();

    $returnInfo = array();
    if(!empty($adminInfo)){
        foreach ($adminInfo as $val){
            $name = empty($val->nick_name) ? $val->admin_name : $val->nick_name;
            $returnInfo[$val->id] = $name;
        }
    }
    return $returnInfo;
}


/**
 *  auther 刘岩
 *  抓取https协议页面内容的函数
 */
function getHTTPS($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    //跳过安全认证
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);   // 设置这个选项为一个非零值(象 ‘Location: ‘)的头，服务器会把它当做HTTP头的一部分发送(注意这是递归的，PHP将发送形如 ‘Location: ‘的头)。
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function http_request($url, $data = null)
{

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

/**
 * auther 刘岩
 * 添加日志函数
 * param content 要写入的参数 日志的具体描述
 */

// function addLog($request,$content = ""){
//     $adminInfo         = $request->session()->get("admin");
//     $action            = Route::current()->getActionName();
//     $action            = explode('\\',$action);
//     $l                 = count($action);
//     $data['action']    = $action[$l-1];
//     $data['ip']        = $request->getClientIp();
//     $data['uid']       = $adminInfo['id'];
//     $data['username']  = empty($adminInfo['nick_name'])?$adminInfo['admin_name']:$adminInfo['nick_name'];
//     $data['content']   = $content;

//     $log               = new Log();
//     $log->create($data);
// }


/**
 * auther 刘岩
 * 手机验证码生成
 */
function mobile_code(){
    $str = '1234567890';
    $newstr = '';
    $len = strlen($str);
    for($i = 1;$i<= 6; $i++){
        $newstr .= substr($str,mt_rand(0,$len-1),1);
    }
    return $newstr;
}

/*移动端判断*/
function isMobile()
{
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
    {
        return true;
    }
    // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
    {
        // 找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
    }

    // 脑残法，判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT']))
    {
        $clientkeywords = array ('nokia',
            'sony',
            'ericsson',
            'mot',
            'samsung',
            'htc',
            'sgh',
            'lg',
            'sharp',
            'sie-',
            'philips',
            'panasonic',
            'alcatel',
            'lenovo',
            'iphone',
            'ipod',
            'blackberry',
            'meizu',
            'android',
            'netfront',
            'symbian',
            'ucweb',
            'windowsce',
            'palm',
            'operamini',
            'operamobi',
            'openwave',
            'nexusone',
            'cldc',
            'midp',
            'wap',
            'mobile'
        );
        // 从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
        {
            return true;
        }
    }
    // 协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT']))
    {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
        {
            return true;
        }
    }
    return false;
}


/**
 * 获取链接中的某一个参数的值
 * @param url  被提取的链接
 * @param p   要提取的参数
 */
function get_url_param($url,$p){
    if(empty($url)){
        return array("success"=>false,'msg'=>"参数错误！");
    }
    $param = parse_url($url)['query'];

    if(empty($param)){
        return array("success"=>false,'msg'=>"提取链接不包含参数！");
    }
    $param = explode('&',$param);
    $paramInfo = array();


    foreach ($param as $item) {
        $temp = explode('=',$item);
        if(!empty($temp[0]) && !empty($temp[1])){
            $paramInfo[$temp[0]] = $temp[1];
        }
    }
    if(!isset($paramInfo[$p])){
        return array("success"=>false,'msg'=>"提取参数不存在！");
    }else{
        return array("success"=>true,"data"=>$paramInfo[$p]);
    }
}

/**
 * 数字转换为中文
 * @param  string|integer|float  $num  目标数字
 * @param  integer $mode 模式[true:金额（默认）,false:普通数字表示]
 * @param  boolean $sim 使用小写（默认）
 * @return string
 */
function numtochr($num,$mode=true) {
    $char = array("零","一","二","三","四","五","六","七","八","九");
    $dw = array("","十","百","千","","万","亿","兆");
    $dec = "点";
    $retval = "";
    if($mode)
        preg_match_all("/^0*(\d*)\.?(\d*)/",$num, $ar);
    else
        preg_match_all("/(\d*)\.?(\d*)/",$num, $ar);
    if($ar[2][0] != "")
        $retval = $dec . $this->ch_num($ar[2][0],false); //如果有小数，先递归处理小数
    if($ar[1][0] != "") {
        $str = strrev($ar[1][0]);
        for($i=0;$i<strlen($str);$i++) {
            $out[$i] = $char[$str[$i]];
            if($mode) {
                $out[$i] .= $str[$i] != "0"? $dw[$i%4] : "";
                if($str[$i]+$str[$i-1] == 0)
                    $out[$i] = "";
                if($i%4 == 0)
                    $out[$i] .= $dw[4+floor($i/4)];
            }
        }
        $retval = join("",array_reverse($out)) . $retval;
    }
    return $retval;
}
/**
 * 大写转数字
 * @param $str string 要转换的数字
 */
//中文转阿拉伯
function chrtonum($str){
    $num=0;
    $bins=array("零","一","二","三","四","五","六","七","八","九",'a'=>"个",'b'=>"十",'c'=>"百",'d'=>"千",'e'=>"万");
    $bits=array('a'=>1,'b'=>10,'c'=>100,'d'=>1000,'e'=>10000);
    foreach($bins as $key=>$val){
        if(strpos(" ".$str,$val)) $str=str_replace($val,$key,$str);
    }
    foreach(str_split($str,2) as $val){
        $temp=str_split($val,1);
        if(count($temp)==1) $temp[1]="a";
        if(isset($bits[$temp[0]])){
            $num=$bits[$temp[0]]+(int)$temp[1];
        }else{
            $num+=(int)$temp[0]*$bits[$temp[1]];
        }
    }
    return $num;

}

