<?php

namespace App\Http\Controllers\Admin;

use App\Model\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OtherController extends Controller
{
    //文章回收站列表
    public function recycle_bin(){
        $postModel = new Post();
        $posts = $postModel->where('status','=','recycled')
            ->paginate(PAGING_NUMBER_ADMIN);

        return view('admin.recycle_bin')->with(['posts'=>$posts]);
    }

    //恢复文章
    public function recover_post($post_id){

        if ($post_id){
            $postModel = Post::find($post_id);
            $postModel->status = 'draft';
            if ($postModel->save())
                success('恢复成功！');
        }
        error('参数错误！');
    }

}
