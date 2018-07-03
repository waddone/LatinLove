<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\School;
use App\Country;
use App\DanceClass;
use App\Teacher;
use App\Course;
use App\Plan;
use App\Event;
use App\Booking;
use App\Blog;
use App\Currency;
use App\Payment;
use App\Friend;
use App\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;


class ModaleController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct(){
        //$this->middleware('auth')->except(['danceClasses', 'events', 'aboutUs','franchise', 'contact']);
        $this->middleware('auth');
    }
    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Http\Response
    */

    public function generalModale($modal, $dowhat, $id) {

        //$object_r  = DB::select( DB::raw("SELECT * FROM {$modal} WHERE id = '{$id}' limit 1") )->first();
        //$dowhat = actionul pe care il faci
        $user_logat_r   = Auth::user();
        //$object_r       = DB::table($modal)->where('id', $id)->first();
        //sau 
        $school_id      = config('app.school_id');
        $modal          = 'App\\'.$modal;
        $object_r       = $modal::where('id', $id)->first();
        $dance_class_c  = DanceClass::where('user_id','=',$user_logat_r->id)->get();
        //$courses_c      = Course::where('school_id','=',getSchoolIdFromCurrentLogedUser())->get();
        $all_users      = User::all();
        $country_c      = Country::all();
        $teachers_c     = Teacher::where('school_id','=',getSchoolIdFromCurrentLogedUser())->first();
        $courses        = Course::where('active','=','yes')->get();
        $course_c       = Course::where('school_id','=',$school_id)->where('active','=','yes')->get();
        $currency_c     = Currency::all();
        $plans          = Plan::where('status','=','active')->get();
        $user_r         = User::where('id','=',$id)->first();
        $modal          = str_replace('App\\', '', $modal);
        //////////////////////////////////////////////////////
        ////////// vezi modale cursuri de dans   /////////////
        //////////////////////////////////////////////////////
        if($modal == 'DanceClass') {
            if($dowhat == 'see') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->name;?> description</h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <?=$object_r->description;?>
                </div>
            <? } 
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->name;?> edit</h4>
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-dance-class')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <label for="name" class="control-label">Dance class name</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input id="name" type="text" class="form-control" name="name" value="<?=$object_r->name?>" required autofocus>
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="active" value="yes">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="description" class="control-label">Description</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <textarea id="description2" class="form-control" name="description"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group{{ $errors->has('order_nr') ? ' has-error' : '' }}">
                            <div class="col-xs-12 text-left">
                                <label for="order_nr" class="control-label">Order nr</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="text" name="order_nr" id="order_nr" value="<?=$object_r->order_nr?>">
                            </div>
                        </div>
                        <br/>
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <div class="col-xs-12 text-left">
                                <label for="image" class="control-label">Add image</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="file" name="image" id="image" value="<?=$object_r->image1?>">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Update dance class</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                    <script>
                    $(function() {
                        $('#description2').froalaEditor();
                    });
                    </script>
                </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center"><?=$object_r->name;?> delete</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-dance-class')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="name" type="hidden" class="form-control" name="name" value="<?=$object_r->name?>">
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="active" value="no">
                                <textarea name="description" style="display:none;"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Delete dance class</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? }
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->name;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-dance-class')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="name" type="hidden" class="form-control" name="name" value="<?=$object_r->name?>">
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="active" value="yes">
                                <textarea name="description" style="display:none;"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Activate dance class</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
            if($dowhat == 'img') { ?>
                <div class="modal-header text-center">Image <?=$object_r->name;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <img src="<?=url('/').'/'.$object_r->image1;?>" class="img-responsive">
                        </div>
                    </div>
                </div>
            <? }
        } // end modal cursuri dans 
         //////////////////////////////////////////////////////
        ////////// vezi modale cursuri de dans   /////////////
        //////////////////////////////////////////////////////
        if($modal == 'Course') {
            if($dowhat == 'see') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->PlanName();?> - <?=$object_r->Level();?> details</h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row borderBottomGrey">
                        <div class="col-xs-12 col-md-4 text-left">
                            Started on:
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=substr($object_r->started_on, 0, 10);?>
                        </div>
                        <div class="col-xs-12 col-md-4 text-left">
                            End on:
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=substr($object_r->ended_on, 0, 10);?>
                        </div>
                        <div class="col-xs-12 col-md-4 text-left">
                            Active:
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=$object_r->active?>
                        </div>
                        <div class="col-xs-12 col-md-4 text-left">
                            Subscribed users:
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=$object_r->NumberOfSubscribedUsers()?>
                        </div>
                    </div>
                </div>
            <? } 
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->PlanName();?> - <?=$object_r->Level();?> edit</h4>
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-dance-course')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="col-xs-12 text-left">
                            <?
                            $nrOfDatesCur   = explode(',', $object_r->dates);
                            $nrOfHoursCur   = explode(',',  $object_r->hours);
                            $countNrOfDates = count($nrOfDatesCur);

                            ?>
                            <input type="hidden" name="school_id" value="<?=$user_logat_r->returnSchoolId()?>">
                            <input type="hidden" name="nrOfDates" value="<?=$countNrOfDates?>" id="nrOfDates2" />
                            <input type="hidden" name="active" value="yes">
                            <input type="hidden" name="update" value="<?=$object_r->id?>">
                            <!--
                            <select name="dance_classes_id" id="dance_classes_id2" class="form-control">
                                <option value="">Select dance style</option>
                                <?// foreach ($user_logat_r->DanceClassesActive as $dance_class_r) { ?>
                                    <option value="<?//=$dance_class_r->id?>"<?//=$object_r->DanceClassName() == $dance_class_r->name ? ' selected' : '' ?>><?//=$dance_class_r->name?></option>
                                <?// } ?>
                            </select>
                            -->
                        </div>
                        <div class="col-xs-12 text-left">
                            <label for="plan_id" class="control-label">Plan</label>
                        </div>
                        <div class="col-xs-12 text-left">
                            <select name="plan_id" id="plan_id" class="form-control">
                                <option value="">Select plan</option>
                                <? foreach ($plans as $plan) { ?>
                                    <option value="<?=$plan->id?>" <?=$object_r->plan_id==$plan->id?'selected':''?>><?=$plan->name?></option>
                                <? } ?>
                            </select>
                        </div>
                        <div class="col-xs-12 text-left">
                            <label for="name" class="control-label">Level</label>
                        </div>
                        <div class="col-xs-12 text-left">
                            <select name="level_id" id="level_id2" class="form-control">
                                <option value="">Select level</option>
                                <option value="1" <?=$object_r->Level() == 'beginner' ? 'selected' : '' ?>>Beginner</option>
                                <option value="2" <?=$object_r->Level() == 'improver' ? 'selected' : '' ?>>Improver</option>
                                <option value="3" <?=$object_r->Level() == 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                                <option value="4" <?=$object_r->Level() == 'advanced' ? 'selected' : '' ?>>Advanced</option>
                                <option value="5" <?=$object_r->Level() == 'open level' ? 'selected' : '' ?>>Open level</option>
                            </select>
                        </div>
                        <div class="col-xs-12 text-left">
                            <label for="dateRangeCourse" class="control-label">Choose range of dates for this course</label>
                        </div>
                        <div class="col-xs-12">
                            <div class="input-group date">
                                <input type="text" name="dateRangeCourse" id="dateRangeCourse" class="form-control" value="<?=substr($object_r->started_on, 0 , 10);?> - <?=substr($object_r->ended_on, 0 , 10);?>">
                                <span class="input-group-addon">
                                   <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-xs-12 text-left">
                            <label for="dateRangeCourse" class="control-label">Choose days and hours for this course</label>
                        </div>

                        <? for ($j=0;$j<=($countNrOfDates - 1);$j++) {
                            if($j == 0 ) { 
                                $plm  = '';
                                $plm1 = $j+1;
                            } else {
                                $plm  = $j;
                                $plm1 = $j+1;
                            }
                        ?>
                        <div class="cloneEl"">
                            <div class="col-xs-6">
                                <div class="input-group date">
                                    <select name="selectRange<?=$plm1?>" id="selectRange<?=$plm1?>" class="form-control">
                                        <option value="everyDay"<?=$nrOfDatesCur[$j] == 'everyDay' ? ' selected' : '' ?>>Every day</option>
                                        <option value="MoToFr"<?=$nrOfDatesCur[$j] == 'MoToFr' ? ' selected' : '' ?>>Monday - Friday</option>
                                        <option value="SaToSu"<?=$nrOfDatesCur[$j] == 'SaToSu' ? ' selected' : '' ?>>Saturday - Sunday</option>
                                        <option value="Mo"<?=$nrOfDatesCur[$j] == 'Mo' ? ' selected' : '' ?>>Monday</option>
                                        <option value="Tu"<?=$nrOfDatesCur[$j] == 'Tu' ? ' selected' : '' ?>>Tuesday</option>
                                        <option value="We"<?=$nrOfDatesCur[$j] == 'We' ? ' selected' : '' ?>>Wednesday</option>
                                        <option value="Th"<?=$nrOfDatesCur[$j] == 'Th' ? ' selected' : '' ?>>Thurday</option>
                                        <option value="Fr"<?=$nrOfDatesCur[$j] == 'Fr' ? ' selected' : '' ?>>Friday</option>
                                        <option value="Sa"<?=$nrOfDatesCur[$j] == 'Sa' ? ' selected' : '' ?>>Saturday</option>
                                        <option value="Su"<?=$nrOfDatesCur[$j] == 'Su' ? ' selected' : '' ?>>Sunday</option>
                                    </select>
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="input-group date">
                                    <select name="selectHour<?=$plm1?>" id="selectHour<?=$plm1?>" class="form-control">
                                        <? 
                                        $hourAndMinutes = '';
                                        for ($i=7;$i<=22;$i++) { 
                                            $hour = $i;
                                            if($i < 10) { $hour = '0'.$hour; }
                                            for($x=1;$x<=2;$x++) {
                                                if($x == 1) {
                                                    $minutes = '00'; 
                                                } else { 
                                                    $minutes = '30' ; 
                                                }
                                                $hourAndMinutes = $hour.':'.$minutes;?>

                                                <option value="<?=$hourAndMinutes?>"<?=$nrOfHoursCur[$j] == $hourAndMinutes ? ' selected' : '' ?>><?=$hourAndMinutes?></option>
                                        <?  }  
                                        } ?>
                                    </select>
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <? } // end for?>
                        <div class="clone nopadding"></div>

                        <div class="col-xs-12 text-right">
                            <div class="col-xs-12 addNewDate">
                                <a href="javascript:void(0)" id="addNewDate">+ Add new date and hour</a>
                            </div>
                        </div>
              
                        <br/>
                        <div class="col-xs-12 text-center btnPadding">
                            <button type="submit" class="btn btn-primary">Update course</button>
                        </div>
                        <br/>
                        <br/>
                        <br/>
                    </form>
                    <script>
                    $(function() {
                        $('#level_id2, #dance_classes_id2').select2();
                        $('input[name="dateRangeCourse"]').daterangepicker(
                                {
                                    locale: {
                                      format: 'YYYY-MM-DD'
                                    },
                                    startDate: '<?=date("Y-m-d")?>',
                                    endDate: '<?=date('Y-m-d', strtotime("+3 months", strtotime(date("Y-m-d"))))?>'
                                }, 
                            );
                    });
                    $(document).ready(function() {
                        $('.addNewDate').on('click', function () {
                            var elNow = parseInt($('#nrOfDates2').val()) + 1;
                            if(elNow > 7){
                                var html = '<div class="text-center" style="color:red"><strong>Only 7 options available</strong></div>';
                            } else {
                            var html  = '<div class="cloneEl'+elNow+'"><div class="col-xs-6"><div class="input-group date"><select name="selectRange'+elNow+'" id="selectRange'+elNow+'" class="form-control"><option value="everyDay">Every day</option><option value="MoToFr">Monday - Friday</option><option value="SaToSu">Saturday - Sunday</option><option value="Mo">Monday</option><option value="Tu">Tuesday</option><option value="We">Wednesday</option><option value="Th">Thurday</option><option value="Fr">Friday</option><option value="Sa">Saturday</option><option value="Su">Sunday</option></select><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span></div></div><div class="col-xs-6"><div class="input-group date"><select name="selectHour'+elNow+'" id="selectHour'+elNow+'" class="form-control"><? $hourAndMinutes = '';
                                                for ($i=7;$i<=22;$i++) { $hour = $i;
                                                    if($i < 10) { $hour = '0'.$hour; }
                                                    for($x=1;$x<=2;$x++) {
                                                        if($x == 1) { $minutes = '00'; } else { $minutes = '30' ; }
                                                        $hourAndMinutes = $hour.':'.$minutes;
                                                        echo '<option value="'.$hourAndMinutes.'">'.$hourAndMinutes.'</option>';  
                                                    }  
                                                } ?></select><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span></div></div></div>';
                            }
                            $('.clone').append(html);
                            $('#nrOfDates2').val(elNow);

                        });
                    });
                    </script>
                </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center"><?=$object_r->name;?> delete</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-dance-class')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="name" type="hidden" class="form-control" name="name" value="<?=$object_r->name?>">
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="active" value="no">
                                <input type="hidden" name="plan_id" value="<?=$object_r->plan_id?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="level_id" value="<?=$object_r->level_id?>">
                                <input type="hidden" name="dateRangeCourse" value="<?=substr($object_r->started_on,0,10).' - '.substr($object_r->ended_on,0,10)?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="nrOfDates" value="<?=$object_r->id?>">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Delete dance class</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? }
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->PlanName();?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-dance-class')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="name" type="hidden" class="form-control" name="name" value="<?=$object_r->name?>">
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="active" value="yes">
                                <input type="hidden" name="plan_id" value="<?=$object_r->plan_id?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="level_id" value="<?=$object_r->level_id?>">
                                <input type="hidden" name="dateRangeCourse" value="<?=substr($object_r->started_on,0,10).' - '.substr($object_r->ended_on,0,10)?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="nrOfDates" value="<?=$object_r->id?>">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Activate dance class</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
            if($dowhat == 'timetable') { ?>
                <div class="modal-header text-center">Timetable <?=$object_r->PlanName();?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div id="calendar"></div>
                    <script>
                        $(document).ready(function() {
                            var date = new Date();
                            var    d = date.getDate();
                            var    m = date.getMonth();
                            var    y = date.getFullYear();
                       
                            $('#calendar').fullCalendar({
                                header: {
                                    left: 'prev,next today',
                                    center: 'title',
                                    right: 'month,agendaWeek,agendaDay'
                                },
                                timeFormat: 'H:mm -',
                                events: [
                                    <? 
                                        $begin      = new \DateTime(substr($object_r->started_on, 0,10));
                                        $end        = new \DateTime(substr($object_r->ended_on, 0,10));
                                        $interval   = \DateInterval::createFromDateString('1 day');
                                        $period     = new \DatePeriod($begin, $interval, $end);
                                        $hourEx     = explode(':', $object_r->hours);
                                        $hour       = $hourEx[0];
                                        $title      = ' '.$object_r->PlanName().' '.$object_r->Level();
                                        $dates_of_w = explode(',', $object_r->dates);
                                        $mydays     = array();
                                        $hour_p1    = $hour + 1;
                                        for($x=0;$x<count($dates_of_w);$x++) {
                                            if($dates_of_w[$x] == 'everyDay') {
                                                $mydays = array('1','2','3','4','5','6','7');  
                                            }
                                            if($dates_of_w[$x] == 'MoToFr') {
                                                $mydays = array('1','2','3','4','5');  
                                            }
                                            if($dates_of_w[$x] == 'Mo') {
                                                $mydays[] = '1';  
                                            }
                                            if($dates_of_w[$x] == 'Tu') {
                                                $mydays[] = '2';  
                                            }
                                            if($dates_of_w[$x] == 'We') {
                                                $mydays[] = '3';  
                                            }
                                            if($dates_of_w[$x] == 'Th') {
                                                $mydays[] = '4';  
                                            }
                                            if($dates_of_w[$x] == 'Fr') {
                                                $mydays[] = '5';  
                                            }
                                            if($dates_of_w[$x] == 'Sa') {
                                                $mydays[] = '6';  
                                            }
                                            if($dates_of_w[$x] == 'Su') {
                                                $mydays[] = '7';  
                                            }
                                        }

                                        foreach ($period as $dt) { 
                                            if(in_array($dt->format('N'), $mydays)) {
                                            ?>
                                                {
                                                    title: '<?=$title?>',
                                                    start: '<?=$dt->format("Y");?>-<?=$dt->format("m");?>-<?=$dt->format("d");?>T<?=$hour?>:00:00',
                                                    end: '<?=$dt->format("Y");?>-<?=$dt->format("m");?>-<?=$dt->format("d");?>T<?=$hour_p1?>:00:00',
                                                    allDay: false
                                                }  ,
                                        <?  } // end if in array 
                                        } // end date foreach
                                    ?>
                                ] 
                            });
                        });
                    </script>  
                </div>
            <? } 
            if($dowhat == 'booknow') { ?>
                <div class="modal-header text-center">Book now <?=$object_r->PlanName();?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <? if($user_logat_r->Subscription()->exists() ) { ?>
                        <form class="form-horizontal" method="POST" action="<?=route('book-now-course')?>" enctype="multipart/form-data">
                            <?=csrf_field()?>
                            <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                            <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                            <input type="hidden" value="<?=$object_r->id?>" name="course_id" class="form-control">
                            <div class="col-xs-12 col-md-6 xdisplay_inputx form-group has-feedback text-left">
                                <label for="starting_from" class="control-label">Payment and subscribtion starting from</label>
                                <input type="text" class="form-control has-feedback-left" id="single_cal223" placeholder="date" name="starting_from">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                            </div>
                            <div class="col-xs-12 col-md-6 text-left">
                                <label for="until_when" class="control-label">Subscribe and payment for : </label>
                                <select name="until_when" id="until_when" class="form-control" required>
                                    <option value="">Choose period</option>
                                    <option value="1d">1 day</option>
                                    <option value="1m">1 month</option>
                                    <option value="2m">2 months</option>
                                    <option value="3m">3 months</option>
                                </select>
                            </div>
                            <div class="col-xs-12 col-md-12 text-left">
                                <label for="payment_type" class="control-label">Select payment: </label>
                                <select name="payment_type" id="payment_type" class="form-control" required>
                                    <option value="">Choose payment</option>
                                    <option value="paypall">Paypal</option>
                                    <option value="bank">Bank transfer</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <br/>
                                    <a href="javascript:void(0)" class="btn btn-info" id="ShowPaymentDetails">
                                        SHOW DETAILS FOR PAYMENT
                                    </a>
                                </div>
                            </div>
                            <script>
                                $( "#ShowPaymentDetails" ).click(function() {
                                    var paymentType   = $("#payment_type option:selected").val();    
                                    var paymentUntil  = $("#until_when option:selected").val(); 

                                    if(paymentType == '' || paymentUntil == '') {
                                        $("#DivMesaje").html('<br/><span class="ShowPaymentMesaje">PLEASE CHOOSE PERIOD AND PAYMENT TYPE</span><br/>');  
                                    }
                                                           
                                    if(paymentUntil == '1d') { paymentAmount = 9; }  
                                    if(paymentUntil == '1m') { paymentAmount = <?=$object_r->GetPlanPoints()?>; }
                                    if(paymentUntil == '2m') { paymentAmount = <?=$object_r->GetPlanPoints()?> * 2; }
                                    if(paymentUntil == '3m') { paymentAmount = <?=$object_r->GetPlanPoints()?> * 3; } 
                                    if(paymentType == 'paypall') {
                                        $("#DivMesaje").html('<br/><span class="ShowPaymentMesaje">You choosed to pay with Paypall - '+paymentAmount+' <?=config('app.currency')?> </span><br/>');  
                                        $("#DivPaypall").removeClass('hidden');
                                        $("#bankTranferSubmitButton").addClass('hidden');
                                    }
                                    if(paymentType == 'bank') {
                                        $("#DivMesaje").html('<br/><span class="ShowPaymentMesaje">You choosed to pay with Bank transfer - '+paymentAmount+' <?=config('app.currency')?> </span><br/>'); 
                                        $("#DivPaypall").addClass('hidden'); 
                                        $("#DivBank").html('<span style="font-size:14px;color:#000;font-weight:bold"><br/>YOU HAVE TO TRANSFER THE AMOUNT IN LATINLOVE ACCOUNT<br/>Latin Love Ltd. <br/>Sort code 208956<br/>Account number 23049698<br/> Please add this referrence string to bank details so we can to distinguish your transction:</span><br/> <br/> <span style="color:blue;font-weight:bold;font-size:17px;">S<?=$object_r->id?>U<?=$user_logat_r->id?>D<?=date('Y-m-d')?></span>');
                                        $("#bankTranferSubmitButton").removeClass('hidden');
                                    }
                                });
                            </script>
                            
                            <div class="form-group">
                                <div class="col-xs-12" id="DivMesaje">
                                </div>
                                <div class="col-xs-12 hidden" id="DivPaypall">
                                    <br/><br/>
                                    <div id="paypal-button"></div>
                                    <script>
                                        // office@latinlovedanceschool.com
                                        // Sophie1love

                                        // office-buyer@latinlovedanceschool.com
                                        // 123456789

                                        // office-facilitator@latinlovedanceschool.com
                                        // Sophie1love
                                        
                                        paypal.Button.render({
                                            env: '<?=config('app.paypal_mode')?>', // Or 'sandbox',
                                            client: {
                                                sandbox:    '<?=config('app.paypal_client_id_sandbox')?>',
                                                production: '<?=config('app.paypal_client_id_production')?>'
                                            },
                                            commit: true, // Show a 'Pay Now' button
                                            style: {
                                                color: 'gold',
                                                size: 'small'
                                            },
                                            payment: function(data, actions) {
                                                // Make a call to the REST api to create the payment
                                                var paymentAmount   = $("#payment_type option:selected").val();  
                                                var paymentUntil  = $("#until_when option:selected").val(); 
                                                if(paymentUntil == '1d') { paymentAmount = 9; }  
                                                if(paymentUntil == '1m') { paymentAmount = <?=$object_r->GetPlanPoints()?>; }
                                                if(paymentUntil == '2m') { paymentAmount = <?=$object_r->GetPlanPoints()?> * 2; }
                                                if(paymentUntil == '3m') { paymentAmount = <?=$object_r->GetPlanPoints()?> * 3; }   
                                                return actions.payment.create({
                                                    payment: {
                                                        transactions: [
                                                            {
                                                                amount: { total: paymentAmount, currency: 'GBP' }
                                                                
                                                            }
                                                        ]
                                                    }
                                                });
                                            },
                                            onAuthorize: function(data, actions) {
                                                // Make a call to the REST api to execute the payment
                                                return actions.payment.execute().then(function() {
                                                    document.querySelector('#finalSubmit').click();
                                                });
                                            },
                                            onCancel: function(data, actions) {
                                                return document.querySelector('#statusForPaypall').innerText = 'Payment canceled!';
                                            },
                                            onError: function(err) {
                                            /*
                                            * An error occurred during the transaction
                                            */
                                            }
                                        }, '#paypal-button');
                                    </script>
                                </div>
                                <div class="col-xs-12" id="DivBank">
                                </div>
                                <div class="col-xs-12" id="statusForPaypall">
                                </div>


                                <div class="form-group hidden" id="bankTranferSubmitButton">
                                    <div class="col-xs-12 text-center">
                                        <br/><button type="submit" class="btn btn-primary" id="finalSubmit">PAY NOW</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <script>
                            $('#single_cal223').daterangepicker({
                                singleDatePicker: true,
                                singleClasses: "picker_2"
                            }, function(start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        </script>
                    <? } else { ?> 
                        First time when you want to subscribe to course you need to talk with Mihai Banu 
                    <? } ?>
                </div>
            <? } 
            if($dowhat == 'claim') { ?>
                <div class="modal-header text-center">Claim free month for <?=$object_r->PlanName();?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <? if($user_logat_r->Subscription()->exists() ) { ?>
                        <form class="form-horizontal" method="POST" action="<?=route('book-now-course')?>" enctype="multipart/form-data">
                            <?=csrf_field()?>
                            <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                            <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                            <input type="hidden" name="course_id" value="<?=$object_r->id?>" class="form-control">
                            <input type="hidden" name="until_when" value="1m" class="form-control">
                            <input type="hidden" name="payment_type" value="points" class="form-control">

                            <div class="col-xs-12 col-md-12">
                                <?
                                $subscription_r = Subscription::where('user_id','=',$user_logat_r->id)->where('course_id','=',$object_r->id)->first();
                                $until_when_time = $subscription_r->until_when.' 00:00:00';
                                    if(strtotime($until_when_time) >= strtotime(date('Y-m-d H:i:s'))) {
                                        if($subscription_r->status == 'active') {
                                            $action = '<h4>You are subscribed <span class="hidden-xs hidden-sm">to this course until: <span style="color:green;font-weight:bold;">'.date("m/d/Y", strtotime($subscription_r->until_when)).'</span></span></h4>';
                                            $dateee = date("m/d/Y", strtotime("+1 day",  strtotime($subscription_r->until_when)));
                                        }
                                    } else {
                                        $action = '<h4>Your subscribtion ended on '.date("m/d/Y", strtotime($subscription_r->until_when)).'</h4>';
                                        $dateee = date('m/d/Y');
                                    }
                                echo $action;
                                ?>
                            </div>
                            
                            <div class="col-xs-12 col-md-12 xdisplay_inputx form-group has-feedback text-left">
                                <label for="starting_from" class="control-label">Free month subscribtion starting from</label>
                                <input type="text" class="form-control has-feedback-left" id="single_cal223" placeholder="date" name="starting_from" value="<?=$dateee?>">
                                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <br/><button type="submit" class="btn btn-primary" id="finalSubmit">CLAIM NOW</button>
                                </div>
                            </div>
                        </form>
                        <script>
                            $('#single_cal223').daterangepicker({
                                singleDatePicker: true,
                                singleClasses: "picker_2"
                            }, function(start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        </script>
                    <? } else { ?> 
                        First time when you want to subscribe to course you need to talk with Mihai Banu 
                    <? } ?>
                </div>
            <? } 
            
        } // end modal cursuri dans 
        //////////////////////////////////////////////////////
        ////////// vezi modale teachers  / ///////////////////
        //////////////////////////////////////////////////////
        if($modal == 'Teacher') { 
            if($dowhat == 'edit') {
        ?>
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?=$object_r->name;?> edit</h4>
            </div>
            <div class="modal-body lower-on-sm text-center img_centered">
                <form class="form-horizontal" method="POST" action="<?=route('add-school-teachers')?>" enctype="multipart/form-data">
                    <?=csrf_field()?>
                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <label for="name" class="control-label">Choose user</label>
                        </div>
                        <div class="col-xs-12 text-left">
                            <input type="hidden" name="school_id" value="<?=getSchoolIdFromCurrentLogedUser()?>">
                            <input type="hidden" name="update" value="<?=$object_r->id;?>">
                            <input type="hidden" name="active" value="yes">
                            <select name="user_id" id="teacher" class="form-control">
                                <option value="">Choose teacher</option>
                                <?
                                foreach ($all_users as $all_users_r) { ?>
                                    <option value="<?=$all_users_r->id?>" <?=$object_r->name == $all_users_r->name ? ' selected':''?> ><?=$all_users_r->name?></option>
                                <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <label for="name" class="control-label">Choose course</label>
                        </div>
                        <div class="col-xs-12 text-left">
                            <select  name="course_id" id="course_id" class="form-control">
                                <option value="">Choose  course</option>
                                <?
                                foreach ($courses as $course_r) {
                                    echo '<option value="'.$course_r->id.'">'.$course_r->level().' - start: '.substr($course_r->started_on,0,10).' - end: '.substr($course_r->ended_on,0,10).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#teacher, #dance_class_id').select2();
                        });
                    </script>
                    
                    <div class="form-group">
                       <div class="col-xs-12 text-center btnPadding">
                            <button type="submit" class="btn btn-primary">
                                Add teacher
                            </button>
                        </div>
                    </div>
                    <br/>
                </form>
                <script>
                $(function() {
                    $('#description2').froalaEditor();
                });
                </script>
            </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center"><?=$object_r->name;?> delete</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-dance-class')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="name" type="hidden" class="form-control" name="name" value="<?=$object_r->name?>">
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="active" value="no">
                                <textarea name="description" style="display:none;"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Delete dance class</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? }
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->name;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-dance-class')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="name" type="hidden" class="form-control" name="name" value="<?=$object_r->name?>">
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="active" value="yes">
                                <textarea name="description" style="display:none;"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Activate dance class</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
            if($dowhat == 'description') { ?>
                <div class="modal-header text-center">Edit <?=$object_r->name;?> profile</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('update-teacher-profile')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input type="hidden" name="teacher_id" value="<?=$object_r->user_id?>">
                                <textarea name="description" class="form-control"><?=$object_r->Description()?></textarea>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('profile_image') ? ' has-error' : '' }}">
                            <div class="col-xs-12 text-left">
                                <label for="profile_image" class="control-label">Teacher profile image</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="file" name="profile_image" id="profile_image" value="{{ $user_logat_r->profile_image }}">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Edit profile</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
        } // end modal teacher

        //////////////////////////////////////////////////////
        ////////// vezi modale useri             /////////////
        //////////////////////////////////////////////////////
         if($modal == 'User') {
            if($dowhat == 'details') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$user_r->name;?> details</h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <div class="row borderBottomGrey">
                        <div class="col-xs-12 col-md-4 text-left">
                            Full name :
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=$user_r->name;?> - <?=$user_r->city;?> <?=$user_r->country;?>, zipcode : <?=$user_r->zipcode;?> 
                        </div>
                    </div>
                    <div class="row borderBottomGrey">
                        <div class="col-xs-12 col-md-4 text-left">
                            Email :
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=$user_r->email?>
                        </div>
                    </div>
                    <div class="row borderBottomGrey">
                        <div class="col-xs-12 col-md-4 text-left">
                            Phone nr :
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=$user_r->phone;?>
                        </div>
                    </div>
                    <div class="row borderBottomGrey">
                        <div class="col-xs-12 col-md-4 text-left">
                            Joined school on :
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=substr($user_r->created_at, 0,10);?>
                        </div>
                    </div>
                    <div class="row borderBottomGrey">
                        <div class="col-xs-12 col-md-4 text-left">
                            Level :
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=$user_r->level;?>
                        </div>
                    </div>
                    <div class="row borderBottomGrey">
                        <div class="col-xs-12 col-md-4 text-left">
                            Started <?=$user_r->level;?> class :
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=substr($user_r->level_date, 0,10);?>
                        </div>
                    </div>
                    <div class="row borderBottomGrey">
                        <div class="col-xs-12 col-md-4 text-left">
                            End <?=$user_r->level;?> class :
                        </div>
                        <div class="col-xs-12 col-md-8 text-left">
                            <?=date('Y-m-d', strtotime("+3 months", strtotime($user_r->level_date)));?>
                        </div>
                    </div>

                    <form class="form-horizontal" method="POST" action="<?=route('edit-school-student-comments')?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="user_id" value="<?=$object_r->id?>">
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="comments" class="control-label">Add comment about this student</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <textarea id="comments" class="form-control" name="comments"><?=$object_r->comments?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <br/>
                                <br/>
                                <button type="submit" class="btn btn-primary">
                                    Add comment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <? } 
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->name;?> edit</h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('edit-school-student')?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                        <input type="hidden" name="user_id" value="<?=$object_r->id?>">
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="user_name" class="control-label">Student name</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="text" name="user_name" value="<?=$object_r->name?>" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="user_name" class="control-label">Student email (if he/she doesn't have an email, leave it preset with no@email.com)</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="text" name="user_email" value="<?=$object_r->email?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="user_phone" class="control-label">Phone number</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input id="user_phone" type="text" class="form-control" name="user_phone" value="<?=$object_r->phone?>" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="gender" class="control-label">Gender</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <select name="gender" class="form-control" required>
                                    <option value="">Select gender</option>
                                    <option value="male" <?=$object_r->gender=='male'?'selected':''?>>male</option>
                                    <option value="female" <?=$object_r->gender=='female'?'selected':''?>>female</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="country" class="control-label">Choose country</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <select name="country" id="country3" class="form-control" required>    
                                    <? foreach ($country_c as $country_r) { ?>
                                        <option value="<?=$country_r->country_name?>" <?=$object_r->country == $country_r->country_name ? 'selected':''?>><?=$country_r->country_name?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="city" class="control-label">City</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input id="city" type="text" class="form-control" name="city" value="<?=$object_r->city?>" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="zipcode" class="control-label">Zipcode</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input id="zipcode" type="text" class="form-control" name="zipcode" value="<?=$object_r->zipcode?>" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="course_id" class="control-label">Choose course</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <select name="course_id" id="course_id" class="form-control">
                                    <option value="">Choose course</option>
                                    <? foreach ($courses as $course_r) { ?>
                                        <option value="<?=$course_r->id?>" <?=$object_r->courses_id == $course_r->id ? 'selected':''?>><?=$course_r->planName()?> - <?=$course_r->level()?> - start: <?=substr($course_r->started_on,0,10)?> - end: <?=substr($course_r->ended_on,0,10)?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#country3').select2();
                            });
                        </script>
                        <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <br/>
                                <br/>
                                <button type="submit" class="btn btn-primary">
                                    Edit user
                                </button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
            if($dowhat == 'modify') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$user_r->name;?> modify points</h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('update-student-points')?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="user_id" value="<?=$object_r->id?>">
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="puncte" class="control-label">Student points</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="text" name="puncte" value="<?=$object_r->puncte?>" class="form-control">
                            </div>
                            <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <br/>
                                <br/>
                                <button type="submit" class="btn btn-primary">
                                    Update user points
                                </button>
                            </div>
                        </div>
                        <br/>
                        </div>
                    </form>
                </div>
            <? } 
            if($dowhat == 'payment') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add a new cash payment for <?=$user_r->name;?></h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('update-student-payment')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <input type="hidden" name="user_id" value="<?=$object_r->id?>">
                        <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">

                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="name" class="control-label">Choose course</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <select name="course_id" id="course_id" class="form-control">
                                    <option value="">Choose course</option>
                                    <?
                                    foreach ($courses as $course_r) {
                                        echo '<option value="'.$course_r->id.'">'.$course_r->planName().' - '.$course_r->level().' - start: '.substr($course_r->started_on,0,10).' - end: '.substr($course_r->ended_on,0,10).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 xdisplay_inputx form-group has-feedback">
                        <? if($object_r->SubscriptionLast()->exists()) {
                                if( strtotime(date('Y-m-d')) < strtotime($object_r->SubscriptionLast->UntilWhen())) {
                                    echo '<span style="color:red;font-weight:bold">subscribtion should start at least from '.$object_r->SubscriptionLast->UntilWhen().' <br/>'.$object_r->SubscriptionLast->UntilWhen().' is the last day of her/his current subscription</span>';
                                }
                            } ?>
                        </div>
                        <div class="col-xs-12 col-md-6 xdisplay_inputx form-group has-feedback">
                            <label for="starting_from" class="control-label">Payment and subscribtion starting from
                            </label>
                            <input type="text" class="form-control has-feedback-left" id="single_cal22" placeholder="date" name="starting_from">
                            <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                            <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                        </div>
                        <div class="col-xs-12 col-md-6 text-left">
                            <label for="until_when" class="control-label">Subscribe and payment for : </label>
                            <select name="until_when" class="form-control" required>
                                <option value="1d">1 day</option>
                                <option value="1m">1 month</option>
                                <option value="2m">2 months</option>
                                <option value="3m">3 months</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <br/>
                                <button type="submit" class="btn btn-primary">
                                    Add cash payment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <script>
                    $('#single_cal22').daterangepicker({
                        singleDatePicker: true,
                        singleClasses: "picker_2"
                    }, function(start, end, label) {
                        console.log(start.toISOString(), end.toISOString(), label);
                    });
                </script>
            <? }
            if($dowhat == 'img') { ?>
                <div class="modal-header text-center">Image <?=$object_r->name;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <img src="<?=url('/').'/'.$object_r->profile_image;?>" class="img-responsive">
                        </div>
                    </div>
                </div>
            <? } 
            if($dowhat == 'remove') { ?>
                <div class="modal-header text-center">Remove <?=$object_r->name;?> from students</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('remove-student')?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="user_id" value="<?=$object_r->id?>">
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <br/>
                                <br/>
                                <button type="submit" class="btn btn-primary">
                                    Remove user
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <? } 
            if($dowhat == 'putback') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->name;?> from students</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('activate-student')?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="user_id" value="<?=$object_r->id?>">
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <br/>
                                <br/>
                                <button type="submit" class="btn btn-primary">
                                    Activate user
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <? } 
        } // end modal users
        if($modal == 'Service') {
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->title;?> edit</h4>
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-services')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <label for="title" class="control-label">Service name</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input id="title" type="text" class="form-control" name="title" value="<?=$object_r->title?>" required autofocus>
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="status" value="<?=$object_r->status?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="description" class="control-label">Description</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <textarea id="description2" class="form-control" name="description"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <div class="col-xs-12 text-left">
                                <label for="image" class="control-label">Add image</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="file" name="image" id="image" value="">
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Update service</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                    <script>
                    $(function() {
                        $('#description2').froalaEditor();
                    });
                    </script>
                </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center"><?=$object_r->title;?> delete</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-services')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="title" type="hidden" class="form-control" name="title" value="<?=$object_r->title?>">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="status" value="inactive">
                                <textarea name="description" style="display:none;"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Delete service</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? }
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->title;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-services')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="title" type="hidden" class="form-control" name="title" value="<?=$object_r->title?>">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="status" value="active">
                                <textarea name="description" style="display:none;"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Activate service</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
        } // end modal cursuri dans
        if($modal == 'Plan') {
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->name;?> edit</h4>
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-plan')?>" enctype="multipart/form-data">
                    <?=csrf_field()?>
                    <?
                    $nrOfDetails      = explode('|', $object_r->details);
                    $countNrOfDetails = count($nrOfDetails);
                    ?>
                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <label for="title" class="control-label">Plan name</label>
                        </div>
                        <div class="col-xs-12 text-left">
                            <input type="text"  name="name" id="name" value="<?=$object_r->name?>" class="form-control" required autofocus>
                            <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                            <input type="hidden" name="status" value="active">
                            <input type="hidden" name="update" value="<?=$object_r->id?>">
                            <input type="hidden" name="nrOfDetails" value="<?=$countNrOfDetails?>" id="nrOfDetail2" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <label for="type" class="control-label">Plan type</label>
                        </div>
                        <div class="col-xs-12 text-left">
                            <select name="type" class="form-control">
                                <option value="">Choose type</option>
                                <option value="senior" <?=$object_r->type=='senior'?'selected':''?>>Senior</option>
                                <option value="adults" <?=$object_r->type=='adults'?'selected':''?>>Adults</option>
                                <option value="children" <?=$object_r->type=='children'?'selected':''?>>Children</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <label for="type" class="control-label">Price</label>
                        </div>
                        <div class="col-xs-12 text-left">
                            <input type="text" name="price" value="<?=$object_r->price?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <label for="currency" class="control-label">Currency</label>
                        </div>
                        <div class="col-xs-12 text-left">
                            <select name="currency" id="currency3" class="form-control">
                                    <option value="">Select currency</option>
                                    <? foreach ($currency_c as $currency_r) { ?>
                                        <option value="<?=$currency_r->code?>" <?=$object_r->currency==$currency_r->code?'selected':''?>><?=$currency_r->code?> - <?=$currency_r->country?></option>
                                    <? } ?>
                                </select>
                        </div>
                    </div>

                    <? for($x=0;$x<($countNrOfDetails);$x++) { ?>
                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <label for="details" class="control-label">Detail nr <?=$x+1?></label>
                        </div>
                        <div class="form-group cloneEl">
                            <div class="col-xs-12 text-left">
                                <input type="text" name="detail<?=$x+1?>" class="form-control" value="<?=$nrOfDetails[$x]?>">
                            </div>
                        </div>
                    </div>
                    <? } ?>

                    <div class="clone nopadding"></div>
                    
                    <div class="col-xs-12 text-right">
                        <div class="col-xs-12 addNewDate">
                            <a href="javascript:void(0)" id="addNewDetail" class="addNewDetail">+ Add extra detail</a>
                        </div>
                    </div>
                    <br/>
                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <label for="front" class="control-label">Visible on front ?</label>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="front"> 
                                <option value="">Choose</option>
                                <option value="yes" <?=$object_r->front=='yes'?'selected':''?>>Yes</option>
                                <option value="no" <?=$object_r->front=='no'?'selected':''?>>No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-left">
                            <label for="position" class="control-label">Position</label>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="position"> 
                                <option value="">Choose</option>
                                <option value="none" <?=$object_r->position=='none'?'selected':''?>>none</option>
                                <option value="1" <?=$object_r->position=='1'?'selected':''?>>1</option>
                                <option value="2" <?=$object_r->position=='2'?'selected':''?>>2</option>
                                <option value="3" <?=$object_r->position=='3'?'selected':''?>>3</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                       <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-primary">
                                Edit plan
                            </button>
                        </div>
                    </div>
                    <br/>
                </form>
                <script>
                    $(document).ready(function() {
                        $('.addNewDetail').on('click', function () {
                            var elNow = parseInt($('#nrOfDetail2').val()) + 1;
                            if(elNow > 10){
                                var html = '<div class="text-center" style="color:red"><strong>Maximum 10 options available</strong></div>';
                            } else {
                                var html  = '<div class="form-group cloneEl'+elNow+'"><div class="col-xs-12 text-left"><label for="detail'+elNow+'" class="control-label">Detail nr '+elNow+'</label></div><div class="col-xs-12 text-left"><input type="text" name="detail'+elNow+'" class="form-control"></div></div>';
                                            
                            }
                            $('.clone').append(html);
                            $('#nrOfDetail2').val(elNow);
                            $('#currency3').select2();
                        });
                    });
                </script>
                </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center"><?=$object_r->name;?> delete</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-plan')?>" enctype="multipart/form-data">
                    <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input type="hidden"  name="name" id="name" value="<?=$object_r->name?>" class="form-control">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="status" value="inactive">
                                <? 
                                $detailxxx    = explode('|', $object_r->details);
                                $countDetails = count($detailxxx);
                                for ($x=0;$x<$countDetails;$x++) { ?>
                                <input type="hidden" name="nrOfDetails" value="<?=$countDetails?>"> 
                                <? } ?>
                                <input type="hidden" name="status" value="inactive">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="type" value="<?=$object_r->type?>">
                                <input type="hidden" name="price" value="<?=$object_r->price?>">
                                <input type="hidden" name="currency" value="<?=$object_r->currency?>">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Delete plan</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? }
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->name;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-plan')?>" enctype="multipart/form-data">
                    <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input type="hidden"  name="name" id="name" value="<?=$object_r->name?>" class="form-control">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="status" value="active">
                                <? 
                                $detailxxx    = explode('|', $object_r->details);
                                $countDetails = count($detailxxx);
                                for ($x=0;$x<$countDetails;$x++) { ?>
                                <input type="hidden" name="detail<?=$x+1?>" value="<?=$detailxxx[$x]?>"> 
                                <? } ?>
                                <input type="hidden" name="nrOfDetails" value="<?=$countDetails?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="type" value="<?=$object_r->type?>">
                                <input type="hidden" name="price" value="<?=$object_r->price?>">
                                <input type="hidden" name="currency" value="<?=$object_r->currency?>">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Activate plan</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
        } // end modal cursuri dans

        if($modal == 'Level') {
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->name;?> edit</h4>
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-level')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <label for="name" class="control-label">Level name</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input id="name" type="text" class="form-control" name="name" value="<?=$object_r->name?>" required autofocus>
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="status" value="<?=$object_r->status?>">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Update level</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                    <script>
                    $(function() {
                        $('#description2').froalaEditor();
                    });
                    </script>
                </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center"><?=$object_r->name;?> delete</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-level')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="name" type="hidden" class="form-control" name="name" value="<?=$object_r->name?>">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="status" value="inactive">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Delete level</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? }
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->name;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-level')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="name" type="hidden" class="form-control" name="name" value="<?=$object_r->name?>">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="status" value="active">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Activate level</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
        } // end modal cursuri dans

        if($modal == 'Event') {
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->title;?> edit</h4>
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-events')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="title" class="control-label">Event name</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input id="title" type="text" class="form-control" name="title" value="<?=$object_r->title?>" required autofocus>
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="status" value="<?=$object_r->status?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="description" class="control-label">Description</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <textarea id="description4" class="form-control" name="description"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="place" class="control-label">Location</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="text" name="place" id="place" class="form-control" value="<?=$object_r->place?>">
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <div class="checkbox">
                                <label class="">
                                    <input type="checkbox" name="free" <?=$object_r->payment=='free'?'checked':''?> class="flat"> This event is free ? 
                                </label>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="price" class="control-label">Price & currency</label>
                            </div>
                            <div class="col-xs-6 text-left">
                                <input type="text" name="price" id="price" class="form-control" value="<?=$object_r->price?>">
                            </div>
                        
                            <div class="col-xs-6 text-left">
                                <select name="currency" id="currency2" class="form-control">
                                    <option value="">Select currency</option>
                                    <? foreach ($currency_c as $currency_r) { ?>
                                        <option value="<?=$currency_r->code?>" <?=$object_r->currency==$currency_r->code?'selected':''?>><?=$currency_r->code?> - <?=$currency_r->country?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="date" class="control-label">Choose date and hour</label>
                            </div>
                            <div class="col-xs-6 text-left">
                                <div class="input-group date">
                                    <input type="text" class="form-control has-feedback-left" id="single_cal10" name="date" value="<?=date("m/d/Y", strtotime($object_r->date));?>">
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="input-group date">
                                    <select name="hour" id="selectHour1" class="form-control">
                                        <? 
                                        $hourAndMinutes = '';
                                        for ($i=7;$i<=22;$i++) { 
                                            $hour = $i;
                                            if($i < 10) { $hour = '0'.$hour; }
                                            for($x=1;$x<=2;$x++) {
                                                if($x == 1) {
                                                    $minutes = '00'; 
                                                } else { 
                                                    $minutes = '30' ; 
                                                }
                                                $hourAndMinutes = $hour.':'.$minutes;
                                                $selected = '';
                                                if($object_r->hour = $hourAndMinutes) {
                                                    $selected = 'selected';
                                                }
                                                echo '<option value="'.$hourAndMinutes.'" '. $selected.'>'.$hourAndMinutes.'</option>';  
                                            }  
                                        } ?>
                                    </select>
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="image" class="control-label">Add image</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="file" name="image" id="image" value="<?=$object_r->image?>">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Update event
                                </button>
                            </div>
                        </div>
                        <br/>
                    </form>
                    <script>
                    $(function() {
                        $('#description4').froalaEditor();
                        $('#currency2').select2();
                    });
                    $('#single_cal10').daterangepicker({
                                singleDatePicker: true,
                                singleClasses: "picker_2"
                            }, function(start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                    </script>
                    
                </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center"><?=$object_r->title;?> delete</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-events')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <input id="title" type="hidden" class="form-control" name="title" value="<?=$object_r->title?>" required autofocus>
                        <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                        <input type="hidden" name="status" value="inactive">
                        <input type="hidden" name="update" value="<?=$object_r->id?>">
                        <input type="hidden" name="description" id="description4" class="form-control" value="<?=$object_r->description?>">
                        <input type="hidden" name="place" id="place" class="form-control" value="<?=$object_r->place?>">
                        <input type="hidden" class="form-control" name="date" value="<?=$object_r->date?>">
                        <input type="hidden" name="hour" id="selectHour1" class="form-control" value="<?=$object_r->hour?>">
                        <input type="hidden" name="payment" id="payment" value="<?=$object_r->payment?>">
                        <input type="hidden" name="price" id="price" value="<?=$object_r->price?>">
                        <input type="hidden" name="currency" id="currency" value="<?=$object_r->currency?>">
                        <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Delete event
                                </button>
                            </div>
                        </div>
                    </form>   
                </div>
            <? }
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->title;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-events')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <input id="title" type="hidden" class="form-control" name="title" value="<?=$object_r->title?>" required autofocus>
                        <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                        <input type="hidden" name="status" value="active">
                        <input type="hidden" name="update" value="<?=$object_r->id?>">
                        <input type="hidden" name="description" id="description4" class="form-control" value="<?=$object_r->description?>">
                        <input type="hidden" name="place" id="place" class="form-control" value="<?=$object_r->place?>">
                        <input type="hidden" class="form-control" name="date" value="<?=$object_r->date?>">
                        <input type="hidden" name="hour" id="selectHour1" class="form-control" value="<?=$object_r->hour?>">
                        <input type="hidden" name="payment" id="payment" value="<?=$object_r->payment?>">
                        <input type="hidden" name="price" id="price" value="<?=$object_r->price?>">
                        <input type="hidden" name="currency" id="currency" value="<?=$object_r->currency?>">
                        <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Activate event
                                </button>
                            </div>
                        </div>
                    </form>  
                </div>
            <? } 
            if($dowhat == 'img') { ?>
                <div class="modal-header text-center">Image <?=$object_r->name;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <img src="<?=url('/').'/'.$object_r->image;?>" class="img-responsive">
                        </div>
                    </div>
                </div>
            <? } 
            if($dowhat == 'details') { ?>
                <div class="modal-header text-center">Details <?=$object_r->title;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-left">
                            EVENT NAME:
                            <?=$object_r->title;?>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-left">
                            EVENT DESCRIPTION:
                            <?=$object_r->description;?>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-left">
                            EVENT LOCATION:
                            <?=$object_r->place;?>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-left">
                            EVENT DATE:
                            <?=substr($object_r->date, 0, 10);?>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-left">
                            PRICE:
                            <?=$object_r->price?> <?=$object_r->currency?>
                            <br>
                        </div>
                    </div>
                </div>
            <? } 
            if($dowhat == 'attending') { 
                $booking_c = Booking::where('event_id','=',$object_r->id)->get();
                $count     = sizeof($booking_c);
            ?>
                <div class="modal-header text-center">Attending to <?=$object_r->title;?> : <?=$count?> pers.</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <div class="col-xs-6 col-md-8 text-left">Name</div>
                        <div class="col-xs-2 col-md-2 text-left">Payment</div>
                        <div class="col-xs-4 col-md-2 text-left">Status</div>
                        <? 
                        $x = 0;
                        foreach ($booking_c as $booking_r) { 
                        $x = $x + 1;
                        ?>
                        <div class="col-xs-6 col-md-8 text-left">
                            <?=$x?> - <?=$booking_r->userName()?>
                        </div>
                        <div class="col-xs-2 col-md-2 text-left">
                            <?=$booking_r->payment?>        
                        </div>
                        <div class="col-xs-4 col-md-2 text-left">
                            <? if($booking_r->payment == 'cash' && $booking_r->payment_status == 'inactive') { ?> 
                                <form class="form-horizontal" method="POST" action="<?=route('aprove-event-booking')?>" enctype="multipart/form-data">
                                    <?=csrf_field()?>
                                    <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                    <input type="hidden" name="user_id" value="<?=$booking_r->user_id?>">
                                    <input type="hidden" name="event_id" value="<?=$booking_r->event_id?>">
                                    <input type="hidden" name="payment_status" value="active">
                                    <input type="hidden" name="booking_id" value="<?=$booking_r->id?>">
                                    <button type="submit" class="btn btn-primary">
                                        Aprove
                                    </button>
                            <? } else { ?> 
                                Aproved
                            <? } ?>
                        </div>
                        <? } ?>
                    </div>
                </div>
            <? } 
            if($dowhat == 'booknow') { 
                //waddone
            ?>
                <div class="modal-header text-center">Book now <?=$object_r->title;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <br/><br/>
                    <h3>BOOK NOW THIS <?=$object_r->payment == 'free'?'FREE ':''?>EVENT</h3>   
                    <form class="form-horizontal" method="POST" action="<?=route('add-event-booking')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                        <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                        <input type="hidden" name="event_id" value="<?=$object_r->id?>">
                        <? if($object_r->payment == 'free') { ?>
                        <input type="hidden" name="payment" value="free">
                        <? } else { ?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <label for="name" class="control-label">Select payment</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <select name="payment" id="payment_type" class="form-control">
                                    <option value="">Select payment</option>
                                    <option value="paypall">Paypal</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank">Bank transfer</option>
                                </select>
                            </div>
                        </div>
                        <?  } ?>
                        <div class="form-group">
                                <div class="col-xs-12 text-center">
                                    <br/>
                                    <a href="javascript:void(0)" class="btn btn-info" id="ShowPaymentDetails">
                                        SHOW DETAILS FOR PAYMENT
                                    </a>
                                </div>
                            </div>
                            <script>
                                $( "#ShowPaymentDetails" ).click(function() {
                                    var paymentType   = $("#payment_type option:selected").val();    
                                    
                                    if(paymentType == '') {
                                        $("#DivMesaje").html('<br/><span class="ShowPaymentMesaje">PLEASE CHOOSE PERIOD AND PAYMENT TYPE</span><br/>');  
                                    }
                                    var paymentAmount = <?=$object_r->price?>                     
                            
                                    if(paymentType == 'paypall') {
                                        $("#DivMesaje").html('<br/><span class="ShowPaymentMesaje">You choosed to pay with Paypall - '+paymentAmount+' <?=config('app.currency')?> </span><br/>');  
                                        $("#DivPaypall").removeClass('hidden');
                                        $("#bankTranferSubmitButton").addClass('hidden');
                                        $("#DivBank").addClass('hidden');
                                        $("#DivCash").addClass('hidden');
                                    }
                                    if(paymentType == 'bank') {
                                        $("#DivMesaje").html('<br/><span class="ShowPaymentMesaje">You choosed to pay with Bank transfer - '+paymentAmount+' <?=config('app.currency')?> </span><br/>'); 
                                        $("#DivPaypall").addClass('hidden'); 
                                        $("#DivCash").addClass('hidden');
                                        $("#DivBank").html('<span style="font-size:14px;color:#000;font-weight:bold"><br/>YOU HAVE TO TRANSFER THE AMOUNT IN LATINLOVE ACCOUNT<br/>Latin Love Ltd. <br/>Sort code 208956<br/>Account number 23049698<br/> Please add this referrence string to bank details so we can to distinguish your transction:</span><br/> <br/> <span style="color:blue;font-weight:bold;font-size:17px;">S<?=$object_r->id?>U<?=$user_logat_r->id?>D<?=date('Y-m-d')?></span>');
                                        $("#bankTranferSubmitButton").removeClass('hidden');
                                        $("#finalSubmit").text('PAY NOW');
                                    }
                                    if(paymentType == 'cash') {
                                        $("#DivMesaje").html('<br/><span class="ShowPaymentMesaje">You choosed to pay cash at event entrance - '+paymentAmount+' <?=config('app.currency')?> </span><br/>'); 
                                        $("#DivPaypall").addClass('hidden'); 
                                        $("#DivBank").addClass('hidden');
                                        $("#DivCash").removeClass('hidden');
                                        $("#DivCash").html('<span style="font-size:14px;color:#000;font-weight:bold"><br/>YOU HAVE TO PAY CASH THE AMOUNT OF '+paymentAmount+' <?=config('app.currency')?> AT EVENT ENTRANCE');
                                        $("#bankTranferSubmitButton").removeClass('hidden');
                                        $("#finalSubmit").text('BOOK NOW');
                                        
                                    }
                                });
                            </script>
                            
                            <div class="form-group">
                                <div class="col-xs-12" id="DivMesaje">
                                </div>
                                <div class="col-xs-12 hidden" id="DivPaypall">
                                    <br/><br/>
                                    <div id="paypal-button"></div>
                                    <script>
                                        // office@latinlovedanceschool.com
                                        // Sophie1love

                                        // office-buyer@latinlovedanceschool.com
                                        // 123456789

                                        // office-facilitator@latinlovedanceschool.com
                                        // Sophie1love
                                        
                                        paypal.Button.render({
                                            env: '<?=config('app.paypal_mode')?>', // Or 'sandbox',
                                            client: {
                                                sandbox:    '<?=config('app.paypal_client_id_sandbox')?>',
                                                production: '<?=config('app.paypal_client_id_production')?>'
                                            },
                                            commit: true, // Show a 'Pay Now' button
                                            style: {
                                                color: 'gold',
                                                size: 'small'
                                            },
                                            payment: function(data, actions) {
                                                // Make a call to the REST api to create the payment
                                                var paymentAmount   = <?=$object_r->price?>;  
                                                
                                                return actions.payment.create({
                                                    payment: {
                                                        transactions: [
                                                            {
                                                                amount: { total: paymentAmount, currency: 'GBP' }
                                                                
                                                            }
                                                        ]
                                                    }
                                                });
                                            },
                                            onAuthorize: function(data, actions) {
                                                // Make a call to the REST api to execute the payment
                                                return actions.payment.execute().then(function() {
                                                    document.querySelector('#finalSubmit').click();
                                                });
                                            },
                                            onCancel: function(data, actions) {
                                                return document.querySelector('#statusForPaypall').innerText = 'Paypal payment canceled!';
                                            },
                                            onError: function(err) {
                                            /*
                                            * An error occurred during the transaction
                                            */
                                            }
                                        }, '#paypal-button');
                                    </script>
                                </div>
                                <div class="col-xs-12" id="DivBank">
                                </div>
                                <div class="col-xs-12" id="DivCash">
                                </div>
                                <div class="col-xs-12" id="statusForPaypall">
                                </div>


                                <div class="form-group hidden" id="bankTranferSubmitButton">
                                    <div class="col-xs-12 text-center">
                                        <br/><button type="submit" class="btn btn-primary" id="finalSubmit">PAY NOW</button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            <? } 
            if($dowhat == 'sendnotifications') { ?>
                <div class="modal-header text-center">Send event notification</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <form class="form-horizontal" method="POST" action="<?=route('admin-newsletter-post')?>" enctype="multipart/form-data">
                                <?=csrf_field()?>
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">   
                                <div class="form-group">
                                    <div class="col-xs-12 text-left">
                                        <label for="description" class="control-label">List</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <select name="list" class="form-control">
                                            <option value="">Select recipients</option>
                                            <option value="all">All users</option>
                                            <option value="all-assigned">Users assigned to course</option>
                                            <option value="all-not-assigned">Users not assigned to any of courses</option>
                                            <option value="newsletter">Users assigned to newsletter</option>
                                            <? foreach ($course_c as $course_r) { ?>
                                            <option value="<?=$course_r->id?>">Users assigned to <?=$course_r->PlanName()?> <?=$course_r->Level()?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="form-group">
                                    <div class="col-xs-12 text-left">
                                        <label for="title" class="control-label">Notification title</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input type="text" class="form-control" name="title" value="<?=$object_r->title?>">
                                    </div>
                                </div>
                                <br/>
                                <div class="form-group">
                                    <div class="col-xs-12 text-left">
                                        <label for="description" class="control-label">Notification text</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <textarea id="description2" class="form-control" name="description"><?=$object_r->description?>
                                            <hr>
                                            event: <?=$object_r->title?><br/>
                                            date: <?=substr($object_r->date, 0,10)?> <?=$object_r->hour?><br/>
                                            price: <?=$object_r->price?> <?=$object_r->currency?><br/>
                                            place: <?=$object_r->place?><br/>
                                        </textarea>
                                    </div>
                                </div>
                                <br/>
                                <div class="form-group">
                                   <div class="col-xs-12 text-center btnPadding">
                                        <button type="submit" class="btn btn-primary">Send event notification</button>
                                    </div>
                                </div>
                                <br/>
                            </form>
                            <script>
                            $(function() {
                                $('#description2').froalaEditor();
                            });
                            </script>
                    </div>
                </div>
            <? }
        } // end modal cursuri dans
        if($modal == 'Friend') {
            if($dowhat == 'sendinvitation') { ?>
                <div class="modal-header text-center">Send Invitation</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <form class="form-horizontal" method="POST" action="<?=route('send-invitation')?>">
                            <?=csrf_field()?>
                            <input type="hidden" class="form-control" name="friend_id" value="<?=$object_r->id?>">
                            <div class="form-group">
                                <div class="col-xs-12 text-left">
                                    <label for="title" class="control-label">Invitation title</label>
                                </div>
                                <div class="col-xs-12 text-left">
                                    <input type="text" class="form-control" name="title" value="Hello dear <?=$object_r->name?>">
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                                <div class="col-xs-12 text-left">
                                    <label for="description" class="control-label">Invitation text</label>
                                </div>
                                <div class="col-xs-12 text-left">
                                    <textarea id="description2" class="form-control" name="description">
                                        I am very happy to invite you to Latin Love Dance School, I just joined their school and I am having a lot of fun here. <br/>
                                        They have all sorts of interesting classes, for adults and children, check out their website www.LatinLoveDanceSchool.com  <br/><br/>
                                        See you on the dance floor,<br/>
                                        <?=$user_logat_r->name?>
                                    </textarea>
                                </div>
                            </div>
                            <br/>
                            <div class="form-group">
                               <div class="col-xs-12 text-center btnPadding">
                                    <button type="submit" class="btn btn-primary">Send invitation</button>
                                </div>
                            </div>
                            <br/>
                        </form>
                        <script>
                        $(function() {
                            $('#description2').froalaEditor();
                        });
                        </script>
                    </div>
                </div>
            <? }
            if($dowhat == 'addpoints') { ?>
                <div class="modal-header text-center">Add points to your current amount of points</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <form class="form-horizontal" method="POST" action="<?=route('add-points-referrer')?>">
                            <?=csrf_field()?>
                            <input type="hidden" class="form-control" name="user_id" value="<?=$user_logat_r->id?>">
                            <input type="hidden" class="form-control" name="friend_id" value="<?=$object_r->id?>">
                            <input type="hidden" class="form-control" name="points" value="<?=config('app.referrer_points')?>">
                            <div class="form-group">
                               <div class="col-xs-12 text-center btnPadding">
                                    <button type="submit" class="btn btn-primary">Add points</button>
                                </div>
                            </div>
                            <br/>
                        </form>
                    </div>
                </div>
            <? }
        }
        
        if($modal == 'Quote') {
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->quote;?> edit</h4>
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-quotes')?>" enctype="multipart/form-data">
                    <?=csrf_field()?>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="quote" class="control-label">Quote</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <textarea id="quote" class="form-control" name="quote" required><?=$object_r->quote?></textarea>
                                <input type="hidden" name="status" value="active">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="author" class="control-label">Author</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input id="author" type="text" class="form-control" name="author" value="<?=$object_r->author?>" required autofocus>
                            </div>
                        </div>
                        <br/>
                        
                        <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Add quote
                                </button>
                            </div>
                        </div>           
                    </form>
                    
                </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center"><?=$object_r->quote;?> delete</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-quotes')?>" enctype="multipart/form-data">
                    <?=csrf_field()?>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <input type="hidden" id="quote" name="quote" value="<?=$object_r->quote?>">
                                <input type="hidden" id="author" name="author" value="<?=$object_r->author?>" >
                                <input type="hidden" name="status" value="inactive">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" class="form-control" name="author" id="author" value="<?=$object_r->author?>">
                            </div>
                        </div>

                        <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Delete quote
                                </button>
                            </div>
                        </div>           
                    </form>
                </div>
            <? }
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->quote;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-quotes')?>" enctype="multipart/form-data">
                    <?=csrf_field()?>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <input type="hidden" id="quote" name="quote" value="<?=$object_r->quote?>">
                                <input type="hidden" id="author" name="author" value="<?=$object_r->author?>" >
                                <input type="hidden" name="status" value="active">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" class="form-control" name="author" id="author" value="<?=$object_r->author?>">
                            </div>
                        </div>

                        <div class="form-group">
                           <div class="col-xs-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Activate quote
                                </button>
                            </div>
                        </div>           
                    </form>
                </div>
            <? } 
            if($dowhat == 'img') { ?>
                <div class="modal-header text-center">Image <?=$object_r->name;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <img src="<?=url('/').'/'.$object_r->image;?>" class="img-responsive">
                        </div>
                    </div>
                </div>
            <? } 
        } // end modal cursuri dans
        
        //////////////////////////////////////////////////////
        ////////// vezi modale ce vine  //////////////////////
        //////////////////////////////////////////////////////
        if($modal == 'Blog') {
            if($dowhat == 'see') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->title;?> description</h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <?=$object_r->description;?>
                </div>
            <? } 
            if($dowhat == 'edit') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?=$object_r->title;?> edit</h4>
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-blog-article')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <label for="name" class="control-label">Blog title</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input id="title" type="text" class="form-control" name="title" value="<?=$object_r->title?>" required autofocus>
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="active" value="yes">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-left">
                                <label for="description" class="control-label">Description</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <textarea id="description2" class="form-control" name="description"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                            <div class="col-xs-12 text-left">
                                <label for="image" class="control-label">Add image</label>
                            </div>
                            <div class="col-xs-12 text-left">
                                <input type="file" name="image" id="image" value="<?=$object_r->image1?>">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Update blog article</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                    <script>
                    $(function() {
                        $('#description2').froalaEditor();
                    });
                    </script>
                </div>
            <? } 
            if($dowhat == 'delete') { ?>
                <div class="modal-header text-center"><?=$object_r->title;?> delete</div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-blog-article')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="title" type="hidden" class="form-control" name="title" value="<?=$object_r->title?>" required autofocus>
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="active" value="no">
                                <textarea name="description" style="display:none;"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Delete blog article</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? }
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">Activate <?=$object_r->title;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('add-blog-article')?>" enctype="multipart/form-data">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input id="title" type="text" class="form-control" name="title" value="<?=$object_r->title?>" required autofocus>
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="update" value="<?=$object_r->id?>">
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="active" value="yes">
                                <textarea name="description" style="display:none;"><?=$object_r->description?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Activate blog article</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
            if($dowhat == 'img') { ?>
                <div class="modal-header text-center">Image <?=$object_r->title;?></div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <img src="<?=url('/').'/'.$object_r->image1;?>" class="img-responsive">
                        </div>
                    </div>
                </div>
            <? }
        } // end modal cursuri dans 
        if($modal == 'Payment') {
            if($dowhat == 'details') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">#<?=$object_r->reference_nr;?> Details</h4>
                </div>
                <div class="modal-body lower-on-sm text-left img_centered">
                    <?
                    $payment_user_r = User::where('id','=',$object_r->user_id)->first();
                    ?>
                    Name: <?=$payment_user_r->name;?><br/>
                    Amount: <?=$object_r->amount;?> <?=$object_r->currency;?><br/>
                    Status: <?=$object_r->status;?><br/>
                    Type: <?=$object_r->type;?><br/>
                    <?
                    if($object_r->payment_for == 'subscription') {
                        $subsc_r  = Subscription::where('id','=',$object_r->payment_for_id)->first();
                        $course_r = Course::where('id','=',$subsc_r->course_id)->first();
                        $payment_for_details = $course_r->planName().' - '.$course_r->Level().' - until '.$subsc_r->until_when;
                    } else {
                        $event_r  = Event::where('id','=',$object_r->payment_for_id)->first();
                        $payment_for_details = $event_r->title;
                    }
                    ?>
                    Payment for: <?=$payment_for_details?> <br/>
                    Payment date: <?=$object_r->date;?><br/>
                </div>
            <? } 
            if($dowhat == 'activate') { ?>
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Activate this payment</h4>
                </div>
                <div class="modal-body lower-on-sm text-center img_centered">
                    <form class="form-horizontal" method="POST" action="<?=route('activate-payment')?>">
                        <?=csrf_field()?>
                        <div class="form-group>">
                            <div class="col-xs-12 text-left">
                                <input type="hidden" name="payment_id" value="<?=$object_r->id?>">
                                <input type="hidden" name="status" value="active">
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-xs-12 text-center btnPadding">
                                <button type="submit" class="btn btn-primary">Activate payment</button>
                            </div>
                        </div>
                        <br/>
                    </form>
                </div>
            <? } 
        } 
        ?>

                                       
        <div class="modal-footer text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

<? // 
    }


}
