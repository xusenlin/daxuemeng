<?php

namespace App\Http\Controllers\Admin\Category;

use App\Model\Category;
use App\Model\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $root = Category::where('name', '=', Category::ROOT_NAME)->first();

        $node = $root->getImmediateDescendants()->toArray();

        $rootCategory['data'] = $root->toArray();

        return view('admin.category.list')->with(['node'=>$node,'rootCategory'=>json_encode($rootCategory)]);
    }

    /**
     * 获取子节点
     * @param $id
     * @return mixed
     */
    public function getChildrenNode($id){

        $root = Category::find($id);

        $node = $root->getImmediateDescendants()->toArray();

        return $this->success($node);

    }

    /**
     * Show the form for creating a new resource.
     *添加子分类
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        try {
            $this->validate($request, [
                'id' => 'required',
                'name' => 'required',
                'description' => 'required',
            ], [
                'id.required' => '缺少父分类id！',
                'name.required' => '分类名字必须填写！',
                'description.required' => '分类描述必须填写！',

            ]);
        } catch (ValidationException $e) {
            return $this->error($this->format_exception_error($e));
        }

        $root = Category::find($request->id);

        $child = Category::create(['name' => $request->name,'description'=>$request->description]);
        $child->makeChildOf($root);

        return $this->success($child->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 修改分类
     * @param Request $request
     * @return array
     */
    public function edit(Request $request)
    {
        try {
            $this->validate($request, [
                'id' => 'required',
                'name' => 'required',
                'description' => 'required',
            ], [
                'id.required' => '缺少分类id！',
                'name.required' => '分类名字必须填写！',
                'description.required' => '分类描述必须填写！',

            ]);
        } catch (ValidationException $e) {
            return $this->error($this->format_exception_error($e));
        }

        $category = Category::find($request->id);

        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();
        return $this->success($category->id);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除分类
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
        return $this->success(Category::find($request->id)->delete());
    }
}
