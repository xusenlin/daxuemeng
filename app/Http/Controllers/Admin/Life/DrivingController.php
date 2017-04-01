<?php

namespace App\Http\Controllers\Admin\Life;

use App\Model\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DrivingController extends Controller
{
    //驾校信息列表
    public function index(){

        $drivingModel = new Post();
        $driving = $drivingModel->where('type','=',Post::TYPE_DRIVING)
            ->where('status','<>','recycled')
            ->paginate(PAGING_NUMBER_ADMIN);

        return view('admin.life.driving_list')->with(['driving'=>$driving]);
    }

    //添加或者修改驾校信息视图
    public function add($info_id = null){
        $driving = array();
        $driving['driving_id'] =   $info_id;
        if ($info_id){
            $driving['title'] =   '修改驾校信息';
            $driving['data'] = Post::find($info_id);
        }else{
            $driving['title'] =   '添加驾校信息';
        }

        return view('admin.life.driving_add')->with(['driving'=>$driving]);
    }

    //保存驾校信息数据   还没有做
    public function save(Request $request){

        try {
            $this->validate($request, [
                'title' => 'required',
                'cover' => 'required',
                'excerpt' => 'required',
                'content' => 'required',
                'status' => 'required',
            ], [
                'title.required' => '标题必须填写！',
                'cover.required' => '封面必须上传！',
                'excerpt.required' => '摘要必须填写！！',
                'content.required' => '内容必须填写！',
                'status.required' => '请选择状态！',
            ]);
        } catch (\Illuminate\Foundation\Validation\ValidationException $e) {
            $response = $e->getResponse();
            $errorContent = json_decode($response->getContent(), true);
            $errors = '';
            foreach ($errorContent as $errorMsgs) {
                foreach ($errorMsgs as $msg) {
                    $errors .= $msg . "<br>";
                }
            }
            error($errors);
        }

        if ($request->driving_id){
            $driving =  Post::find($request->driving_id);
        }else{
            $driving = new Lease();
        }
        $postData = $request->all();


        $driving->fill($postData);

        if ($driving->save())success('保存成功！');
        error('保存失败');
    }

    //删除驾校信息
    public function delete($info_id = null){

        if ($info_id){
            $drivingModel = Post::find($info_id);
            $drivingModel->status = 'recycled';
            if ($drivingModel->save())
                success('删除成功！');

        }
        error('参数错误！');

    }
}
