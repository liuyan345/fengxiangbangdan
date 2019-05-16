<?php
/**
 * Created by PhpStorm.
 * User: 王跃东
 * Date: 2018/10/19
 * Time: 10:53
 */

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repostories\Eloquent\ReportModel as Actor;


class ReportController extends Controller
{
    private $actor;
    public function __construct(Actor $actor){
        $this->actor = $actor;
    }
    public function zf(Request $request)
    {
        return view('admin/report/zf');
    }

    public function zfdatalist(Request $request)
    {
        $columns = array('*');
        $infos = $this->actor->zfdatalist($request,$columns);
        return response()->json($infos);
    }

    public function video(Request $request)
    {
        return view('admin/report/video');
    }

    public function videodatalist(Request $request)
    {
        $columns = array('*');
        $infos = $this->actor->videodatalist($request,$columns);
        return response()->json($infos);
    }
}