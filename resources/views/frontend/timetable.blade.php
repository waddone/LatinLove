@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1 titleH3">
                <h1>Timetable</h1>
            </div>
            <div class="col-xs-12 col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

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
                    foreach ($courses_c as $courses_r) {
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
                
            });

        });
    </script>  

@endsection