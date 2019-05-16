<?php
namespace App\Http\Controllers\admin;

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
        return view('admin.login');
    }

    public function checklogin(Request $request){

        $admin = new Admin;
        $passwd = getmd5passwd($_POST['passwd']);

        $map[]=array('admin_name',request('admin_name'));
        $map[]=array('password',$passwd);
        $map[]=array('status',1);

        $adminInfo = $admin->select('*')->where($map)->first();
        if(empty($adminInfo)){
            return redirect('/admin/login')->with('message', array('type' => 'fail','content'=>'账号密码输入有误，或账号已被停用'));
        }else{
            $adminInfo = $adminInfo->toArray();
            $role = new Role;
            $adminInfo['logintime'] = time();
            if(!empty($adminInfo['role_id'])){
                $powers = $role->where('id',$adminInfo['role_id'])->pluck('powers');
                $adminInfo['powers'] = $powers[0];
                $rootids = $role->where('id',$adminInfo['role_id'])->pluck('rootids');
                $adminInfo['rootids'] = $rootids[0];
            }

            $node = new Node;
            $list = $node->where('pid','>',0)->select('name')->get()->toArray();
            $adminInfo['nodes'] = (array)$list;

            $update['last_login_ip'] = $request->getClientIp();
            $update['last_login_time'] = date("Y-m-d h:i:s",time());

            $admin->where("id",$adminInfo['id'])->update($update);

            $request->session()->put('admin', $adminInfo);
//            setcookie('admin_name',$adminInfo['id'],0,'/');

            return redirect('/admin/adminPlat');
        }

    }

    //退出
    public function logout(Request $request){
        $admin = $request->session()->get('admin');
        if (isset($admin['id'])) {
            $request->session()->forget('admin');
            //删除保存在本地的session_id;
            Cookie::queue('laravel_session',null,-3600,'/');
//            Cookie::queue("admin_name",null,-1,'/');
            return redirect('admin/login');
        }
    }

    //修改密码
    public function changeWd(Request $request){
        $adminInfo = $request->session()->get('admin');
        $old_passwd = $_POST['old'];
        $new_passwd = $_POST['new'];
        $repeat = $_POST['renew'];
        $passwd = $adminInfo['passwd'];

        if(($old_passwd == $passwd) && ($new_passwd == $repeat) && (!empty($new_passwd))){
            $admin = new Admin();
            $data['passwd'] = $new_passwd;
            $data['password'] = getmd5passwd($new_passwd);
            $res = $admin->where('id',$adminInfo['id'])->update($data);

            if($res){
                $result = array('success'=>true,'msg'=>'修改成功！');
                $adminInfo['passwd'] = $data['passwd'];
                $adminInfo['password'] = $data['password'];
                $request->session()->put('admin',$adminInfo);

            }else{
                $result = array('success'=>true,'msg'=>'修改失败！');
            }
        }else{
            $result = array('success'=>false,'msg'=>'请正确填写原密码或新密码！');
        }

        return response()->json($result);

    }

}
