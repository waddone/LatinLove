@extends('layouts.frontend.app')

@section('content')
    <div class="container-fluid banners" id="banner" style="background: url({{ url('/resources/assets/images/banner_10.jpg') }})">
        <div class="row">
            <div class="col-md-5 col-md-offset-1">
                <div id="carouselHome" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner" role="listbox">
                        <? 
                        $x = 0;
                        foreach ($quote_c as $quote_r) { 
                            $x = $x +1 ;
                        ?>
                        <div class="item <?=$x==1?'active':''?>">
                            <div class="quateBlock">
                                <span class="quote">Quote</span>
                                <div class="right_line"></div>
                                <h2 class="h2_banner">
                                    <p><?=$quote_r->quote?></p>
                                </h2>
                                <div class="left_line"></div>
                                <span class="author"><?=$quote_r->author?></span>
                            </div>
                        </div>
                        <? } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6"></div>
        </div>
        <script>
            $( document ).ready(function() {
                $('#carouselHome').carousel({
                    interval: 7000
                });
            });
        </script>
        <!--
        <div class="row">
            <div class="col-xs-12 col-md-6 col-md-offset-3 titleSearchLocation text-center">
                SEARCH OUR DANCE SCHOOLS BY ZIPCODE
            </div>
            <div id="custom-search-input">
                <div class="input-group col-xs-12 col-md-4 col-md-offset-4 searchLocation">
                    <form method="POST" action="">
                        <input type="text" class="  search-query form-control" placeholder="Search" />
                        <span class="input-group-btn">
                            <button class="btn btn-danger" type="button">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </span>
                    </form>
                </div>
            </div>
        </div>
        -->
    </div>

     @if(Session::has('flash_message'))
        <div class="container-fluid">
            <div class="row">
                <br/><br/>
                <div class="col-xs-12 col-md-8 col-md-offset-2 alert alert-success contact">
                    <em> {!! session('flash_message') !!}</em>
                </div>
            </div>
        </div>
    @endif


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center presentation">
                <h2 class="upper grey">Learn how to dance with us</h2>
                <p class="grey_75">
                    Dancing is the best way to relax after a hard day's work. If you want to make new friends, do some exercises or just change the every day routine, you've came to the best place! <br/><br/>

                    International dance school that started in Romania, now with two branches: Cairo, Egypt and London, UK with a unique teaching style, Latin Love has great success and the school is growing month after month!<br/><br/>

                    We offer you exciting new dance styles, like Salsa, Bachata, Merengue, Cha Cha, Kizomba, Reggaeton, Rueda de casino and Zumba!<br/><br/>

                    Learn from Latin Love Team! Many years of experience in dancing and teaching around the world, countries like UK, Romania, Egypt, Singapore and Malaysia!
                </p>
                <div class="col-xs-12 buttons_block">
                    <br/>
                    <a class="btn-default-new-layout btn-new-layout-white" id="header-arrow" href="#scrollTo" data-href-mobile="#scrollTo">Sign Up</a>
                    <span class="margin_left_30"></span>
                    <a class="btn-default-new-layout btn-new-layout-red" href="<?=route('about-us')?>">All about us</a>
                </div>
                <script type="text/javascript">
                    $("#header-arrow").on("click", function(e){
                        e.preventDefault();
                        var scrollToSelector    = $(window).width() < 768 ? $(this).attr("data-href-mobile") : $(this).attr("href"),
                            distanceFromTop     = 15,   //in px
                            animate             = true,
                            duration            = 800;  //in ms
                        $(scrollToSelector).scrollIntoView(distanceFromTop, animate, duration);
                    });
                </script>
            </div>
        </div>
    </div>



    <div class="container-fluid text-center OurDanceClasses" style="background: url({{ url('/resources/assets/images/banner_2.jpg') }})">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-xs-12">
                <h2>dance Styles</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 noppading">
                <div class="carousel slide multi-item-carousel" id="theCarousel">
                    <div class="carousel-inner">
                        <? 
                        $x      = 0;
                        $active = '';
                        foreach ($danceClasses_c as $danceClasses_r) { 
                            $x  = $x + 1;
                            if($x == 1) {$active = ' active';} else {
                                $active = '';
                            }
                            $poza = $danceClasses_r->image1;
                        ?>      
                            <div class="item<?=$active?>">
                                <div class="col-xs-12 col-md-4 text-center noppading" onclick="location.href='<?=route('dance-class-name', ['name' => strtolower(str_replace(' ', '-', $danceClasses_r->name)) ])?>'; return false;">
                                    <div class="poza_block" style="background: url(<?=$poza?>)">
                                        <h4><?=$danceClasses_r->name?></h4>
                                    </div>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>

            <div class="col-md-2 controlersBlock">
                <div class="row">
                    <a class="left " href="#theCarousel" data-slide="prev">
                        <div class="col-xs-6 controlBlock text-center">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </div>
                    </a>
                    <a class="right " href="#theCarousel" data-slide="next">
                        <div class="col-xs-6 controlBlock right_controlBlock text-center">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<script>
        // Instantiate the Bootstrap carousel

// for every slide in carousel, copy the next slide's item in the slide.
$( document ).ready(function() {
    $('.multi-item-carousel').carousel({
        interval: false
    });

    if ($(window).width() >= 768) {
        $('.multi-item-carousel .item').each(function(){
            var next = $(this).next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));
          
            if (next.next().length>0) {
                next.next().children(':first-child').clone().appendTo($(this));
            } else {
                $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
            }
        });
    }
});
</script>


