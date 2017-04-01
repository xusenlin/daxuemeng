<?php

namespace App\Http\Controllers\Admin\Life;

use App\Model\PartTimeJob;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    //兼职列表
    public function index(){

        $jobModel = new PartTimeJob();
        $jobs = $jobModel->paginate(PAGING_NUMBER_ADMIN);
        
        return view('admin.life.job_list')->with(['jobs'=>$jobs]);
    }
    
    //添加或者修改兼职视图
    public function add($job_id = null){
        $job = array();
        $job['job_id'] =   $job_id;
        if ($job_id){
            $job['title'] =   '修改兼职';
            $job['data'] = PartTimeJob::find($job_id);
        }else{
            $job['title'] =   '添加兼职';
        }
        
        return view('admin.life.job_add')->with(['job'=>$job]);
    }

    //保存兼职数据
    public function save(Request $request){
        try {
            $this->validate($request, [
                'name' => 'required',
                'position_type' => 'required',
                'contact' => 'required',
                'contact_phone' => 'required',
            ], [
                'name.required' => '企业名称必须填写！',
                'position_type.required' => '职位类别必须填写！',
                'contact.required' => '联系人必须填写！',
                'contact_phone.required' => '联系电话必须填写！',
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

        if ($request->job_id){
            $job =  PartTimeJob::find($request->job_id);
        }else{
            $job = new PartTimeJob();
        }

        $job->fill($request->all());

        if ($job->save())success('保存成功！');
        error('保存失败');
    }

    //删除兼职
    public function delete($job_id = null){
        if ($job_id){
            if (PartTimeJob::destroy($job_id))
            success('删除成功！');
        }
        error('参数错误！');
        
    }
}
