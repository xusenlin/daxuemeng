<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    //添加图片
    public function photo_add(Request $request){

        //使用API 传来的name必须是photo
        $photo = $request->file('photo');

        // 图片验证
        $input = array('image' => $photo);
        $rules = array(
            'image' => 'image'
        );
        // 自动验证
        $validator = Validator::make($input, $rules);
        // 失败处理
        if ($validator->fails()) return Response::json([
            'error' => 'Please choose a picture.'
        ]);
        // 移动目录地址
        $destinationPath = 'uploads/photos/';
        // 获取图片文件名
        $filename = Auth::user()->id . '_' . time() . $photo->getClientOriginalName();

        // 移动图片
        $photo->move($destinationPath, $filename);

        $filename = img_scale(public_path($destinationPath . $filename),296,197);

        return Response::json([
            'filename' => str_replace(public_path(),'', $filename)
        ]);
    }
}
