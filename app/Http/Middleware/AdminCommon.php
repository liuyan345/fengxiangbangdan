<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Node;
use Cookie;
class AdminCommon
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){
//                return $next($request);

        $caction = '/'.$request->path();

        if($caction == '/admin/adminPlat'){
            $is_login = $this->checklogin($request);
            $this->show_menu($request);
            if(!$is_login){
                return redirect('/admin/login');
            }else{
                return $next($request);
            }
        }else{
            $is_login = $this->checklogin($request);

            if(!$is_login){
                return redirect('/admin/login');
            }else{
                $couldedit = $this->getCouldedit($request);

                $this->show_menu($request);
                if($couldedit){
                    $request->session()->put('couldedit',$couldedit);
                } else{
                    return redirect('/nopower');
                }
                return $next($request);
            }
        }
    }

    public function show_menu(Request $request){
        $session = $request->session()->get('admin');

        if(!empty($session['powers'])){
            $power = json_decode($session['powers'],true);
            $power = $power[0]['power']['childrens'];
            $power = multi_array_sort($power,'sort');
            foreach ($power as &$val){
                $val['childrens'] = multi_array_sort($val['childrens'],"sort");
            }
        }else{
            $power = array();
        }
//        $menu = array();
//        foreach($power as $val){
//            $data = array();
//            if($val['name'] == '/'){
//                $data['abspath'] = $val['id'];
//                $data['name'] = $val['title'];
//                $data['path'] = $val['childrens'][0]['name'].'?pid='.$data['abspath'];
//                $menu[] = $data;
//            }
//        }
        $request->session()->put('adminMenu', $power);

    }

    public function getCouldedit(Request $request) {

        $couldedit = $this->check($request);
        return $couldedit;
    }

    //验证是否登录了
    public function checklogin(Request $request){
        $admin = $request->session()->get('admin');
        if(!$request->session()->has('admin')){
            return false;
        }else {
            $nowtime = time();
            $time = $nowtime - $admin['logintime'];

            if ($time <= 3600) {
//                if ($time > 500 && $time < 1800) {

                $admins = new Admin;
                $adminInfo = $admins->select('*')->where('id', $admin['id'])->first()->toArray();

                $role = new Role;
                $adminInfo['logintime'] = time();

                if(!empty($adminInfo['role_id'])){
                    $powers = $role->where('id', $adminInfo['role_id'])->pluck('powers');
                    $rootids = $role->where('id', $adminInfo['role_id'])->pluck('rootids');
                    $adminInfo['powers'] = $powers[0];
                    $adminInfo['rootids'] = $rootids[0];
                }

                $node = new Node;
                $list = $node->where('pid', '>', 0)->select('name')->get()->toArray();
                $adminInfo['nodes'] = (array)$list;

                $session = $adminInfo;
                $request->session()->put('admin', $session);
                return true;
            } elseif ($time > 3600) {
                $request->session()->forget('admin');
//				$request->session()->flush();
//                setcookie('laravel_session', '', -3600, '/');
                Cookie::queue('laravel_session',null,-3600,'/');

//                Cookie::queue("admin_name",null,-1,'/');
                return false;
            }else{
                return true;
            }
        }
    }

    //这个方法是验证当前访问的地址是否是用户有权限的地址
    public function check($request){
        $admin = $request->session()->get('admin');
        if(empty($admin['id'])){
            return redirect('/admin/login');
        }else{
            $caction = '/'.$request->path();

            $rountnum = substr_count($caction,'/');

            if($rountnum >2){
                preg_match('/(\/admin\/.*)\/.*/U',$caction,$newstr);
                $caction = $newstr[1];
            }
            $session = $request->session()->get('admin');
            $powers = json_decode($session['powers'],1);
            $list = $session['nodes'];
            foreach($list as $value){
                $value = (array)$value;
                $base[] = $value['name'];
            }

            $couldedit = '';

            foreach($powers as $value){
                foreach($value['power']['childrens'] as $val){
                    foreach($val['childrens'] as $vals){
                        $tmp[] = $vals['name'];
                        if($vals['name']==$caction){
                            if(!empty($vals['couldedit'])){
                                $couldedit = $vals['couldedit'];
                            }
                        }
                    }
                }
            }

            $jinzhi = array_diff($base,$tmp);

            if(in_array($caction,$jinzhi)){
                return false;
            }else{
                return $couldedit;
            }

        }

    }
}
