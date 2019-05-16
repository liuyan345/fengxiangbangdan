<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
/**
 * auther 刘岩
 * 后台首页控制器
 * */
class AdminPlatController extends Controller
{

    public function index(Request $request){
        return view('admin.adminPlat.adminPlat');
    }

    public function changePW(Request $request){
        $adminInfo = $request->session()->get("admin");
        return view('admin.adminPlat.changePW',['adminInfo'=>$adminInfo]);
    }

}
