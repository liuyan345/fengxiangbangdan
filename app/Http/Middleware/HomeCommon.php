<?php

namespace App\Http\Middleware;

use App\Models\Channel;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
class HomeCommon
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){
        $is_login = $this->checklogin($request);
        if(!$is_login){
            return redirect('/home/login');
        }else{
            return $next($request);
        }
    }

    //验证是否登录了
    public function checklogin(Request $request){
        $admin = $request->session()->get('home');
        if(!$request->session()->has('home')){
            return false;
        }else {
            $nowtime = time();
            $time = $nowtime - $admin['logintime'];

            if ($time <= 3600) {

                $admins = new Channel();
                $adminInfo = $admins->select('*')->where('id', $admin['id'])->first()->toArray();
                $adminInfo['logintime'] = time();

                $session = $adminInfo;
                $request->session()->put('home', $session);
                return true;
            } elseif ($time > 3600) {
                $request->session()->forget('home');
                Cookie::queue('laravel_session',null,-3600,'/');
                return false;
            }else{
                return true;
            }
        }
    }

}
