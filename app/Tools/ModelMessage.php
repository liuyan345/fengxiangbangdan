<?php
namespace App\Tools;
use App\Models\FormId;
use Illuminate\Support\Facades\Redis;

/**
 * 发送模板消息
 * authur 刘岩
 *
 * demo
 *  $message = new ModelMessage();
 *  $messageArray['result'] = "成功";
 *  $messageArray['title'] = "新手上路100人场";
 *  $messageArray['money'] = "0.1";
 *  $messageArray['remark'] = "这里是备注";
 *  $res = $message->sendMessage('13434',$messageArray);
 *
 */

class ModelMessage{

    private $uid; //用户的id
    private $appid;//小程序的appid;
    private $appsecret;//小程序的secret;
    private $redis;
    /**
     * 构造函数
     *
     * @param int 配置用户的id
     * @param string 小程序的appid
     * @param string 小程序的appsecret
     */
    public function __construct($uid = null, $appid = null , $appsecret = null) {
        $this->appid = getenv("XCXAPPID");
        $this->appsecret = getenv("XCXSECRET");
        if(!empty($uid)){
            $this->uid = $uid;
        }
        if(!empty($appid)){
            $this->appid = $appid;
        }
        if(!empty($appsecret)){
            $this->appsecret = $appsecret;
        }
        $this->redis =  Redis::connection();
    }

    /**
     * 发送模板消息 单人
     * @param int 用户的id
     * @message array 发送的内容
     *  array{
     *      'result'=>"成功", //跳转结果
     *      'title'=>"群雄争霸第二场", // 挑战项目
     *      'money'=>"0.1", // 奖励消息
     *       'remark'=>"我不知道，你问贾总" // 备注信息
     * }
     */
    public function sendMessage($uid = null,$message){
        // 判断发送方法的用户uid 是否为空 ，不为空 覆盖初始化uid
        if(!empty($uid)){
            $this->uid = $uid;
        }else{
            if(empty($this->uid)){
                return array("success"=>false,"msg"=>"用户的id为空");
            }
        }
        //获取用户的formId 去最靠前的 并删除7天之前的
        $formDB = new FormId();
        $formInfo = $formDB->where("uid",$uid)->where("cdate",">=",(time()-7*86400))->where("status",1)->select("open_id","form_id","id")->orderBy("cdate","asc")->first();

        if(empty($formInfo->form_id)){
            return array("success"=>false,"msg"=>"用户的formId为空");
        }
        $formString = $formInfo->form_id;
        $openId = $formInfo->open_id;

        if(empty($openId)){
            return array("success"=>false,"msg"=>"获取用户openId失败！");
        }
        if(empty($formString)){
            return array("success"=>false,"msg"=>"获取用户的formId失败！");
        }

        // 获取小程序token
        $token = $this->getWXAccessToken();
        if (empty($token)) {
            return ['seccess' => false, 'msg' => "token错误"];
        } else {
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            $post_data['touser'] = $openId;
            $post_data['template_id'] = $message['template_id'];
            $post_data['page'] = $message['page'];
            $post_data['form_id'] = $formString;
            foreach ($message['message'] as $k=>$param){
                $key = 'keyword'.($k+1);
                $post_data['data'][$key] = array("value" => $param );
            }// post的变量
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output, true);
            //发送成功 修改状态
            if ($output['errcode'] == 0) {
                return array("success"=>true,"msg"=>"发送成功！");
            }else{
                return array("success"=>false,"msg"=>"发送失败！");
            }
            $formDB->where("id",$formInfo->id)->update(['status'=>2]);
        }
    }


    /**
     * 发送模板消息 多人
     * @param $uid array 用户的id
     * @param $message_id string 模板id
     * @param $message array 发送的内容（一维索引数组）内容排序好
     *  array{
     *      '0'=>"成功", //跳转结果
     *      '1'=>"群雄争霸第二场", // 挑战项目
     *      '2'=>"0.1", // 奖励消息
     *      '3'=>"我不知道，你问贾总" // 备注信息
     * }
     *  @param $path string 模板消息要跳转的小程序页面
     * @falg  true  今天有活跃的用户不发送 false 今天有活跃的发送
     */
    public function sendMessageToPeople($uid = array(),$message_id,$message,$path = 'pages/index/index',$flag = true){
        // 找到正确的发送模板消息的对象
        if($flag){
            $formDB = new FormId();
            $formId = $formDB->whereIn("uid",$uid)->where("cdate",">=",strtotime("today"))->select("uid")->groupBy("uid")->get()->toArray();
            $new_formId = [];
            foreach ($formId as $item){
                $new_formId[] = $item['uid'];
            }
        }
        $formDB = new FormId();


        if(!empty($uid)){
            if(!empty($new_formId)){
                $uid = array_diff($uid,$new_formId);
            }
            $formDB = $formDB->whereIn("uid",$uid);
        }else{
            if(!empty($new_formId)){
                $formDB = $formDB->whereNotIn("uid",$new_formId);
            }
        }

        $formInfo = $formDB->where("cdate",">=",(time()-7*86400))->where("status",1)->select("open_id","form_id","id")->orderBy("cdate","asc")->groupBy("uid")->get()->toArray();

        if(empty($formInfo)){
            return array("success"=>false,"msg"=>"可发送用户为空！");
        }else{
            foreach ($formInfo as $k=>$value){
                $res =  $this->send($value,$message_id,$message,$path);
                $formDB->where("id",$value['id'])->update(['status'=>2]);
            }
        }
    }

    /**
     * 发送模板消息
     * @param $formInfo array 发送的用户相关信息
     * @param $message_id string 模板id
     * @param $message array 发送的内容（一维索引数组）内容排序好
     *  array{
     *      '0'=>"成功", //跳转结果
     *      '1'=>"群雄争霸第二场", // 挑战项目
     *      '2'=>"0.1", // 奖励消息
     *      '3'=>"我不知道，你问贾总" // 备注信息
     * }
     *  @param $path string 模板消息要跳转的小程序页面
     */
    private function send($formInfo,$message_id,$message,$path){
        // 获取小程序token
        $token = $this->getWXAccessToken();
        if (empty($token)) {
            return ['seccess' => false, 'msg' => "token错误"];
        } else {
            $url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $token;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POST, 1);
            $post_data['touser'] = $formInfo['open_id'];
            $post_data['template_id'] = $message_id;
            $post_data['page'] = $path;
            $post_data['form_id'] = $formInfo['form_id'];
            foreach ($message as $k=>$v){
                $key = 'keyword'.($k+1);
                $post_data['data'][$key] = array("value" => $v );
            }
            // post的变量
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
            $output = curl_exec($ch);
            curl_close($ch);
            $output = json_decode($output, true);
//            $this->redis->set("test",json_encode($output));die;
            //发送成功 修改状态
            if ($output['errcode'] == 0) {
                return array("success"=>true,"msg"=>"发送成功！");
            }else{
                return array("success"=>false,"msg"=>"发送失败！");
            }
        }
    }

    /**
     * 获取小程序的token
     */
    public function getWXAccessToken()
    {
        $key = "token_".$this->appid;
        if (empty($this->redis->get($key))) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appid."&secret=".$this->appsecret;
            $content = file_get_contents($url);
            $content = json_decode($content, true);
            $token = $content['access_token'];
            $this->redis->set($key, $token);
            $this->redis->expire($key, 3000);
        } else {
            $token = $this->redis->get($key);
        }
        return $token;
    }

}
