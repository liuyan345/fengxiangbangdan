<?php
namespace App\Tools;
/**
 * 微信红包中转接口
 * @param string(json)
 * @return string(json)
 * @oauth huobo
 * @date 2016-06-20
 */
//$data    = json_decode(file_get_contents("php://input"),true);
//$hongbao = new HongBao($data['re_openid'],$data['total_amount'],$data['total_num'],$data['type']);
//
////验签或请求
//if($data['sign']!=$hongbao->sign()){
//    $result = $hongbao->fail();
//    echo json_encode($result);
//}else{
//    $result = $hongbao->pay();
//    echo json_encode($result);
//}

class SendRed{

    private $re_openid    = '';//openid
    private $total_amount = '';//发送金额(分)
    private $total_num    = '';//发送人数
    private $type         = '';//发送类型 1:普通 其他:裂变
    private $mch_id       = '1497619982';//商户号 String(32)
    private $wxappid      = 'wx033b8b7ba70cb675';//好易微转appid String(32)
    private $send_name    = '全民竞答';//红包发送者名称 String(32)
    private $wishing      = '恭喜您，撸起袖子继续干!';//红包祝福语 String(128)
    private $act_name     = '全民竞答';//活动名称 String(32)
    private $remark       = '答得多，赢的多!';//备注 String(256)
    private $sign         = '8l6Q%gTm4EBsVSVA';//被请求时的api秘钥
    private $key          = 'adc6b499fe6485b3fb39611e047d8e9c';//请求微信时携带的api秘钥
    private $url          = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";//普通红包接口地址
    private $lb_url       = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack";//裂变红包接口地址

    function __construct($re_openid,$total_amount,$total_num,$type){
        $this->re_openid    = $re_openid;
        $this->total_amount = $total_amount;
        $this->total_num    = $total_num;
        $this->type         = $type;
    }

    /**
     * 红包请求方法
     */
    public function pay(){
        if($this->type==1){//普通红包
            //调用接口的机器ip地址(仅普通红包使用)
            //$data['client_ip']    = $this->get_client_ip();
            $data['client_ip']    = '127.0.0.1';
            $url = $this->url;
        }else{//裂变红包
            //金额设置方式(仅列表红包使用)
            $data['amt_type']     = 'ALL_RAND';
            $url = $this->lb_url;
        }
        //随机字符串
        $data['nonce_str']    = $this->nonce_str();
        //订单号
        $data['mch_billno']   = $this->mch_id.date('YmdHis').rand(1000, 9999);
        //商户号
        $data['mch_id']       = $this->mch_id;
        //公众号appid
        $data['wxappid']      = $this->wxappid;
        //红包发送者名称
        $data['send_name']    = $this->send_name;
        //接收用户的openid
        $data['re_openid']    = $this->re_openid;
        //付款金额(单位:分)
        $data['total_amount'] = $this->total_amount;
        //红包发放总人数->1
        $data['total_num']    = $this->total_num;
        //红包祝福语
        $data['wishing']      = $this->wishing;
        //活动名称
        $data['act_name']     = $this->act_name;
        //备注
        $data['remark']       = $this->remark;
        //签名
        ksort($data);
        $data['sign']         = $this->get_sign($data,$this->key);

        //最终提交xml
        $xml = $this->arrayToXml($data);

        //发送请求
        $result      = $this->curl_post_ssl($url,$xml);

        $responseObj = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);

        //xml对象转成数组
        $data = json_encode($responseObj);
        $data = json_decode($data,true);
        if($data['return_code'] == "SUCCESS" && $data['result_code'] == "SUCCESS"){
            $array = array(
                'return_code'  => $data['return_code'],
                'return_msg'   => $data['return_msg'],
                'result_code'  => $data['result_code'],
                'err_code'     => $data['err_code'],
                'err_code_des' => $data['err_code_des'],
                'mch_billno'   => $data['mch_billno'],
                're_openid'    => $data['re_openid'],
                'total_amount' => $data['total_amount'],
                'send_listid'  => $data['send_listid'],
            );
        }else{
            $array = array(
                'return_code'  => $data['return_code'],
                'return_msg'   => $data['return_msg'],
                'result_code'  => $data['result_code'],
                'err_code'     => $data['err_code'],
                'err_code_des' => $data['err_code_des'],
                'mch_billno'   => $data['mch_billno'],
                're_openid'    => $data['re_openid'],
                'total_amount' => $data['total_amount'],
            );
        }


        return $array;
    }

    /**
     * @return array
     */
    public function fail(){
        $array = array(
            'return_code'=>'SUCCESS',
            'return_msg'=>'签名错误',
            'result_code'=>'FAIL',
            'err_code'=>'SIGN_ERROR',
            'err_code_des'=>'签名错误',
        );
        return $array;
    }


    /**
     * 数组转xml字符串
     * @param $arr
     * @return string
     */
    public function arrayToXml($arr){

        $xml = "<xml>";
        foreach($arr as $key => $val){
            if(is_numeric($val)){
                $xml .= "<".$key.">".$val."</".$key.">";
            }else{
                $xml .= "<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml .= "</xml>";


        return $xml;
    }

    public function getBytes($string) {
        $bytes = array();
        for($i = 0; $i < strlen($string); $i++){
            $bytes[] = ord($string[$i]);
        }
        return $bytes;
    }

    /**
     * 生成随机字符串
     * @param int $length
     * @param bool $type
     * @return string
     */
    public function nonce_str($length = 16, $type = FALSE) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str   = "";
        for($i = 0;$i < $length;$i ++){
            $str .= substr($chars,mt_rand(0,strlen($chars) - 1),1);
        }
        if($type == true){
            return strtoupper(md5(time().$str));
        }else{
            return $str;
        }
    }

    /**
     * 生成请求微信时需要秘钥
     * @param $data
     * @param $key
     * @return string
     */
    private function get_sign($data,$key){
        ksort($data);
        $str = '';
        foreach($data as $k => $v){
            $str .= $k.'='.$v.'&';
        }
        $str = $str.'key='.$key;
        return strtoupper(md5($str));
    }

    /**
     * 带证书的post请求
     * @param $url
     * @param $vars
     * @param int $second
     * @param array $aHeader
     * @return bool|mixed
     */
    function
    curl_post_ssl($url, $vars, $second=30,$aHeader=array()) {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

        //cert 与 key 分别属于两个.pem文件
        curl_setopt($ch,CURLOPT_SSLCERT,DIRECTORY_SEPARATOR.'data/www'.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_cert.pem');
        curl_setopt($ch,CURLOPT_SSLKEY,DIRECTORY_SEPARATOR.'data/www'.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_key.pem');
        curl_setopt($ch,CURLOPT_CAINFO,DIRECTORY_SEPARATOR.'data/www'.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'rootca.pem');

        if( count($aHeader) >= 1 ) curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);

        curl_setopt($ch,CURLOPT_POST, 1);

        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return false;
        }
    }

    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @return mixed
     */
    function get_client_ip($type = 0) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    /**
     * 验证被请求时的秘钥
     */
    public function sign(){
        $data['re_openid']    = $this->re_openid;
        $data['total_amount'] = $this->total_amount;
        $data['total_num']    = $this->total_num;
        $data['type']         = $this->type;
        ksort($data);
        $str = '';
        foreach($data as $k => $v){
            $str .= $k.'='.$v.'&';
        }
        $str = $str.'key='.$this->sign;
        return strtoupper(md5($str));
    }

}


?>