<?php

namespace App\Http\Controllers\Admin\Post;


use App\Model\Category;
use App\Model\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index($id = null){

        $post = DB::table('posts as p')->where('p.status','<>','recycled');
        if ($id){
            $post->where('p.category_id','=',$id);
        }
        $posts = $post->leftJoin('categories as c','c.id','=','p.category_id')
            ->orderBy('p.is_top', 'desc')
            ->orderBy('p.id', 'desc')
            ->select('p.*','c.name as category_name')
            ->paginate(PAGING_NUMBER_ADMIN);

        $activeInfo=array(
            'active'=>'文章管理',
            'highlight'=>'文章列表'
        );

        $root = Category::find(Category::ROOT_CATEGORY_ID);
        $category = $root->getDescendants();

        return view('admin.post.list')->with(['posts'=>$posts,'activeInfo'=>$activeInfo,'categorys'=>$category,'id'=>$id]);
    }


    public function edit($id = null){
        $post = array();
        $post['id'] = $id;
        if ($id){
            $post['title'] =   '修改文章信息';
            $post['data'] = Post::find($id);
        }else{
            $post['title'] =   '添加文章信息';
        }


        $root = Category::find(Category::ROOT_CATEGORY_ID);
        $category = $root->getDescendants();

        return view('admin.post.edit')->with(['post'=>$post,'categorys'=>$category]);
    }


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

        if ($request->id){
            $post =  Post::find($request->id);
        }else{
            $post = new Post();
        }
        $postData = $request->all();
        $postData['meta_data'] = trim($postData['meta_data'],',');

        $post->fill($postData);

        if ($post->save())success('保存成功！');
        error('保存失败');
    }


    public function delete($id = null){

        if ($id){
            $postModel = Post::find($id);
            $postModel->status = 'recycled';
            if ($postModel->save())
                success('删除成功！');

        }
        error('参数错误！');

    }
}
