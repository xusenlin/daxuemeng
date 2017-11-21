<?php

namespace App\Http\Controllers\Admin\Photo;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
    //
    public function swipe(){

        $swipes = file_get_contents(asset('Backend/json/swipePhoto.json'));
        $swipes = json_decode($swipes, true);

        return view('admin.photo.swipe')->with(['swipes'=>$swipes]);
    }
    
    public function swipe_add($name = null){
        
        $swipes = file_get_contents(asset('Backend/json/swipePhoto.json'));
        $swipes = json_decode($swipes, true);

        if ('null' == $name)
            return view('admin.photo.swipe_add');

        return view('admin.photo.swipe_add')->with(['name' => $name,'url'=>$swipes[$name]]);
    }
    
    public function swipe_save(Request $request){


        try {
            $this->validate($request, [
                'name' => 'required',
                'cover' => 'required',
            ], [
                'name.required' => '名称必须填写！',
                'cover.required' => '封面必须上传！',
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

        $swipes = file_get_contents(asset('Backend/json/swipePhoto.json'));
        $swipes = json_decode($swipes, true);

        //新增和储存


    }
}
