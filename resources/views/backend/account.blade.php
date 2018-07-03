@extends('layouts.backend.app')

@section('content')
    <?if($user_logat_r->type == 'superadmin') { ?> 
    <div class="row tile_count">
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-address-card"></i></i> Dance styles</span>
                <div class="count"><?=sizeof($user_logat_r->DanceClasses)?></div>
            <span class="count_bottom"><i class="green"><?=sizeof($user_logat_r->DanceClasses)?></i> assigned classes</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-address-card"></i></i> Dance groups</span>
                <div class="count"><?=$dance_groups_count?></div>
            <span class="count_bottom"><i class="green"><?=$dance_groups_count?></i> assigned groups</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Students</span>
                <div class="count"><?=$students_count?></div>
            <span class="count_bottom"><i class="green"><?=sizeof($students_count)?></i> assigned students</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i>No subscription</span>
                <div class="count"><?=$students_count_no_sub?></div>
            <span class="count_bottom"><i class="green"><?=$students_count_no_sub?></i> students</span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-calendar"></i> Events</span>
                <div class="count green"><?=$events_count?></div>
        </div>
        
        <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Monthly payments</span>
            <div class="count"><?=$payment_this_month_r?></div>
            <span class="count_bottom"><?=config('app.currency')?></span>
        </div>
        
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h3>DANCE STYLES</h3>
                    <div class="subtitle"><?=sizeof($user_logat_r->DanceClasses)?> dance classes</div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                            <?
                            foreach ($dance_classes_c as $dance_classes_r) {
                               echo $dance_classes_r->name.'<br/>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h3>DANCE GROUPS</h3>
                    <div class="subtitle"><?=$dance_groups_count?> dance groups</div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                           <?
                           foreach ($dance_groups_c as $dance_groups_r) {
                               echo $dance_groups_r->planName().'<br/>';
                               echo '<span style="font-size:12px;color:#000;line-height:14px;">start on:'.substr($dance_groups_r->started_on, 0,10).' - ends on:'.substr($dance_groups_r->ended_on, 0,10).'</span>';
                               echo '<hr/>';
                           }
                           ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h3>STUDENTS</h3>
                    <div class="subtitle"><?=$students_count?> subscribed students</div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                           <?
                           foreach ($students_c as $students_r) {
                               echo $students_r->name.'<br/>';
                           }
                           ?>
                           <br/>
                           <a href="{{ route('my-school-students') }}">view all students</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h3>EVENTS</h3>
                    <div class="subtitle">future events</div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="tile-stats">
                    <div class="icon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="count"><?=sizeof($events_c)?></div>
                      <h3><?=sizeof($events_c)==1?'Event':'Events'?></h3>
                      <?
                        $x = 0;
                        foreach ($events_c as $events_r) { 
                        $x = $x + 1;
                        if($x <= 3) { 
                          echo '<p><a href="'.route('events-name', ['name' => strtolower(str_replace(' ', '-', $events_r->title)) ]).'" target="_blank">'.$events_r->title.' - '.substr($events_r->date,0,10).' '.$events_r->hour.'</a></p>';
                        }  else { ?> 
                        ... view all events
                      <? }
                      } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="x_panel tile overflow_hidden">
                <div class="x_title">
                    <h2>SUBSCRIPTION TO DANCE GROUPS</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="" style="width:100%">
                        <tbody>
                            <tr>
                                <th style="width:45%;">
                                    <p>Top <?=$dance_groups_count?> dance groups</p>
                                </th>
                                <th>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                        <p class="">Dance groups</p>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                        <p class="">Student Procent</p>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    <iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                                        <canvas class="canvasDoughnut2" height="140" width="140" style="margin: 15px 10px 10px 0px; width: 140px; height: 140px;"></canvas>
                                </td>
                                <td>
                                    <table class="tile_info">
                                      <tbody>
                                            <? 
                                            $x = 0;
                                            $dataChart = '';
                                            $labels    = '';
                                            foreach ($dance_groups_c as $dance_groups_r) {
                                            $x = $x + 1;
                                            if($x == 1) { $color = 'blue'; }
                                            if($x == 2) { $color = 'purple'; }
                                            if($x == 3) { $color = 'red'; }
                                            if($x == 4) { $color = 'green'; }
                                            if($all_subscribed_users == 0) {
                                                $all_subscribed_users = 1;
                                            }
                                            $procent = round($dance_groups_r->NumberOfSubscribedUsers()/$all_subscribed_users * 100,2);
                                            $dataChart .= round($procent,0).',';
                                            $labels    .= '"'.$dance_groups_r->planName().'",';
                                            ?>
                                            
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square <?=$color?>"></i> <?=$dance_groups_r->planName()?> </p>
                                                </td>
                                                <td>
                                                    <p>
                                                    <?=$dance_groups_r->NumberOfSubscribedUsers()?> st. - <?=$procent?>%
                                                    </p>
                                                </td>
                                            </tr>
                                            <? } ?>
                                        </tbody>
                                    </table>
                                    <script>
                                        function init_chart_doughnut2(){
                                            if( typeof (Chart) === 'undefined'){ return; }
                                            if ($('.canvasDoughnut2').length){
                                            var chart_doughnut_settings = {
                                                    type: 'doughnut',
                                                    tooltipFillColor: "rgba(51, 51, 51, 0.55)",
                                                    data: {
                                                        labels: [
                                                            <?=$labels?>
                                                        ],
                                                        datasets: [{
                                                            data: [<?=$dataChart?>],
                                                            backgroundColor: [
                                                                "#0000FF",
                                                                "#9B59B6",
                                                                "#E74C3C",
                                                                "#26B99A",
                                                                "#3498DB"
                                                            ],
                                                            hoverBackgroundColor: [
                                                                "#CFD4D8",
                                                                "#B370CF",
                                                                "#E95E4F",
                                                                "#36CAAB",
                                                                "#49A9EA"
                                                            ]
                                                        }]
                                                    },
                                                    options: { 
                                                        legend: false, 
                                                        responsive: false 
                                                    }
                                                }
                                                $('.canvasDoughnut2').each(function(){
                                                    var chart_element = $(this);
                                                    var chart_doughnut = new Chart( chart_element, chart_doughnut_settings);
                                                });         
                                            }  
                                        }
                                        $(document).ready(function() {
                                            init_chart_doughnut2();
                                        }); 
                                    </script>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="x_panel ui-ribbon-container fixed_height_390">          
                <? 
                if($students_count != 0) {
                    $male_procent   = round($male_count/$students_count * 100,2);
                    $female_procent = round($female_count/$students_count * 100,2);
                } else {
                    $male_procent   = 0;
                    $female_procent = 0;
                }
                
                ?>
                <div class="x_content">
                    <div style="text-align: center; margin-bottom: 17px">
                        <span class="chart" data-percent="<?=$male_procent?>">
                        <span class="percent"><?=$male_procent?></span>
                        <canvas height="110" width="110"></canvas></span>
                    </div>
                    <h3 class="name_title"><?=$male_count?> <?=$male_count=='1'?'male':'males'?> from total of <?=$students_count?> students</h3>
                    <div class="divider"></div>
                    <p>Number of males assigned and subscribed to a course</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="x_panel ui-ribbon-container fixed_height_390">          
                
                <div class="x_content">
                    <div style="text-align: center; margin-bottom: 17px">
                        <span class="chart" data-percent="<?=$female_procent?>">
                        <span class="percent"><?=$female_procent?></span>
                        <canvas height="110" width="110"></canvas></span>
                    </div>
                    <h3 class="name_title"><?=$female_count?> <?=$female_count=='1'?'female':'females'?> from total of <?=$students_count?> students</h3>
                    <div class="divider"></div>
                    <p>Number of females assigned and subscribed to a course</p>
                </div>
            </div>
        </div>
    </div>
    
    <? } ?>
    <?if($user_logat_r->type == 'client') { ?> 
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h3>Your account</h3>
                    <div class="subtitle">your current profile level is at <?=$user_logat_r->getProfileLevel()?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                            <? 
                            if(sizeof($user_logat_r->Subscription) >= 1) {
                                $user_logat_r->InfoAboutActiveSubscription();
                            } else { ?>    
                                Currently you are not subscribed to any plan. <br/>
                                Please subscribe now <br/> 
                                <div class="text-center">
                                  <br/><br/>
                                  <a href="{{route('account-join-courses')}}" class="btn btn-primary">Click here</a>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 fixed_height_320">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h3>My Points</h3>
                    <div class="subtitle">Earn 600 points and get a free month subscription</div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="col-xs-12">
                    <div style="text-align: center; margin-bottom: 17px">
                        <span class="chart" data-percent="<?=$user_logat_r->PercentagePoints();?>">
                        <span class="percent"><?=$user_logat_r->PercentagePoints();?></span>
                        <canvas height="110" width="110"></canvas></span>
                    </div>
                  </div>
                  <div class="col-xs-12 text-center">
                    <h3 class="name_title"><?=$user_logat_r->puncte;?> points</h3>
                    <? if($user_logat_r->puncte >= 600) {?> 
                        <a href="{{route('account-claim-prize')}}" class="btn btn-primary">Claim prize</a>
                    <? } else { ?> 
                        Currently you have <?=$user_logat_r->puncte;?> points.     
                    <? } ?>        
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 fixed_height_320">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h3>My Profile</h3>
                    <div class="subtitle"><?=$user_logat_r->name?></div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="flex">
                    <ul class="list-inline widget_profile_box">
                        <!--
                        <li><a><i class="fa fa-facebook"></i></a></li>
                        -->
                        <li><img src="<?=$user_logat_r->avatar()?>" alt="..." class="img-circle profile_img"></li>
                        <!--
                        <li><a><i class="fa fa-twitter"></i></a></li>
                        -->
                    </ul>
                  </div>
                  <br/>
                  <p><?=$user_logat_r->city?> - <?=$user_logat_r->country?></p>
                  <p><?=$user_logat_r->email?></p>
                  <p><?=$user_logat_r->phone?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 fixed_height_320">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h3>Events</h3>
                    <div class="subtitle">future events</div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="tile-stats">
                          <div class="icon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <div class="count"><?=sizeof($events_c)?></div>
                          <h3><?=sizeof($events_c)==1?'Event':'Events'?></h3>
                          <?
                            $x = 0;
                            foreach ($events_c as $events_r) { 
                            $x = $x + 1;
                            if($x <= 3) { 
                              echo '<p><a href="'.route('events-name', ['name' => strtolower(str_replace(' ', '-', $events_r->title)) ]).'" target="_blank">'.$events_r->title.' - '.substr($events_r->date,0,10).' '.$events_r->hour.'</a></p>';
                            }  else { ?> 
                            ... view all events
                          <? }
                          } ?>
                          
                        </div>
                  
                </div>
            </div>
        </div>
    </div>
    <? } ?>
    <?if($user_logat_r->type == 'teacher') { ?> 
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Your timetable</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <?
    $teacher_c = App\Teacher::where('user_id','=',$user_logat_r->id)->get();
    $courses_array = array();
    foreach ($teacher_c as $teacher_r) {
        $courses_array[] = $teacher_r->course_id;
    }
    $teacher_courses_c = App\Course::where('active','=','yes')->whereIn('id', $courses_array)->get();
    ?>
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
                    //right: 'month'
                    right: 'month,agendaWeek,agendaDay'
                },
                minTime: "09:00:00",
                maxTime: "21:00:00",
                height: 'auto',
                timeFormat: 'H:mm -',
                events: [
                    <? 
                    $color = 0;
                    foreach ($teacher_courses_c as $courses_r) {
                        $color      = $color + 1;
                        if($color == 1) { $colorCode = 'red';}
                        if($color == 2) { $colorCode = 'blue';}
                        if($color == 3) { $colorCode = 'green';}
                        if($color == 4) { $colorCode = 'yellow';}
                        if($color == 5) { $colorCode = 'black';}
                        if($color == 6) { $colorCode = 'pink';}
                        if($color == 7) { $colorCode = 'BlueViolet';}
                        if($color == 8) { $colorCode = 'DarkMagenta';}
                        if($color == 9) { $colorCode = 'LightSlateGrey';}
                        $begin      = new \DateTime(substr($courses_r->started_on, 0,10));
                        $end        = new \DateTime(substr($courses_r->ended_on, 0,10));
                        $interval   = \DateInterval::createFromDateString('1 day');
                        $period     = new \DatePeriod($begin, $interval, $end);
                        $hourEx     = explode(':', $courses_r->hours);
                        $hour       = $hourEx[0];
                        $title      = ' '.$courses_r->PlanName().' '.$courses_r->Level().'\nteacher: '.$courses_r->Teacher();
                        $students   = $courses_r->NameOfSubscribedUsers();
                        $dates_of_w = explode(',', $courses_r->dates);
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
                                    students : '<?=$students?>',
                                    start: '<?=$dt->format("Y");?>-<?=$dt->format("m");?>-<?=$dt->format("d");?>T<?=$hour?>:00:00',
                                    end: '<?=$dt->format("Y");?>-<?=$dt->format("m");?>-<?=$dt->format("d");?>T<?=$hour_p1?>:00:00',
                                    allDay: false,
                                    color: '<?=$colorCode?>'
                                }  ,
                        <?  } // end if in array 
                        } // end date foreach
                    } // first foreach
                    ?>
                ], 
                eventRender: function(event, element) {
                    element.qtip({
                        content: event.students
                    });
                },
                eventClick:  function(event, jsEvent, view) {
                    $('#modalTitle').html(event.title);
                    $('#modalBody222').html(event.students);
                    $('#fullCalModal').modal();
                }
                
            });

        });
    </script>  
    <? } ?>
    <div id="fullCalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                </div>
                <div id="modalBody222" class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection