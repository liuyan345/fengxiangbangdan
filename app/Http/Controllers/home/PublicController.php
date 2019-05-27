<?php
namespace App\Http\Controllers\home;

use App\Models\Channel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Node;
use Illuminate\Support\Facades\Cookie;
/**
 * auther 刘岩
 * 后台公共方法控制器
 * */
class PublicController extends Controller
{
    public function login(){
        return view('home.login');
    }

    public function checklogin(Request $request){

        $admin = new Channel();
        $passwd = getmd5passwd($_POST['passwd']);

        $map[]=array('name',request('admin_name'));
        $map[]=array('asepasswd',$passwd);
        $map[]=array('status',1);

        $adminInfo = $admin->select('*')->where($map)->first();
        if(empty($adminInfo)){
            return redirect('/home/login')->with('message', array('type' => 'fail','content'=>'账号密码输入有误，或账号已被停用'));
        }else{
            $adminInfo = $adminInfo->toArray();

            $adminInfo['logintime'] = time();

            $request->session()->put('home', $adminInfo);

            return redirect('/home/info');
        }

    }

    //退出
    public function logout(Request $request){
        $admin = $request->session()->get('home');
        if (isset($admin['id'])) {
            $request->session()->forget('home');
            //删除保存在本地的session_id;
            Cookie::queue('laravel_session',null,-3600,'/');
//            Cookie::queue("admin_name",null,-1,'/');
            return redirect('/home/login');
        }
    }

    //修改密码
    public function changeWd(Request $request){
        $adminInfo = $request->session()->get('home');
        $old_passwd = $_POST['old'];
        $new_passwd = $_POST['new'];
        $repeat = $_POST['renew'];
        $passwd = $adminInfo['passwd'];

        if(($old_passwd == $passwd) && ($new_passwd == $repeat) && (!empty($new_passwd))){
            $admin = new Channel();
            $data['passwd'] = $new_passwd;
            $data['asepasswd'] = getmd5passwd($new_passwd);
            $res = $admin->where('id',$adminInfo['id'])->update($data);

            if($res){
                $result = array('success'=>true,'msg'=>'修改成功！');
                $adminInfo['passwd'] = $data['passwd'];
                $adminInfo['asepasswd'] = $data['asepasswd'];
                $request->session()->put('home',$adminInfo);

            }else{
                $result = array('success'=>true,'msg'=>'修改失败！');
            }
        }else{
            $result = array('success'=>false,'msg'=>'请正确填写原密码或新密码！');
        }

        return response()->json($result);

    }

    // 添加新的渠道
    public function channelAdd(Request $request){
        $_POST['asepasswd'] = getmd5passwd($_POST['passwd']);

        if(empty($_POST['name'])){
            return redirect('/home/login')->with('message', array('type' => 'fail','content'=>'渠道名不能为空'));
        }
        if(empty($_POST['company'])){
            return redirect('/home/login')->with('message', array('type' => 'fail','content'=>'渠道公司不能为空'));
        }
        if(empty($_POST['passwd'])){
            return redirect('/home/login')->with('message', array('type' => 'fail','content'=>'密码不能为空'));
        }
        $condition['company'] = $request['company'];
        $condition['name'] = $request['name'];

        $data = $this->store($request,$condition);

        if($data['success']){
            $admin = new Channel();
            $adminInfo = $admin->select('*')->where('name',$request['name'])->first();
            if(empty($adminInfo)){
                return redirect('/home/login')->with('message', array('type' => 'fail','content'=>'注册失败，请重新注册'));
            }else{
                $adminInfo = $adminInfo->toArray();

                $adminInfo['logintime'] = time();

                $request->session()->put('home', $adminInfo);

                return redirect('/home/info');
            }
        }else{
            return redirect('/home/login')->with('message', array('type' => 'fail','content'=>'注册失败，请重新注册'));
        }
    }

    public function store($request,$condition = array(),$id = null){
        $model = new Channel();
        if(empty($id)){
            $id = 'id';
        }

        if(!empty($condition)){
            $info = $model->where($condition)->select($id)->first();
        }else{
            $info = array();
        }

        if($info){
            $result = array('success'=>false,'msg'=>'添加失败!此条目已存在!!!');
        }else{

            if(!empty($_POST['_token'])){
                unset($_POST['_token']);
            }
            foreach($_POST as &$v){
                if(is_string($v)){
                    $v = trim($v);
                }
            }
            $res = $model->insertGetId($_POST);

            if($res){
                $result = array('success'=>true,'msg'=>'添加成功!!','id'=>$res);
            }else{
                $result = array('success'=>false,'msg'=>'添加失败!!');
            }
        }
        return $result;
    }

}
