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
use App\Repostories\Eloquent\DataModel as Actor;


class DataController extends Controller
{
    private $actor;
    public function __construct(Actor $actor){
        $this->actor = $actor;
    }
    public function index(Request $request)
    {
        echo strtotime('5/6/2019');
        die;
        return view('admin/data/data');
    }
    public function datalist(Request $request)
    {
        $columns = array('*');
        $infos = $this->actor->datalist($request,$columns);
        return response()->json($infos);
    }

    /**
     * 上传
     */
    public function upload(Request $request)
    {
        $infos = $this->actor->upload($request);
        return response()->json($infos);

    }




}