<div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center presentation">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="upper grey">FRANCHISE - AFFILIATE WITH US</h2>
                    </div>
                    <div class="col-md-2 text-center IMGfrancise">
                        <img src="{{ url('/resources/assets/images/banu.jpg') }}" alt="Andreas Riedel" class="img-responsive img-circle text-center">
                        MIHAI BANU
                    </div>
                    <div class="col-md-10">
                        <p class="grey_75">
                            <br/>
                            Latin Love has appeared because we love latin dance and we love to make people happy. When we travelled in Africa, Asia and Europe we saw that all people love dancing so for this reason we decided to share our experience by creating Latin Love Franchise. <br/>
                            Here are a couple of reasons why Latin Love Franchise is world class and the best choice for you:
                        </p>
                    </div>
                    <div class="col-xs-12 buttons_block">
                        <br/>
                        <a href="{{route('franchise')}}" class="btn-default-new-layout btn-new-layout-red add_margin_left" >Affilate with us</a>
                        <span class="margin_left_30"></span>
                        <a class="btn-default-new-layout btn-new-layout-white" href="{{route('contact')}}">Contact us</a>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid text-center OurEvents" style="background: url({{ url('/resources/assets/images/banner_5.jpg') }})">
        <h2>Our events</h2>
        <h5>Frequently we organize events, contests and workshops. Keep in touch with us !
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 EventsBlock">
                <div class="row">
                    <div class="col-xs-12 col-md-4 futureEvents">
                        <div class="futureEventsButton">
                            <?=date("d M Y")?>
                        </div>
                        <div class="futureEvents3InARow text-right">
                            <? 
                            if (sizeof($ev_this_month_c) >= 1 ) {
                            foreach ($ev_this_month_c as $ev_this_month_r) { ?><br/>
                                <?=date('d M Y', strtotime($ev_this_month_r->date) )?> - <?=$ev_this_month_r->title?><br/>
                            <? } 
                            } else { ?>
                                No, future events, stay tune!
                            <? } ?>
                        </div>
                    </div>
                    <? foreach ($events_c as $events_r) { ?>
                        <div class="col-xs-10 col-xs-offset-1 col-md-offset-0 col-md-4 ZaEvent">
                            <div class="row noppading EventDayBlock">
                                <div class="col-xs-12 EventDay text-left">
                                    <? 
                                    $day        = date('d', strtotime($events_r->date));
                                    $month_year = date('M y', strtotime($events_r->date));
                                    ?>
                                    <?=$day?>/<span><?=$month_year?></span>
                                </div>
                                <div class="col-xs-12 eventImg" style="background: url({{ url('/') }}/{{$events_r->image}})"></div>
                                <div class="col-xs-12 EventTitle">
                                    <a href="<?=route('events-name', ['name' => strtolower(str_replace(' ', '-', $events_r->title)) ])?>"><?=$events_r->title?></a>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                    

                    <div class="col-md-12 allEvents text-right">
                        <a href="<?=route('events')?>" title="see all events">see all events</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6 col-md-offset-3 titleNewsletter text-center">
                        SUBSCRIBE TO OUR NEWSLETTER FOR MORE EVENTS
                    </div>
                    <div id="custom-search-input">
                        <div class="input-group col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4 NewsletterLocation">
                            <form method="POST" action="<?=route('store-newsletter')?>">
                                <?=csrf_field()?>
                                <input type="text" name="email" class="search-query form-control" placeholder="Email address" />
                                <span class="input-group-btn">
                                    <button class="btn btn-danger" type="submit">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container plansAndPriceing" id="scrollTo">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="upper grey">PLANS AND PRICES</h2>
                <br/>
            </div>
        </div>
        <div class="row">
            <?
            foreach ($plan_front_c as $plan_front_r) { 

                if($plan_front_r->position == '1') {
                    $classPosition = 'panel-primary';
                    $plus          = '';
                }
                if($plan_front_r->position == '2') {
                    $classPosition = 'panel-success';
                    $plus          = '<div class="cnrflash">
                        <div class="cnrflash-inner">
                            <span class="cnrflash-label">MOST
                                <br>
                                POPULR</span>
                        </div>
                    </div>';
                }
                if($plan_front_r->position == '3') {
                    $classPosition = 'panel-info';
                    $plus          = '';
                }
            ?>
                <div class="col-xs-12 col-md-4 text-center">
                    <div class="panel <?=$classPosition?>">
                        <?=$plus?>
                        <div class="panel-heading">
                            <h3 class="panel-title"><?=$plan_front_r->name?></h3>
                        </div>
                        <div class="panel-body">
                            <div class="the-price">
                                <h1>£<?=$plan_front_r->price?><span class="subscript">/mo</span></h1>
                                <small><?=$plan_front_r->price?> points bonus</small>
                            </div>
                            <table class="table">
                                <?
                                $details_ex = explode('|', $plan_front_r->details);
                                $count_det  = count($details_ex);
                                foreach ($details_ex as $details_ex_r) { ?>
                                    <tr><td><?=$details_ex_r?></td></tr>
                                <? } 
                                $dif = '';
                                if($count_det < $max_nr) {
                                    $dif = $max_nr - $count_det;
                                }
                                for($y=0;$y<$dif;$y++){ ?>
                                    <tr><td>&nbsp;</td></tr>
                                <? } ?>
                            </table>
                        </div>
                        <div class="panel-footer">
                            <a href="{{ url('/') }}/register" class="btn-default-new-layout btn-new-layout-white">Sign Up</a>
                        </div>
                    </div>
                </div>
            <? } ?>
        </div>
        <? if(count($plan_nofront_c) >= 1) { ?> 
            <div class="row">
                <div class="col-xs-12 text-center"> 
                    <a class="cursor" type="button" data-toggle="collapse" data-target="#collapsePlans" aria-expanded="false" aria-controls="collapsePlans">VIEW MORE PLANS</a>

                    <div class="collapse" id="collapsePlans">
                        <br/><br/>
                        <div class="col-xs-12">
                            <? foreach ($plan_nofront_c as $plan_nofront_r) { ?>
                                <div class="col-xs-12 col-md-3 text-center">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><?=$plan_nofront_r->name?></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="the-price">
                                                <h1>£<?=$plan_nofront_r->price?><span class="subscript">/mo</span></h1>
                                                <small><?=$plan_nofront_r->price?> points bonus</small>
                                            </div>
                                            <table class="table">
                                                <?
                                                $details_ex = explode('|', $plan_nofront_r->details);
                                                $count_det  = count($details_ex);
                                                foreach ($details_ex as $details_ex_r) { ?>
                                                    <tr><td><?=$details_ex_r?></td></tr>
                                                <? } 
                                                $dif2 = '';
                                                if($count_det < $max_nr2) {
                                                    $dif2 = $max_nr2 - $count_det;
                                                }
                                                for($j=0;$j<$dif2;$j++){ ?>
                                                    <tr><td>&nbsp;</td></tr>
                                                <? } ?>
                                            </table>
                                        </div>
                                        <div class="panel-footer">
                                            <a href="{{ url('/') }}/register" class="btn-default-new-layout btn-new-layout-white">Sign Up</a>
                                        </div>
                                    </div>
                                </div>

                            <? } ?> 
                        </div>
                    </div>
                </div>

                
            </div>
        <? } ?>


    </div>

    <div class="container dontShowOnSoneScreens">
        <div class="row">
            <div class="col-xs-12 titleNewsletter text-center">
                Students reviews
                <br/>
                <br/>
            </div>
        </div>
        <div class="row">
            <? foreach ($review_c as $review_r) {
                echo '<div class="col-xs-12 col-md-4">';
                echo $review_r->post;
                echo '</div>';
            } ?>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <br/>
                <br/>
                <br/>
                <a href="{{route('reviews')}}">view all reviews from students</a>
            </div>
        </div>
    </div>

    <div class="container-fluid instagram" id="Insta">
        <div class="row">
            <div class="col-xs-12 titleNewsletter text-center">
                Instagram & social networks
                <br/>
                <br/>
            </div>
        </div>
        <div class="row">
            <? for($x=1;$x<=12;$x++) { ?>
            <div class="col-xs-3 col-sm-3 col-md-2 col-lg-1 insta_img insta_<?=$x?>" data-toggle="modal" data-target="#insta_<?=$x?>"></div>
            <div class="modal fade" id="insta_<?=$x?>" tabindex="-1" role="dialog" aria-labelledby="insta_<?=$x?>Label">
                <div class="modal-dialog modal-lg insta_modal" role="document">
                    <div class="modal-content">
                        <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button></div>
                        <div class="modal-body">
                            <div class="col-md-7 insta_col insta_<?=$x?> insta_pic"></div>
                            <div class="col-md-5 insta_col2 insta_panel">
                                <div class="row">
                                    <a href="" target="_blank">
                                        <div class="logo_and_border_insta">
                                        <div class="insta_logo"></div>
                                        <div class="insta_name">latinlove</div>
                                    </div>
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="content_insta">
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="footer_insta_like">
                                        <a href="" target="_blank">
                                            <div class="like_in"></div>
                                        </a>
                                        <a href="" target="_blank">
                                        <div class="comment_in"></div>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="footer_insta">
                                        <a href="" target="_blank">iamwaddu</a>,
                                        <a href="" target="_blank">socialmediachallenger</a>,
                                        <a href="" target="_blank">female.fashion.luxury.travel</a>,
                                        <a href="" target="_blank">mario</a>,
                                        <a href="" target="_blank">serg.zheleznyakov</a>,
                                        <a href="" target="_blank">hot.class.empire.real</a>,
                                        <a href="" target="_blank">ifbbpro_bquick</a>,
                                        <span>and</span>
                                        <a href="" target="_blank">biancamirona</a>, 
                                        <span>like this</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="modal-footer text-center"><button type="button" class="btn-default-new-layout btn-new-layout-red" data-dismiss="modal">Close</button></div>
                    </div>
                </div>
            </div>
            <? } ?>
        </div>
    </div>
    <video height="400" muted control="false" autoplay class="video" loop id="presentationVideo">
        <source src="{{ url('/resources/assets/video/video_bg3.mp4') }}" type="video/mp4" >
    </video>
    <script>
        window.onload = function () {
            var element = document.getElementById('presentationVideo');
            element.muted = "muted";
        }
    </script>
    <div class="container-fluid Brushed_bg" style="background: url('{{ url('/resources/assets/images/mine_bg_brushed.png') }}')">
        <div class="row">
            <div class="col-md-5 quateBlockWhite"><span class="quote">Quote</span> <div class="right_line"></div> <h2 class="h2_banner"><p>Dance is the hidden<br> language of the soul</p></h2> <div class="left_line"></div> <span class="author">Martha Graham</span></div>
        </div>
    </div>
@endsection