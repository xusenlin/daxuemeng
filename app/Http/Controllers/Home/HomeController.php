<?php

namespace App\Http\Controllers\Home;

use App\Model\Category;
use App\Model\Course;
use App\Model\Department;
use App\Model\Lease;
use App\Model\Major;
use App\Model\Panorama;
use App\Model\PartTimeJob;
use App\Model\Post;
use App\Model\School;
use App\Model\SecondaryMarket;
use App\Model\Student;
use App\Model\Timetable;
use App\Model\UserLeaseFlow;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\UserPhoto;
use App\Model\UserPhotoFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    //校园
    public function index()
    {

        $leagueId = Category::getAllSiblingsAndSelfId(Post::CATEGORY_ID_IS_LEAGUE);

        $league = Post::limit(20)
            ->whereIn('category_id',$leagueId)
            ->where('status','=','published')
            ->orderBy('is_top', 'desc')
            ->orderBy('id', 'desc')
            ->get();
        $zipai =DB::table('user_photos as p')
            ->join('users as u','u.id','=','p.user_id')
            ->limit(20)
            ->orderBy('p.created_at','desc')
            ->select('u.id as u_id','p.id','u.avatar','u.nickname','p.message','p.photo','p.city','u.sex','p.place')
            ->get();
        
        $panoramas = Panorama::limit(20)
            ->orderBy('created_at', 'desc')
            ->get();


        //$data['market'] = $market;
        $data['league'] = $league;
        $data['zipai'] = $zipai;
        $data['panoramas'] = $panoramas;

        $viewName = isMobile() ? 'mobile.world':'home';
        return view($viewName)->with(['data'=>$data]);
    }

    //发表
    public function publish(){
        
        return view('mobile.publish');
    }
    //帖子
    public function post(){
//        $postModel = DB::table('posts as p')
//            ->join('user as u','u.id','=','p.')
//            ->select()
//            ->limit(20)
//            ->get();
        return view('mobile.post');
    }

    //生活
    public function life(){
        $foodId = Category::getAllSiblingsAndSelfId(Post::CATEGORY_ID_IS_FOOD);
        $food =Post::whereIn('category_id',$foodId)
            ->where('status','=','published')
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();
        $lease = Lease::limit(30)
            ->get();
        $jobs = PartTimeJob::limit(30)
            ->orderBy('created_at', 'desc')
            ->get();
        $market = SecondaryMarket::limit(30)
            ->orderBy('created_at', 'desc')
            ->get();

        $school = School::all()->toArray();
        $department = Department::all()->toArray();
        $majors = Major::all()->toArray();

        $data['tree'] = $this->orderSchoolDepartmentMajorsToTree($school,$department,$majors);
        
        
        $data['food'] = $food;
        $data['lease'] = $lease;
        $data['jobs'] = $jobs;
        $data['market'] = $market;
        return view('mobile.life')->with(['data'=>$data]);
    }
    //我的
    public function mine(){
        return view('mobile.mine');
    }
    //个人详情
    public function personal(){
        $data =array();

        $student = Student::where('user_id','=',get_login_user())->first();
        $data['student'] = $student ? $student->toArray() : '';
        $school = School::all()->toArray();
        $department = Department::all()->toArray();
        $majors = Major::all()->toArray();

        $data['tree'] = $this->orderSchoolDepartmentMajorsToTree($school,$department,$majors);

     
        return view('mobile.personal')->with(['data'=>$data]);
    }

    //post详情页
    public function details($id = null){
        if (!$id)
            \App::abort(404);
        $post = Post::find($id);
        return view('mobile.details_post')->with(['data'=>$post]);
    }

    //兼职详情页面
    public function details_job($id = null){
        if (!$id)
            \App::abort(404);
        $job = PartTimeJob::find($id);
        return view('mobile.details_job')->with(['data'=>$job]);
    }
    
    //课程列表
    public function courses_list($id = null){
        if (!$id)
            \App::abort(404);
        
        $gradeAndClassList = DB::table('courses as c')
            ->where('c.major_id','=',$id)
            ->leftJoin('timetables as t','c.id','=','t.course_id')
            ->orderBy('t.grade', 'asc')
            ->orderBy('t.class', 'asc')
            ->select(DB::raw('DISTINCT c.major_id,t.grade,t.class,c.school,c.department,c.major'))
            ->get();

        if (!$gradeAndClassList)dd('后台没有配置课程表！');

        $data =array();
        $data['major_id'] =  $gradeAndClassList[0]->major_id;
        $data['name'] = $gradeAndClassList[0]->school.'>'.$gradeAndClassList[0]->department.'>'.$gradeAndClassList[0]->major;
        foreach ($gradeAndClassList as $value){
            $data['grade_and_class'][$value->grade][] = $value->class;
        }

      
        return view('mobile.courses_list')->with(['data'=>$data]);
    }
    //课程表选择
    public function courses_details($id = null){
        if (!$id)
            \App::abort(404);
        
        $courses = Timetable::where('course_id','=',$id)
            ->first();
        success('获取课程表详情成功！',$courses);
    }
    //课程表详情
    public function timetables($major_id = null,$grade=null,$class = null){

        $timeTable = DB::table('timetables as t')
            ->leftJoin('courses as c','c.id','=','t.course_id')
            ->where('c.major_id','=',$major_id)
            ->where('t.grade','=',$grade)
            ->where('t.class','=',$class)
            ->orderBy('t.weekday', 'asc')
            ->orderBy('t.start_time', 'asc')
            ->get();

        $newTimeTable = array();
        foreach ($timeTable as $value){
            $newTimeTable[$value->weekday][] = $value;
        }

        //dd($newTimeTable);
        $color = array('81cff9','adbeff','e6a6f5','fdc081','d5aef6','c3b5f6','a3e866','ff9f9f','ffc362','ffe062','fbaece','e5e376','81def9','5fe58a','faa1b5');

        return view('mobile.timetable')->with(['data'=>$newTimeTable,'color'=>$color]);
    }
    //自拍详情页
    public function details_photo($id = null){
        if (!$id)
            \App::abort(404);

        $photoModel = DB::table('user_photos as p')
            ->where('p.id','=',$id)
            ->Leftjoin('users as u','p.user_id','=','u.id')
            ->select(
                'p.id as p_id','p.message as p_message','p.photo as p_photo','p.place as p_place',
                'u.id as u_id','u.nickname as u_nickname','u.avatar as u_avatar','u.sex as u_sex','u.signature as u_signature'
            )->first();
        
        $comments = DB::table('user_photo_comments as c')
            ->where('c.photo_id','=',$id)
            ->Leftjoin('users as u','c.author','=','u.id')
            ->select(
                'c.id as c_id','c.content as c_content','c.reply_to as c_reply_to','u.id as u_id','u.nickname as u_nickname','u.avatar as u_avatar','u.sex as u_sex','u.signature as u_signature'
            )->get();
        
        return view('mobile.details_photo')->with(['data'=>$photoModel,'comments'=>$comments]);
    }
    //租赁详情页
    public function details_lease($id = null){
        if (!$id)
            \App::abort(404);
        $lease = DB::table('leases as l')
            ->where('l.id','=',$id)
            ->Leftjoin('users as u','l.owner','=','u.id')
            ->select(
                'l.id as l_id','l.title as l_title','l.description as l_description','l.tag as l_tag','l.unit_price as l_unit_price','l.total_qty as l_total_qty','l.sale_qty as l_sale_qty',
                'l.cellphone as l_cellphone','l.images as l_images','u.id as u_id','u.nickname as u_nickname','u.avatar as u_avatar','u.sex as u_sex','u.signature as u_signature'
            )->first();
        $comments = DB::table('user_lease_comments as c')
            ->where('c.lease_id','=',$id)
            ->Leftjoin('users as u','c.author','=','u.id')
            ->select(
                'c.id as c_id','c.content as c_content','c.reply_to as c_reply_to','u.id as u_id','u.nickname as u_nickname','u.avatar as u_avatar','u.sex as u_sex','u.signature as u_signature'
            )->get();
        $love = UserLeaseFlow::where('lease_id','=',$id)
            ->where('user_id','=',get_login_user('id'))
            ->where('type','=','favorite')
            ->first();
        return view('mobile.details_lease')->with(['data'=>$lease,'comments'=>$comments,'favorite'=>$love?true:false]);
    }
    //二手市场详情页
    public function details_market($id = null){
        if (!$id)
            \App::abort(404);
        $market = DB::table('secondary_markets as s')
            ->where('s.id','=',$id)
            ->Leftjoin('users as u','s.owner','=','u.id')
            ->select(
                's.id as s_id','s.title as s_title','s.description as s_description','s.tag as s_tag','s.original_price as s_original_price','s.sale_price as s_sale_price','s.total_qty as s_total_qty','s.sale_qty as s_sale_qty',
                's.cellphone as s_cellphone','s.images as s_images','u.id as u_id','u.nickname as u_nickname','u.avatar as u_avatar','u.sex as u_sex'
            )->first();
        
        return view('mobile.details_market')->with(['data'=>$market]);
    }

    //我的照片
    public function my_photo(){

        $record = UserPhoto::where('user_id','=',get_login_user())
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('mobile.my_photo')->with(['records'=>$record->toArray()]);
    }
    public function password_update_view(){
        
        return view('mobile.password_update');
        
    }

    /**
     * 密码修改
     * @param Request $request
     */
    public function password_update(Request $request){

        $formData = $request->all();

        if (!($formData['new_password'] == $formData['new_password_r'])){
            session(['password_update_error' => '两次输入的新密码不一致！']);
            return redirect()->back()->withErrors(['error'=>"两次输入的新密码不一致！"]);
        }

        if ($formData['new_password'] == $formData['password']){
            session(['password_update_error' => '新旧密码一样！']);
            return redirect()->back()->withErrors(['error'=>"新旧密码一样！"]);
        }
            

        if (strlen(trim($formData['new_password']))<6){
            
            session(['password_update_error' => '输入的新密码必须大于等于6位！']);
            return redirect()->back()->withErrors(['error'=>"输入的新密码必须大于等于6位！"]);

        }

        $user = Auth::user();
        $app = app();
        if( ! $app['hash']->check($formData['password'], $user->getAuthPassword())){
            session(['password_update_error' => '原始密码不正确！']);
            return redirect()->back()->withErrors(['password'=>"原始密码不正确！"]);

        }

        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['password' => bcrypt($formData['new_password'])]);

        return redirect('/logout');
    }

    /**
     * 我收藏的照片
     */
    public function my_collect(){

        $flow = UserPhotoFlow::where('user_id','=',get_login_user())
            ->where('type','=','collect')
            ->orderBy('created_at', 'desc')
            ->select('photo_id')
            ->get();

        if(!$flow->toArray())
            return view('mobile.my_collect');

        $photo_id = array();
        foreach ($flow->toArray() as $value){
            $photo_id[] = $value['photo_id'];
        }

        $zipai =DB::table('user_photos as p')
            ->whereIn('p.id',$photo_id)
            ->join('users as u','u.id','=','p.user_id')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->select('u.id as u_id','p.id','u.avatar','u.nickname','p.message','p.photo','p.city','u.sex')
            ->get();
        
        
        
        return view('mobile.my_collect')->with(['zipai'=>$zipai]);
    }


    private function orderSchoolDepartmentMajorsToTree($school,$department,$majors){

        if (!$school)
            return [];

        $newArray = array();

        foreach ($school as $item){
            $newArray[$item['id']] = ["name" => $item['name']];
        }
        foreach ($department as $item){
            $newArray[$item['school_id']]['department'][$item['id']] =  ["name" => $item['name']];
        }
        foreach ($majors as $item){
            $newArray[$item['school_id']]['department'][$item['department_id']]['majors'][$item['id']] =  ["name" => $item['name']];
        }
        
        return $newArray;
    }


}
