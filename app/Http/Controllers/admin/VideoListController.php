<?php
/**
 * Created by PhpStorm.
 * User: 王跃东
 * Date: 2018/10/19
 * Time: 10:53
 */

namespace App\Http\Controllers\admin;

use App\Models\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repostories\Eloquent\VideoListModel as Actor;


class VideoListController extends Controller
{
    private $actor;
    public function __construct(Actor $actor){
        $this->actor = $actor;
    }
    public function index(Request $request)
    {
        $cateModel = new Cate();
        $cateInfo = $cateModel->getCateName();
        return view('admin/video/list',['cateInfo'=>$cateInfo]);
    }
    public function datalist(Request $request)
    {
        $columns = array('*');
        $infos = $this->actor->datalist($request,$columns);
        return response()->json($infos);
    }


    /**
     * 删
     */
    public function delete(Request $request,$id)
    {
        $res = $this->actor->delete($request,$id);
        // echo json_encode($res);
        return response()->json($res);
    }
    /**
     * 上传
     */
    public function upload(Request $request)
    {
        $infos = $this->actor->upload($request);
        return response()->json($infos);

    }

    /**
     * 获取修改数据
     */
    public function edit(Request $request,$id)
    {
        $array = array('*');
        $data = $this->actor->edit($request,$array,$id);
        return response()->json($data);
     }
    /**
     * 保存修改数据
     */
    public function update(Request $request,$id)
    {
        $data = $this->actor->update($request,$id);
        return response()->json($data);
    }


}