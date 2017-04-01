<?php

namespace App\Http\Controllers\Admin\Life;

use App\Model\SecondaryMarket;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SecondaryController extends Controller
{
    //二手列表
    public function index(){

        $secondaryModel = DB::table('secondary_markets as s');
        $secondary = $secondaryModel->join('users as u','s.owner','=','u.id')
            ->select(
                's.id','s.name','s.title','s.description',
                's.tag','s.sale_price','s.total_qty','s.sale_qty',
                's.original_price','s.status','u.name as owner'
            )
            ->paginate(PAGING_NUMBER_ADMIN);


        return view('admin.life.secondary_list')->with(['secondary'=>$secondary]);
    }

    //添加或者修改二手视图
    public function add($secondary_id = null){
        $secondary = array();
        $secondary['secondary_id'] =   $secondary_id;
        if ($secondary_id){
            $secondary['title'] =   '修改二手产品';
            $secondary['data'] = SecondaryMarket::find($secondary_id);
        }else{
            $secondary['title'] =   '添加二手产品';
        }

        return view('admin.life.secondary_add')->with(['secondary'=>$secondary]);
    }

    //保存二手数据
    public function save(Request $request){

        try {
            $this->validate($request, [
                'name' => 'required',
                'owner' => 'required',
                'cover' => 'required',
                'tag' => 'required',
                'sale_price' => 'required',
                'total_qty' => 'required',
                'status' => 'required',
                'cellphone' => 'required',
                'images' => 'required',
            ], [
                'name.required' => '产品名称必须填写！',
                'owner.required' => '产品所有者必须填写！',
                'cover.required' => '封面图片必须上传！',
                'tag.required' => '标签必须填写！',
                'sale_price.required' => '产品单价必须填写！',
                'total_qty.required' => '产品数量必须填写！',
                'status.required' => '请选择产品状态！',
                'cellphone.required' => '联系电话必须填写！',
                'images.required' => '产品图片必须填写！',
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

        if ($request->secondary_id){
            $secondary =  SecondaryMarket::find($request->secondary_id);
        }else{
            $secondary = new SecondaryMarket();
        }
        $postData = $request->all();
        $postData['images'] = trim($postData['images'],',');

        $secondary->fill($postData);

        if ($secondary->save())success('保存成功！');
        error('保存失败');
    }

    //删除二手信息
    public function delete($secondary_id = null){
        if ($secondary_id){
            if (SecondaryMarket::destroy($secondary_id))
                success('删除成功！');
        }
        error('参数错误！');

    }
    
    
}
