<?php

namespace App\Http\Controllers\Admin\Life;

use App\Model\Panorama;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PanoramaController extends Controller
{
    //
    public function index(){

        $panoramas = Panorama::limit(20)
            ->orderBy('created_at', 'desc')
            ->get();

        //dd($panorama);
        return view('admin.life.720_list')->with(['panoramas'=>$panoramas]);
    }
    
    public function add($id =null){

        
        $panorama = Panorama::find($id);

        return view('admin.life.720_add')->with(['panorama'=>$panorama]);
    }

    public function save(Request $request){

        try {
            $this->validate($request, [
                'name' => 'required',
                'cover' => 'required',
                'url' => 'required',

            ], [
                'name.required' => '720云名称必须填写！',
                'cover.required' => '封面必须上传！',
                'url.required' => '720云Url必须填写！！',
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

        $title = '';
        
        if (0 == $request->id){
            $model = new Panorama();
            $title = '720云添加成功';
        }else{
            $model = Panorama::find($request->id);
            $title = '720云修改成功';
        }

        $model->fill($request->all());
        
        if ($model->save())
            success($title);
        
        error('服务器出错');
    }
}
