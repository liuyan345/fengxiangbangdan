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
                $adminInfo['password'] = $data['password'];
                $request->session()->put('home',$adminInfo);

            }else{
                $result = array('success'=>true,'msg'=>'修改失败！');
            }
        }else{
            $result = array('success'=>false,'msg'=>'请正确填写原密码或新密码！');
        }

        return response()->json($result);

    }

}