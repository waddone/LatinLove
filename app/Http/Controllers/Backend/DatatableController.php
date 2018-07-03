<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Franchise;
use App\DanceClass;
use App\Teacher;
use App\Course;
use App\Payment;
use App\Service;
use App\Plan;
use App\Level;
use App\Event;
use App\Quote;
use App\Blog;
use App\Booking;
use App\Friend;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;


class DatatableController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //$this->middleware('auth')->except(['danceClasses', 'events', 'aboutUs','franchise', 'contact']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public static function CourseInfoId($course_idxxx) {
        
        $course_r = Course::where('id','=',$course_idxxx)->first();  
         
        //return '<span class="normalDt">'.$course_r->planName().' - '.$course_r->level().' start: '.substr($course_r->started_on,0,10).' - end: '.substr($course_r->ended_on,0,10).'</span>';
        return '<span class="normalDt">'.$course_r->planName().' - <span class="displayBlockMob">'.$course_r->level().'</span>';

    }
    
    public function datatableFranchise() {

        //$franchise_c      = Franchise::all();
        $countulos          = Franchise::count();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $location_search    = $_GET['columns']['3']['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (name LIKE '%{$exploded_data[$i]}%')";
            }
        }

        if($location_search != null) {
            $exploded_data = explode(' ', $location_search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (city LIKE '%{$exploded_data[$i]}%')";
            }
        }
        
        // 
        //$franchise_c = DB::select( DB::raw("SELECT * FROM franchises WHERE active = 'yes' $sql_search ORDER BY id ASC LIMIT $start,$limit") );
        // varianta simplificata
        //
        $franchise_c    = DB::table('franchises')
                            ->where('active','=', 'yes')
                            ->orderBy('id', 'asc')
                            ->skip($start)
                            ->take($limit)
                            ->get();

        foreach ($franchise_c as $franchise_r) {

            $location   = $franchise_r->city.' - '.$franchise_r->country.' - '.$franchise_r->zipcode;
            $created_at = substr($franchise_r->created_at, 0, 10);
         
            $data[] = array(
                'all'               => '<input type="checkbox" id="checkMe" class="checkme" name="check_'.$franchise_r->id.'" data-valId="'.$franchise_r->id.'">',
                'img'               => 'img',
                'franchise'         => $franchise_r->name,
                'location'          => $location,
                'created_at'        => $created_at
            );

        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;


        return $detalii; 

    }

    //datatable-dance-classes
    public function datatableDanceClasses() {

        //$franchise_c      = Franchise::all();
        $user_logat_r       = Auth::user();
        //$countulos          = DanceClass::where('user_id','=',$user_logat_r->id)->count();
        $countulos          = $user_logat_r->DanceClasses->count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "WHERE (name LIKE '%{$exploded_data[$i]}%')";
            }
        }

        //$dance_classes_c = DB::select( DB::raw("SELECT * FROM dance_classes $sql_search ORDER BY active ASC, id DESC LIMIT $start,$limit") );
        // se va inlocuiii cu 
        $dance_classes_c    =   DanceClass::orderBy('order_nr', 'asc')
                                ->skip($start)
                                ->take($limit)
                                ->get();

        foreach ($dance_classes_c as $dance_classes_r) {

            if($dance_classes_r->active == 'yes') {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="DanceClass" data-dowhat="edit" data-id="'.$dance_classes_r->id.'">edit</button> <button class="btn btn-sm btn-danger openSaysMe" data-modal="DanceClass" data-dowhat="delete" data-id="'.$dance_classes_r->id.'">delete</button>';
                $status = '<i class="fa fa-play"></i> active';
            }
            else {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="DanceClass" data-dowhat="edit" data-id="'.$dance_classes_r->id.'">edit</button> <button class="btn btn-sm btn-warning openSaysMe" data-modal="DanceClass" data-dowhat="activate" data-id="'.$dance_classes_r->id.'">activate</button>';
                $status = '<i class="fa fa-pause"></i> inactive';
            }

            $image = '';
            if($dance_classes_r->image1 != '') {
                $image = '<a class="openSaysMe" data-modal="DanceClass" data-dowhat="img" data-id="'.$dance_classes_r->id.'"><img src="'.url('/').'/'.$dance_classes_r->image1.'" class="imgDt"></a>';
            } else {
                $image = '<img src="'.url('/').'/resources/assets/uploads/noimg.png" class="imgDt">';
            }
     
            $data[] = array(
                'image'             => $image,
                'name'              => $dance_classes_r->name,
                'order'             => $dance_classes_r->order_nr,
                'status'            => $status,
                'description'       => '<button class="btn btn-sm btn-primary openSaysMe" data-modal="DanceClass" data-dowhat="see" data-id="'.$dance_classes_r->id.'">see description</button>',
                'actions'           => $action
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableServices() {

        //$franchise_c      = Franchise::all();
        $user_logat_r       = Auth::user();
        $school_id          = config('app.school_id');
        //$countulos          = DanceClass::where('user_id','=',$user_logat_r->id)->count();
        $countulos          = Service::where('school_id','=',$school_id)->count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "WHERE (title LIKE '%{$exploded_data[$i]}%')";
            }
        }

        //$dance_classes_c = DB::select( DB::raw("SELECT * FROM dance_classes $sql_search ORDER BY active ASC, id DESC LIMIT $start,$limit") );
        // se va inlocuiii cu 
        $services_c    =   Service::orderBy('id', 'asc')
                                ->skip($start)
                                ->take($limit)
                                ->get();

        foreach ($services_c as $services_r) {

            if($services_r->status == 'active') {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Service" data-dowhat="edit" data-id="'.$services_r->id.'">edit</button> <button class="btn btn-sm btn-danger openSaysMe" data-modal="Service" data-dowhat="delete" data-id="'.$services_r->id.'">delete</button>';
                $status = '<i class="fa fa-play"></i> active';
            }
            else {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Service" data-dowhat="edit" data-id="'.$services_r->id.'">edit</button> <button class="btn btn-sm btn-warning openSaysMe" data-modal="Service" data-dowhat="activate" data-id="'.$services_r->id.'">activate</button>';
                $status = '<i class="fa fa-pause"></i> inactive';
            }

            $image = '';
            if($services_r->image != '') {
                $image = '<img src="'.url('/').'/'.$services_r->image.'" class="imgDt">';
            } else {
                $image = '<img src="'.url('/').'/resources/assets/uploads/noimg.png" class="imgDt">';
            }
     
            $data[] = array(
                'name'              => $services_r->title,
                'image'             => $image,
                'status'            => $status,
                'description'       => '<button class="btn btn-sm btn-primary openSaysMe" data-modal="DanceClass" data-dowhat="see" data-id="'.$services_r->id.'">see description</button>',
                'actions'           => $action
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatablePlans() {

        //$franchise_c      = Franchise::all();
        $user_logat_r       = Auth::user();
        $school_id          = config('app.school_id');
        //$countulos          = DanceClass::where('user_id','=',$user_logat_r->id)->count();
        $countulos          = Plan::where('school_id','=',$school_id)->count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "WHERE (name LIKE '%{$exploded_data[$i]}%')";
            }
        }

        $plans_c    =   Plan::orderBy('id', 'asc')
                                ->skip($start)
                                ->take($limit)
                                ->get();

        foreach ($plans_c as $plans_r) {

            if($plans_r->status == 'active') {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Plan" data-dowhat="edit" data-id="'.$plans_r->id.'">edit</button> <button class="btn btn-sm btn-danger openSaysMe" data-modal="Plan" data-dowhat="delete" data-id="'.$plans_r->id.'">delete</button>';
                $status = '<i class="fa fa-play"></i> active';
            }
            else {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Plan" data-dowhat="edit" data-id="'.$plans_r->id.'">edit</button> <button class="btn btn-sm btn-warning openSaysMe" data-modal="Plan" data-dowhat="activate" data-id="'.$plans_r->id.'">activate</button>';
                $status = '<i class="fa fa-pause"></i> inactive';
            }
     
            $data[] = array(
                'name'              => $plans_r->name.'<span class="hidden-md hidden-lg displayBlockMob">'.$plans_r->price.' '.$plans_r->currency.'</span>',
                'type'              => $plans_r->type,
                'price'             => $plans_r->price.' '.$plans_r->currency,
                'status'            => $plans_r->status,
                'actions'           => $action
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableLevels() {

        //$franchise_c      = Franchise::all();
        $user_logat_r       = Auth::user();
        $school_id          = config('app.school_id');
        //$countulos          = DanceClass::where('user_id','=',$user_logat_r->id)->count();
        $countulos          = Level::where('school_id','=',$school_id)->count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "WHERE (name LIKE '%{$exploded_data[$i]}%')";
            }
        }

        //$dance_classes_c = DB::select( DB::raw("SELECT * FROM dance_classes $sql_search ORDER BY active ASC, id DESC LIMIT $start,$limit") );
        // se va inlocuiii cu 
        $level_c    =   Level::orderBy('id', 'asc')
                                ->where('school_id','=',$school_id)
                                ->skip($start)
                                ->take($limit)
                                ->get();

        foreach ($level_c as $level_r) {

            if($level_r->status == 'active') {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Level" data-dowhat="edit" data-id="'.$level_r->id.'">edit</button> <button class="btn btn-sm btn-danger openSaysMe" data-modal="Level" data-dowhat="delete" data-id="'.$level_r->id.'">delete</button>';
                $status = '<i class="fa fa-play"></i> active';
            } else {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Level" data-dowhat="edit" data-id="'.$level_r->id.'">edit</button> <button class="btn btn-sm btn-warning openSaysMe" data-modal="Level" data-dowhat="activate" data-id="'.$level_r->id.'">activate</button>';
                $status = '<i class="fa fa-pause"></i> inactive';
            }

            $data[] = array(
                'name'              => $level_r->name,
                'status'            => $status,
                'actions'           => $action
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableDanceCourses() {
        
        $user_logat_r       = Auth::user();
        $countulos          = $user_logat_r->DanceCoursesCount();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "WHERE (name LIKE '%{$exploded_data[$i]}%')";
            }
        }

        $course_c   =  Course::orderBy('active', 'asc')
                        ->orderBy('id', 'asc')
                        ->skip($start)
                        ->take($limit)
                        ->get();

        foreach ($course_c as $course_r) {

            if($course_r->active == 'yes') {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Course" data-dowhat="edit" data-id="'.$course_r->id.'">edit</button> <button class="btn btn-sm btn-danger openSaysMe" data-modal="Course" data-dowhat="delete" data-id="'.$course_r->id.'">delete</button>';
                $status = '<i class="fa fa-play"></i> active';
            }
            else {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Course" data-dowhat="edit" data-id="'.$course_r->id.'">edit</button> <button class="btn btn-sm btn-warning openSaysMe" data-modal="Course" data-dowhat="activate" data-id="'.$course_r->id.'">activate</button>';
                $status = '<i class="fa fa-pause"></i> inactive';
            }
     
            $data[] = array(
                'name'              => $course_r->PlanName().' - '.$course_r->Level().'<br/><span class="normalDt"> start: '.substr($course_r->started_on, 0, 10).' - end: '.substr($course_r->ended_on, 0, 10).'</span>',
                'status'            => $status,
                'description'       => '<button class="btn btn-sm btn-primary openSaysMe" data-modal="Course" data-dowhat="see" data-id="'.$course_r->id.'">see details</button>',
                'actions'           => $action
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableDanceCoursesU() {
        
        $user_logat_r       = Auth::user();
        $countulos          = $user_logat_r->DanceCoursesCount();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "WHERE (name LIKE '%{$exploded_data[$i]}%')";
            }
        }

        $course_c   =  Course::orderBy('active', 'asc')
                        ->orderBy('id', 'asc')
                        ->skip($start)
                        ->take($limit)
                        ->get();

        foreach ($course_c as $course_r) {

            
            $user_logat_r   = Auth::user();
            $plans_r        = Plan::where('id','=',$course_r->plan_id)->first();
            $subscription_r = Subscription::where('user_id','=',$user_logat_r->id)->where('course_id','=',$course_r->id)->first();

            if(is_object($subscription_r)) {
                $until_when_time = $subscription_r->until_when.' 00:00:00';
                if(strtotime($until_when_time) >= strtotime(date('Y-m-d H:i:s'))) {
                    if($subscription_r->status == 'active') {
                        $action = 'you are subscribed <span class="hidden-xs hidden-sm">to this course until: <span style="color:green;font-weight:bold;">'.$subscription_r->until_when.'</span></span>';
                    } else {
                        $action = '<span style="color:green;font-weight:bold;">subscription in pending </span>';
                    }
                } else {
                    $action = '<button class="btn btn-sm btn-primary openSaysMe" data-modal="Course" data-dowhat="booknow" data-id="'.$course_r->id.'">Subscribe now</button>';
                }
            } else {
                $action = '<button class="btn btn-sm btn-primary openSaysMe" data-modal="Course" data-dowhat="booknow" data-id="'.$course_r->id.'">Subscribe now</button>';
            }
     
            $data[] = array(
                'name'              => $course_r->PlanName().'<span class="hidden-xs hidden-sm>" - '.$course_r->Level().'</span><br/><span class="normalDt"> start: '.substr($course_r->started_on, 0, 10).' -<span class="displayBlockMob"> end: '.substr($course_r->ended_on, 0, 10).'</span></span>',
                'type'              => $plans_r->type,
                'price'             => $plans_r->price.' '.$plans_r->currency,
                'timetable'         => '<button class="btn btn-sm btn-primary openSaysMe" data-modal="Course" data-dowhat="timetable" data-id="'.$course_r->id.'">Timetable</button>',
                'actions'           => $action
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableDanceCoursesPrize() {
        
        $user_logat_r       = Auth::user();
        $countulos          = $user_logat_r->DanceCoursesCount();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "WHERE (name LIKE '%{$exploded_data[$i]}%')";
            }
        }

        $course_c   =  Course::orderBy('active', 'asc')
                        ->orderBy('id', 'asc')
                        ->skip($start)
                        ->take($limit)
                        ->get();

        foreach ($course_c as $course_r) {

            
            $user_logat_r   = Auth::user();
            $plans_r        = Plan::where('id','=',$course_r->plan_id)->first();
            $subscription_r = Subscription::where('user_id','=',$user_logat_r->id)->where('course_id','=',$course_r->id)->first();
     
            $data[] = array(
                'name'              => $course_r->PlanName().'<span class="hidden-xs hidden-sm>" - '.$course_r->Level().'</span><br/><span class="normalDt"> start: '.substr($course_r->started_on, 0, 10).' -<span class="displayBlockMob"> end: '.substr($course_r->ended_on, 0, 10).'</span></span>',
                'type'              => $plans_r->type,
                'price'             => $plans_r->price.' '.$plans_r->currency,
                'timetable'         => '<button class="btn btn-sm btn-primary openSaysMe" data-modal="Course" data-dowhat="timetable" data-id="'.$course_r->id.'">Timetable</button>',
                'actions'           => '<button class="btn btn-sm btn-primary openSaysMe" data-modal="Course" data-dowhat="claim" data-id="'.$course_r->id.'">Claim free month</button>'
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }
    //datatable-teachers
    public function datatableTeachers() {

        //$franchise_c      = Franchise::all();
        $user_logat_r       = Auth::user();
        //$countulos          = Teacher::where('school_id','=',$user_logat_r->returnSchoolId())->count();
        $countulos          = $user_logat_r->School->TeacherCount();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (name LIKE '%{$exploded_data[$i]}%')";
            }
        }
        
        $teachers_c   =  Teacher::where('school_id','=',$user_logat_r->returnSchoolId())
                        ->orderBy('active', 'asc')
                        ->orderBy('id', 'desc')
                        ->groupBy('user_id')
                        ->skip($start)
                        ->take($limit)
                        ->get();

        foreach ($teachers_c as $teachers_r) {

            $danceCourses  = '';
            $course_r      = Course::where('id','=', $teachers_r->course_id)->first();
            $user_r        = User::where('id','=',$teachers_r->user_id)->first();
            
            if($user_r->profile_image != '') {
                $image = '<a class="openSaysMe" data-modal="User" data-dowhat="img" data-id="'.$user_r->id.'"><img src="'.url('/').'/'.$user_r->profile_image.'" class="imgDt"></a>';
            } else {
                $image = '<img src="'.url('/').'/resources/assets/uploads/noimg.png" class="imgDt">';
            }

            if($teachers_r->active == 'yes') {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Teacher" data-dowhat="edit" data-id="'.$teachers_r->id.'">edit</button> <button class="btn btn-sm btn-danger openSaysMe" data-modal="Teacher" data-dowhat="delete" data-id="'.$teachers_r->id.'">delete</button><button class="btn btn-sm btn-danger openSaysMe" data-modal="Teacher" data-dowhat="description" data-id="'.$teachers_r->id.'">Edit profile</button>';
                $status = '<i class="fa fa-play"></i> active';
            }
            else {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Teacher" data-dowhat="edit" data-id="'.$teachers_r->id.'">edit</button> <button class="btn btn-sm btn-warning openSaysMe" data-modal="Teacher" data-dowhat="activate" data-id="'.$teachers_r->id.'">activate</button><button class="btn btn-sm btn-danger openSaysMe" data-modal="Teacher" data-dowhat="description" data-id="'.$teachers_r->id.'">Edit profile</button>';
                $status = '<i class="fa fa-pause"></i> inactive';
            }
     
            $data[] = array(
                'image'             => $image,
                'name'              => $teachers_r->name,
                'danceclass'        => $teachers_r->danceClAssesIn(),
                'status'            => $status,
                'actions'           => $action
            );


        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableSchoolStudents() {

        $user_logat_r       = Auth::user();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $group_search       = $_GET['columns']['1']['search']['value'];
        $status_search      = $_GET['columns']['2']['search']['value'];
        $level_search       = $_GET['columns']['3']['search']['value'];
        $gender_search      = $_GET['columns']['4']['search']['value'];

        if(!$status_search) {
            $sql_search_operator = '!=';
            $sql_search_where    = 'muie'; 
        }
        if($status_search == 'subscribed' ) {
            $sql_search_operator = '=';
            $sql_search_where = 'subscribed';
        }
        if($status_search == 'unsubscribed' ) {
            $sql_search_operator = '=';
            $sql_search_where = 'unsubscribed';
        }

        if(!$gender_search) {
            $sql_search_operator_gender = '!=';
            $sql_search_where_gender    = 'muie'; 

        }
        if($gender_search == 'male' ) {
            $sql_search_operator_gender = '=';
            $sql_search_where_gender = 'male';
        }
        if($gender_search == 'female' ) {
            $sql_search_operator_gender = '=';
            $sql_search_where_gender = 'female';
        }
       
        $countulos          = User::where('school_id','=',$user_logat_r->returnSchoolId())
                                ->where('removed','=', NULL)
                                ->where('level','!=','admin')
                                ->where('level','!=','teacher')
                                ->where('level','!=','none')
                                ->where('name', 'like', $search.'%')
                                ->where('courses_id', 'like', '%'.$group_search.'%')
                                ->where('status', $sql_search_operator, $sql_search_where)
                                ->where('level', 'like', '%'.$level_search.'%')
                                ->where('gender', $sql_search_operator_gender, $sql_search_where_gender)
                                ->orderBy('id', 'desc')
                                ->skip($start)
                                ->take($limit)
                                ->count();
        $user_c             =  User::where('school_id','=',$user_logat_r->returnSchoolId())
                                ->where('removed','=', NULL)
                                ->where('level','!=','admin')
                                ->where('level','!=','teacher')
                                ->where('level','!=','none')
                                ->where('name', 'like', $search.'%')
                                ->where('courses_id', 'like', '%'.$group_search.'%')
                                ->where('status', $sql_search_operator, $sql_search_where)
                                ->where('level', 'like', '%'.$level_search.'%')
                                ->where('gender', $sql_search_operator_gender, $sql_search_where_gender)
                                ->orderBy('name', 'asc')
                                ->skip($start)
                                ->take($limit)
                                ->get();
        $x = 0;
        foreach ($user_c as $user_r) {

            $points = $user_r->puncte.' points';
            $action = 'actiuni';
            $status = '';
            $x      = $x + 1;
            $yyy    = 0;
            $comment_color = 'warning';
            if($user_r->comments != '') {
                $comment_color = 'success';
            }
            if(sizeof($user_r->Subscription) >= 1) {
                $userSubscripton = '';
                $active = '';
                foreach ($user_r->Subscription as $Subscription) {
                    if (strtotime(date("Y-m-d H:i:s")) < strtotime($Subscription->until_when.' 00:00:00')) {
                        $userSubscripton .= '<span class="normalDt">active - <span class="displayBlockMob">'.self::CourseInfoId($Subscription->course_id).' </span></span><br/><span class="successDt">Subscription ends <span class="displayBlockMob">on :'.$Subscription->until_when.'</span></span><br/>';
                        $active .= 'xxx'; 
                    }
                }
            } else {
                $active = 'yyy';
            }

            if($active == '') {
                $userSubscripton = 'inactive<br/><span class="warningDt">Subscription ended on '.$Subscription->until_when.'</span>';
            }
            if($active == 'yyy') {
                $userSubscripton = 'inactive<br/><span class="warningDt">not subscribed yet</span>';
            }
            if($active == 'xxx') {
                $userSubscripton = $userSubscripton;
            }
             
            $data[] = array(
                'nr'                => $x,
                'name'              => $user_r->name.'<br/><span class="displayBlockMob"> '.$points.'</span>',
                'status'            => $userSubscripton,
                'level'             => '<span class="normalDt">'.$user_r->level.'</span>',
                'actions'           => '<button class="btn btn-sm btn-warning openSaysMe" data-modal="User" data-dowhat="edit" data-id="'.$user_r->id.'">EDIT</button><button class="btn btn-sm btn-'.$comment_color.' openSaysMe" data-modal="User" data-dowhat="details" data-id="'.$user_r->id.'">DETAILS</button><button class="btn btn-sm btn-warning openSaysMe" data-modal="User" data-dowhat="modify" data-id="'.$user_r->id.'">POINTS</button><button class="btn btn-sm btn-warning openSaysMe" data-modal="User" data-dowhat="payment" data-id="'.$user_r->id.'">ADD PAYMENT</button><button class="btn btn-sm btn-warning openSaysMe" data-modal="User" data-dowhat="remove" data-id="'.$user_r->id.'">REMOVE</button>'
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableSchoolRemovedStudents() {

        $user_logat_r       = Auth::user();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $group_search       = $_GET['columns']['1']['search']['value'];
        $status_search      = $_GET['columns']['2']['search']['value'];
        $level_search       = $_GET['columns']['3']['search']['value'];
        $gender_search      = $_GET['columns']['4']['search']['value'];

        if(!$status_search) {
            $sql_search_operator = '!=';
            $sql_search_where    = 'muie'; 
        }
        if($status_search == 'subscribed' ) {
            $sql_search_operator = '=';
            $sql_search_where = 'subscribed';
        }
        if($status_search == 'unsubscribed' ) {
            $sql_search_operator = '=';
            $sql_search_where = 'unsubscribed';
        }

        if(!$gender_search) {
            $sql_search_operator_gender = '!=';
            $sql_search_where_gender    = 'muie'; 

        }
        if($gender_search == 'male' ) {
            $sql_search_operator_gender = '=';
            $sql_search_where_gender = 'male';
        }
        if($gender_search == 'female' ) {
            $sql_search_operator_gender = '=';
            $sql_search_where_gender = 'female';
        }
       
        $countulos          = User::where('school_id','=',$user_logat_r->returnSchoolId())
                                ->where('removed','!=', NULL)
                                ->where('level','!=','admin')
                                ->where('level','!=','teacher')
                                ->where('level','!=','none')
                                ->where('name', 'like', $search.'%')
                                ->where('courses_id', 'like', '%'.$group_search.'%')
                                ->where('status', $sql_search_operator, $sql_search_where)
                                ->where('level', 'like', '%'.$level_search.'%')
                                ->where('gender', $sql_search_operator_gender, $sql_search_where_gender)
                                ->orderBy('id', 'desc')
                                ->skip($start)
                                ->take($limit)
                                ->count();
        $user_c             =  User::where('school_id','=',$user_logat_r->returnSchoolId())
                                ->where('removed','!=', NULL)
                                ->where('level','!=','admin')
                                ->where('level','!=','teacher')
                                ->where('level','!=','none')
                                ->where('name', 'like', $search.'%')
                                ->where('courses_id', 'like', '%'.$group_search.'%')
                                ->where('status', $sql_search_operator, $sql_search_where)
                                ->where('level', 'like', '%'.$level_search.'%')
                                ->where('gender', $sql_search_operator_gender, $sql_search_where_gender)
                                ->orderBy('name', 'asc')
                                ->skip($start)
                                ->take($limit)
                                ->get();
        $x = 0;
        foreach ($user_c as $user_r) {

            $points = $user_r->puncte.' points';
            $action = 'actiuni';
            $status = '';
            $x      = $x + 1;
            $yyy    = 0;
            $comment_color = 'warning';
            if($user_r->comments != '') {
                $comment_color = 'success';
            }
            if(sizeof($user_r->Subscription) >= 1) {
                $userSubscripton = '';
                $active = '';
                foreach ($user_r->Subscription as $Subscription) {
                    if (strtotime(date("Y-m-d H:i:s")) < strtotime($Subscription->until_when.' 00:00:00')) {
                        $userSubscripton .= '<span class="normalDt">active - <span class="displayBlockMob">'.self::CourseInfoId($Subscription->course_id).' </span></span><br/><span class="successDt">Subscription ends <span class="displayBlockMob">on :'.$Subscription->until_when.'</span></span>';
                        $active .= 'xxx'; 
                    }
                }
            } else {
                $active = 'yyy';
            }

            if($active == '') {
                $userSubscripton = 'inactive<br/><span class="warningDt">Subscription ended</span>';
            }
            if($active == 'yyy') {
                $userSubscripton = 'inactive<br/><span class="warningDt">not subscribed yet</span>';
            }
            if($active == 'xxx') {
                $userSubscripton = $userSubscripton;
            }
             
            $data[] = array(
                'nr'                => $x,
                'name'              => $user_r->name.'<br/><span class="displayBlockMob"> '.$points.'</span>',
                'status'            => $userSubscripton,
                'level'             => '<span class="normalDt">'.$user_r->level.'</span>',
                'actions'           => '<button class="btn btn-sm btn-warning openSaysMe" data-modal="User" data-dowhat="edit" data-id="'.$user_r->id.'">EDIT</button><button class="btn btn-sm btn-'.$comment_color.' openSaysMe" data-modal="User" data-dowhat="details" data-id="'.$user_r->id.'">DETAILS</button><button class="btn btn-sm btn-warning openSaysMe" data-modal="User" data-dowhat="modify" data-id="'.$user_r->id.'">POINTS</button><button class="btn btn-sm btn-warning openSaysMe" data-modal="User" data-dowhat="payment" data-id="'.$user_r->id.'">ADD PAYMENT</button><button class="btn btn-sm btn-warning openSaysMe" data-modal="User" data-dowhat="putback" data-id="'.$user_r->id.'">ACTIVATE</button>'
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }
    // end

    public function datatableSchoolUsers() {

        //$franchise_c      = Franchise::all();
        $user_logat_r       = Auth::user();
        //$countulos          = Teacher::where('school_id','=',$user_logat_r->returnSchoolId())->count();
        $countulos          = $user_logat_r->School->UserCount();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (name LIKE '%{$exploded_data[$i]}%')";
            }
        }

        //$user_c = DB::select( DB::raw("SELECT * FROM users WHERE school_id = {$user_logat_r->returnSchoolId()}  $sql_search ORDER BY id DESC LIMIT $start,$limit") );
        // we gona use this

        $user_c      =  User::where('school_id','=',$user_logat_r->returnSchoolId())
                        ->where('level','!=','admin')
                        ->where('level','!=','teacher')
                        ->orderBy('id', 'desc')
                        ->skip($start)
                        ->take($limit)
                        ->get();
        
        foreach ($user_c as $user_r) {

            //ceva
            $status = 'Points: '.$user_r->puncte.'<br/>'.$user_r->level;
            $action = 'actiuni';
     
            $data[] = array(
                'name'              => $user_r->name,
                'status'            => '<button class="btn btn-sm btn-warning openSaysMe" data-modal="User" data-dowhat="details" data-id="'.$user_r->id.'">DETAILS</button>',
                'actions'           => $action
            );


        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }
    // end
    public function datatableSchoolPayments() {

        //$franchise_c      = Franchise::all();
        $user_logat_r       = Auth::user();
        //$countulos          = Teacher::where('school_id','=',$user_logat_r->returnSchoolId())->count();
        //$countulos          = $user_logat_r->School->UserCount();
        
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (name LIKE '%{$exploded_data[$i]}%')";
            }
        }

        $payment_c   = Payment::where('school_id','=', '1')
                                ->orderBy('id', 'desc')
                                ->skip($start)
                                ->take($limit)
                                ->get();
        $countulos   = Payment::where('school_id','=','1')
                                ->orderBy('id', 'desc')
                                ->skip($start)
                                ->take($limit)
                                ->count();

        foreach ($payment_c as $payment_r) {

            $action = '<button class="btn btn-sm btn-danger openSaysMe" data-modal="Payment" data-dowhat="details" data-id="'.$payment_r->id.'">Details</button>';
            if($payment_r->status != 'active') {
                $action = '<button class="btn btn-sm btn-warning openSaysMe" data-modal="Payment" data-dowhat="activate" data-id="'.$payment_r->id.'">Activate</button><button class="btn btn-sm btn-danger openSaysMe" data-modal="Payment" data-dowhat="details" data-id="'.$payment_r->id.'">Details</button>';
            } 

            $paymentdate = ''; 
            if($payment_r->payment_for == 'subscription') {
                $subsc_r  = Subscription::where('id','=',$payment_r->subscription_id)->first();
                $course_r = Course::where('id','=',$subsc_r->course_id)->first();
                $payment_for_details = $course_r->planName().' - '.$course_r->Level().' - until '.$subsc_r->until_when;
            } else {
                $event_r  = Event::where('id','=',$payment_r->payment_for_id)->first();
                $payment_for_details = $event_r->title;
            }

            $paymentdate = 'Payment for: '.$payment_for_details.'<br/>Payment date: '.$payment_r->date;
            
            $user_r = User::where('id','=',$payment_r->user_id)->first();
     
            $data[] = array(
                'id'                => $payment_r->id,
                'type'              => $payment_r->type.' - '.$payment_r->amount.' '.$payment_r->currency,
                'user'              => $user_r->name,
                'status'            => $payment_r->status,
                'date'              => $paymentdate,
                'details'           => $action
            );
        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }


    public function datatableEvents() {

        $countulos          = Event::count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (title LIKE '%{$exploded_data[$i]}%')";
            }
        }
        $school_id  = config('app.school_id');
        $event_c    = Event::where('school_id','=', $school_id)
                            ->orderBy('id', 'asc')
                            ->skip($start)
                            ->take($limit)
                            ->get();

        foreach ($event_c as $event_r) {

            $attending = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Event" data-dowhat="attending" data-id="'.$event_r->id.'">Attending</button>';

            $attending_xs = '<button class="hidden-md hidden-lg btn btn-sm btn-success openSaysMe" data-modal="Event" data-dowhat="attending" data-id="'.$event_r->id.'">Attending</button>';

            if($event_r->status == 'active') {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Event" data-dowhat="edit" data-id="'.$event_r->id.'">Edit</button><button class="btn btn-sm btn-primary openSaysMe" data-modal="Event" data-dowhat="details" data-id="'.$event_r->id.'">Details</button><button class="btn btn-sm btn-warning openSaysMe" data-modal="Event" data-dowhat="delete" data-id="'.$event_r->id.'">Delete</button> <button class="btn btn-sm btn-danger openSaysMe" data-modal="Event" data-dowhat="sendnotifications" data-id="'.$event_r->id.'">Send notifications</button>'.$attending_xs;
                $status = '<i class="fa fa-play"></i> active';
            }
            else {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Event" data-dowhat="edit" data-id="'.$event_r->id.'">Edit</button><button class="btn btn-sm btn-primary openSaysMe" data-modal="Event" data-dowhat="details" data-id="'.$event_r->id.'">Details</button><button class="btn btn-sm btn-warning openSaysMe" data-modal="Event" data-dowhat="activate" data-id="'.$event_r->id.'">Activate</button><button class="btn btn-sm btn-danger openSaysMe" data-modal="Event" data-dowhat="sendnotifications" data-id="'.$event_r->id.'">Send notifications</button>'.$attending_xs;
                $status = '<i class="fa fa-pause"></i> inactive';
            }

            $image = '';
            if($event_r->image != '') {
                $image = '<a class="openSaysMe" data-modal="Event" data-dowhat="img" data-id="'.$event_r->id.'"><img src="'.url('/').'/'.$event_r->image.'" class="imgDt"></a>';
            } else {
                $image = '<img src="'.url('/').'/resources/assets/uploads/noimg.png" class="imgDt">';
            }

            $data[] = array(
                'img'           => $image,
                'title'         => '<div class="mbWarp">'.$event_r->title.'</div>',
                'status'        => $status,
                'location'      => $event_r->place.'<br/>'.substr($event_r->date, 0 ,10),
                'attending'     => $attending,
                'actions'       => $action

            );

        }

        if($countulos == 0) {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableJoinEvents() {
        $user_logat_r       = Auth::user();
        $school_id          = config('app.school_id');
        $countulos          = Event::where('status','=','active')
                            ->where('school_id','=',$school_id)
                            ->whereDate('date', '>', Carbon::yesterday('Europe/London') )
                            ->orderBy('id')
                            ->orderBy('id', 'asc')                                
                            ->count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (title LIKE '%{$exploded_data[$i]}%')";
            }
        }
        
        $event_c    = Event::where('status','=','active')
                            ->where('school_id','=',$school_id)
                            ->whereDate('date', '>', Carbon::yesterday('Europe/London') )
                            ->orderBy('id')
                            ->orderBy('id', 'asc')                                
                            ->get();

        foreach ($event_c as $event_r) {

            $action    = '';
            $booking_r = Booking::where('event_id','=',$event_r->id)->where('user_id','=',$user_logat_r->id)->first();

            if(is_object($booking_r)) {
                $action    = '<span class="hidden-xs hidden-sm">you are already</span> subscribed <span class="hidden-xs hidden-sm">to this event</span>';
            } else {
                $action    = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Event" data-dowhat="booknow" data-id="'.$event_r->id.'">Book now</button>';
            }
               

            $image = '';
            if($event_r->image != '') {
                $image = '<a class="openSaysMe" data-modal="Event" data-dowhat="img" data-id="'.$event_r->id.'"><img src="'.url('/').'/'.$event_r->image.'" class="imgDt"></a>';
            } else {
                $image = '<img src="'.url('/').'/resources/assets/uploads/noimg.png" class="imgDt">';
            }

            $data[] = array(
                'image'         => $image,
                'name'          => $event_r->title,
                'date'          => substr($event_r->date, 0,10).' hour: '.$event_r->hour,
                'price'         => $event_r->price.' '.$event_r->currency,
                'details'       => '<button class="btn btn-sm btn-success openSaysMe" data-modal="Event" data-dowhat="details" data-id="'.$event_r->id.'">Event details</button>',
                'actions'       => $action

            );

        }

        if($countulos == 0) {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableFriends() {

        $user_logat_r       = Auth::user();
        $school_id          = config('app.school_id');
        $countulos          = Friend::where('user_id','=',$user_logat_r->id)->count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (name LIKE '%{$exploded_data[$i]}%')";
            }
        }
        
        $friend_c    = Friend::where('user_id','=',$user_logat_r->id)->get();

        foreach ($friend_c as $friend_r) {
            $points = '';
            $user_r = User::where('email','=',$friend_r->email)->first();
            if(is_object($user_r)) {
                if( $user_r->Subscription()->exists() ) {
                    if($friend_r->referrer == 'success') {
                        $points = 'You earned points';
                    } else {
                        $points = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Friend" data-dowhat="addpoints" data-id="'.$friend_r->id.'">ADD POINTS</button>';
                    }
                    
                } else {
                    $points = "User is in sistem but he didn't subscribe yet";
                }
            } 
           
            if($friend_r->status == 'notsentyet') {
                $status = 'Invitation not been sent';
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Friend" data-dowhat="sendinvitation" data-id="'.$friend_r->id.'">Send email Invitation</button>';
            } 
            if($friend_r->status == 'sended') {
                $status = 'Invitation has been sent';
                $action = $points;
            }

            $data[] = array(
                'name'          => $friend_r->name,
                'email'         => $friend_r->email,
                'status'        => $status,
                'actions'       => $action.'<span class="hidden-md hidden-lg">'.$status.'</span>',

            );

        }

        if($countulos == 0) {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }

    public function datatableQuotes() {

        //$franchise_c      = Franchise::all();
        $countulos          = Quote::count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "AND (quote LIKE '%{$exploded_data[$i]}%')";
            }
        }
        $school_id  = config('app.school_id');
        $quote_c    = Quote::where('school_id','=', $school_id)
                            ->orderBy('id', 'asc')
                            ->skip($start)
                            ->take($limit)
                            ->get();

        foreach ($quote_c as $quote_r) {

            if($quote_r->status == 'active') {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Quote" data-dowhat="edit" data-id="'.$quote_r->id.'">edit</button> <button class="btn btn-sm btn-danger openSaysMe" data-modal="Quote" data-dowhat="delete" data-id="'.$quote_r->id.'">delete</button>';
                $status = '<i class="fa fa-play"></i> active';
            }
            else {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Quote" data-dowhat="edit" data-id="'.$quote_r->id.'">edit</button> <button class="btn btn-sm btn-warning openSaysMe" data-modal="Quote" data-dowhat="activate" data-id="'.$quote_r->id.'">activate</button>';
                $status = '<i class="fa fa-pause"></i> inactive';
            }

            $data[] = array(
                'quote'          => $quote_r->quote,
                'status'         => $status,
                'actions'        => $action
            );

        }

        if($countulos == 0) {
            $data = '';
        }
       
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }



     public function datatableBlog() {

        //$franchise_c      = Franchise::all();
        $user_logat_r       = Auth::user();
        $countulos          = Blog::count();
        //$countulos          = $user_logat_r->DanceClasses->count();
        $limit              = $_GET['length'];
        $start              = $_GET['start'];
        $search             = $_GET['search']['value'];
        $sql_search         = '';

        if($search != null) {
            $exploded_data = explode(' ', $search);
            $count_ex      = count($exploded_data) - 1;
            for($i=0;$i<=$count_ex;$i++) {
                $sql_search .= "WHERE (title LIKE '%{$exploded_data[$i]}%')";
            }
        }

        $blog_c    =   Blog::orderBy('id', 'desc')
                                ->skip($start)
                                ->take($limit)
                                ->get();

        foreach ($blog_c as $blog_r) {

            if($blog_r->active == 'yes') {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Blog" data-dowhat="edit" data-id="'.$blog_r->id.'">edit</button> <button class="btn btn-sm btn-danger openSaysMe" data-modal="Blog" data-dowhat="delete" data-id="'.$blog_r->id.'">delete</button>';
                $status = '<i class="fa fa-play"></i> active';
            }
            else {
                $action = '<button class="btn btn-sm btn-success openSaysMe" data-modal="Blog" data-dowhat="edit" data-id="'.$blog_r->id.'">edit</button> <button class="btn btn-sm btn-warning openSaysMe" data-modal="Blog" data-dowhat="activate" data-id="'.$blog_r->id.'">activate</button>';
                $status = '<i class="fa fa-pause"></i> inactive';
            }

            $image = '';
            if($blog_r->image1 != '') {
                $image = '<a class="openSaysMe" data-modal="Blog" data-dowhat="img" data-id="'.$blog_r->id.'"><img src="'.url('/').'/'.$blog_r->image1.'" class="imgDt"></a>';
            } else {
                $image = '<img src="'.url('/').'/resources/assets/uploads/noimg.png" class="imgDt">';
            }
     
            $data[] = array(
                'image'             => $image,
                'title'             => $blog_r->title,
                'status'            => $status,
                'actions'           => $action
            );

        }

        if($countulos == 0) {
            $data = '';
        }
        
        $detalii   = '{"draw":0,"recordsTotal":'.$countulos.',"recordsFiltered":'.$countulos.',"data":';
        $detalii  .= json_encode($data,JSON_UNESCAPED_SLASHES);
        $detalii  .= '}';
        $detalii   = $detalii;

        return $detalii; 

    }


}
