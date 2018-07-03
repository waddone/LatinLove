@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 text-left NormalPageH1">
                <h1><?=$teacher_r->name()?> - teacher</h1>
            </div>
            <div class="col-xs-12 col-md-3 col-md-offset-1 pozaFrontend2">
                <div style="background: url('<?=url('/').'/'.$teacher_r->ProfileImg();?>')"></div>
            </div>
            <div class="col-xs-12 col-md-8 descriptionEverywhere">
                <div class="row">
                    <div class="col-xs-12">
                        <h3>Where do I teach?</h3>
                        <ul>
                        <? foreach ($course_c as $course_r) { 
                            $dates = explode(',', $course_r->dates);
                            $hours = explode(',', $course_r->hours);
                            $dateAndTime = '';
                            foreach (array_combine($dates, $hours) as $date => $hour) {
                                if($date == 'Mo') { $nameDate = 'Monday'; }
                                if($date == 'Tu') { $nameDate = 'Tuesday'; }
                                if($date == 'We') { $nameDate = 'Wednesday'; }
                                if($date == 'Th') { $nameDate = 'Thursday'; }
                                if($date == 'Fr') { $nameDate = 'Friday'; }
                                if($date == 'Sa') { $nameDate = 'Saturday'; }
                                if($date == 'Su') { $nameDate = 'Sunday';  }
                                $dateAndTime .= '<span style="font-size:13px;display:block;color:red">every <i class="far fa-calendar-alt"></i> '.$nameDate.'-'.$hour.'</span>';
                                //print $code . 'is your Id code and '  . $name . 'is your name';
                            }
                            $dateAndTimeBun = $dateAndTime;
                        ?>
                           <li><strong><?=$course_r->PlanName();?></strong> - <?=$course_r->Level()?> <?=
                           $dateAndTime?></li>
                        <? } ?>
                        </ul>
                    </div>
                </div>
                    <h3>About me</h3>
                <?=$teacher_r->description()?>
                <br/>
                <br/>
                <div class="shareDiv">
                    <div class="fbDiv">
                        <div class="fb-share-button" data-href="<?=Route::currentRouteName();?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
                    </div>
                    <div class="GgDiv">
                        <a class="tumblr-share-button" href="https://www.tumblr.com/share"></a>
                    </div>
                    <div class="TwDiv">
                        <a href="http://www.twitter.com/share?url=<?=Route::currentRouteName();?>&text=<?=$teacher_r->name()?>" class="twitter-share-button" data-show-count="true">Tweet</a>
                        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div>
                    <!--
                    <div class="ThDiv">
                        <g:plus action="share"></g:plus>
                        <script src="https://apis.google.com/js/platform.js" async defer></script>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
@endsection