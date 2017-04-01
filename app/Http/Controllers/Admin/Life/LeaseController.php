<?php

namespace App\Http\Controllers\Admin\Life;

use App\Model\Lease;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LeaseController extends Controller
{
    //租赁列表
    public function index(){

        $leaseModel = DB::table('leases as l');
        $leases = $leaseModel->join('users as u','l.owner','=','u.id')
            ->select(
                'l.id','l.name','l.title','l.description',
                'l.tag','l.unit_price','l.total_qty','l.sale_qty',
                'l.left_qty','l.status','u.name as owner'
            )
            ->paginate(PAGING_NUMBER_ADMIN);

        return view('admin.life.lease_list')->with(['leases'=>$leases]);
    }

    //添加或者修改租赁视图
    public function add($lease_id = null){
        $lease = array();
        $lease['lease_id'] =   $lease_id;
        if ($lease_id){
            $lease['title'] =   '修改租赁';
            $lease['data'] = Lease::find($lease_id);
        }else{
            $lease['title'] =   '添加租赁';
        }

        return view('admin.life.lease_add')->with(['lease'=>$lease]);
    }

    //保存租赁数据
    public function save(Request $request){

        try {
            $this->validate($request, [
                'name' => 'required',
                'owner' => 'required',
                'cover' => 'required',
                'tag' => 'required',
                'unit_price' => 'required',
                'total_qty' => 'required',
                'status' => 'required',
                'cellphone' => 'required',
                'images' => 'required',
            ], [
                'name.required' => '产品名称必须填写！',
                'owner.required' => '产品所有者必须填写！',
                'cover.required' => '封面图片必须上传！',
                'tag.required' => '标签必须填写！',
                'unit_price.required' => '租赁单价必须填写！',
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

        if ($request->lease_id){
            $lease =  Lease::find($request->lease_id);
        }else{
            $lease = new Lease();
        }
        $postData = $request->all();
        $postData['images'] = trim($postData['images'],',');

        $lease->fill($postData);

        if ($lease->save())success('保存成功！');
        error('保存失败');
    }

    //删除租赁
    public function delete($lease_id = null){
        if ($lease_id){
            if (Lease::destroy($lease_id))
                success('删除成功！');
        }
        error('参数错误！');

    }

}
