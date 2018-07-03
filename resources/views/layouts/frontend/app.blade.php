<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
    <title>Latin Love Dance School</title>

    <!-- Styles -->
    <link href="{{ url('/') }}/resources/assets/css/app.css" rel="stylesheet">
    <link href="{{ url('/') }}/resources/assets/css/style.css?ver=1.48" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i|Old+Standard+TT|Cinzel|Open+Sans+Condensed:300,300i,700|Rock+Salt&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/fullcalendar-nou/fullcalendar.css" />
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

    <? if(Route::currentRouteName() == 'events-name') { ?> 
        <meta property="og:url" content="<?=route('events-name', ['name' => strtolower(str_replace(' ', '-', $event_r->title)) ])?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?=$event_r->title?> <?=$event_r->hour;?> - <?=substr($event_r->date, 0,10)?>" />
        <meta property="og:description" content="<?=substr(strip_tags($event_r->description), 0,150)?>" />
        <meta property="og:image" content="<?=url('/').'/'.$event_r->image;?>" />
        <meta property="og:image:width" content="263" />
        <meta property="og:image:height" content="340" />
        
    <? } ?>
    <? if(Route::currentRouteName() == 'dance-class-name') { ?> 
        <meta property="og:url" content="<?=route('dance-class-name', ['name' => strtolower(str_replace(' ', '-', $danceClass_r->name)) ])?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?=$danceClass_r->name?>" />
        <meta property="og:description" content="<?=substr(strip_tags($danceClass_r->description), 0,150)?>" />
        <meta property="og:image" content="<?=url('/').'/'.$danceClass_r->image1;?>" />
        <meta property="og:image:width" content="263" />
        <meta property="og:image:height" content="340" />
    <? } ?>
    <? if(Route::currentRouteName() == 'blog-article') { ?> 
        <meta property="og:url" content="<?=route('dance-class-name', ['name' => strtolower(str_replace(' ', '-', $bloc_article_r->title)) ])?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?=$bloc_article_r->title?>" />
        <meta property="og:description" content="<?=substr(strip_tags($bloc_article_r->description), 0,150)?>" />
        <meta property="og:image" content="<?=url('/').'/'.$bloc_article_r->image1;?>" />
        <meta property="og:image:width" content="263" />
        <meta property="og:image:height" content="340" />
    <? } ?>
    <? if(Route::currentRouteName() == 'teachers-name') { ?> 
        <meta property="og:url" content="<?=route('teachers-name', ['name' => strtolower(str_replace(' ', '-', $teacher_r->name())) ])?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?=$teacher_r->name()?>" />
        <meta property="og:description" content="<?=substr(strip_tags($teacher_r->description()), 0,150)?>" />
        <meta property="og:image" content="<?=url('/').'/'.$teacher_r->ProfileImg();?>" />
        <meta property="og:image:width" content="263" />
        <meta property="og:image:height" content="340" />
    <? } ?>
    <? if(Route::currentRouteName() == 'services-name') { ?> 
        <meta property="og:url" content="<?=route('services-name', ['name' => strtolower(str_replace(' ', '-', $service_r->title)) ])?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?=$service_r->title?>" />
        <meta property="og:description" content="<?=substr(strip_tags($service_r->description), 0,150)?>" />
        <meta property="og:image" content="<?=url('/').'/'.$service_r->image;?>" />
        <meta property="og:image:width" content="263" />
        <meta property="og:image:height" content="340" />
    <? } ?>
    <link rel="icon" href="{{url('/')}}/favicon.ico" type="image/x-icon">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <style>
        .impersonate-bar {
            position: fixed;
            bottom: 15px;
            left: 15px;
            width: 20%;
        }
    </style>
</head>
<body>
    <div id="app">
        <?
        if(Route::currentRouteName() == 'home') {
            $navbar = '';
        } else {
            $navbar = 'StaticNavBar';
        }
        ?>
        <nav class="navbar navbar-default navbar-fixed-top add_to_navbar <?=$navbar?>" id="meniu">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ url('/') }}/resources/assets/images/logo_bun.png" class="logo">
                        <span>{{ config('sitename', 'LatinLove') }}</span>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav navbar-center">
                        &nbsp;
                        <li><a href="{{ route('home') }}">HOME</a></li>
                        <li><a href="{{ route('dance-classes') }}">DANCE STYLES</a></li>
                        <li><a href="{{ route('timetable') }}">TIMETABLE</a></li>
                        <li><a href="{{ route('events') }}">EVENTS</a></li>
                        <li><a href="{{ route('services') }}">SERVICES</a></li>
                        <li><a href="{{ route('blog') }}">BLOG</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">MORE <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('about-us') }}">ABOUT US</a></li>
                                <li><a href="{{ route('franchise') }}">FRANCHISE</a></li>
                                <li><a href="{{ route('teachers') }}">TEACHERS</a></li>
                                <li><a href="{{ route('reviews') }}">REVIEWS</a></li>
                                <li><a href="{{ route('contact') }}">CONTACT</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @if ( Auth::check() )
                            <li><a href="{{ route('account') }}" class="login uppercase">ACCOUNT</a></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">LOGOUT</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @else 
                        <!--
                        <li><a class="login uppercase" id="LoginForm" onclick="loadLoginForm('login');" data-toggle="modal" data-form="login" data-target="#myLogin">LOGIN</a></li>
                        <li><a class="register uppercase" id="RegisterForm" onclick="loadLoginForm('register');" data-toggle="modal" data-form="register" data-target="#myLogin">REGISTER</a></li>
                        -->
                        <li><a href="{{ url('/') }}/login" class="login uppercase">LOGIN</a></li>
                        <li><a href="{{ url('/') }}/register" class="register uppercase">REGISTER</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>


        <div class="modal LoginModal fade" id="myLogin" tabindex="-1" role="dialog" aria-labelledby="myLoginLabel">
            <div class="modal-dialog bachataBg" role="document" id="contentToLoad">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myLoginLabel">LOGIN</h4>
                    </div>
                    <div class="modal-body" id="log_content">
                        <?
                        //$alert_message           = $_SESSION['alert_modal'];
                        //$_SESSION['alert_modal'] = "";unset($_SESSION['alert_modal']);
                        //$old_post                = unserialize($_SESSION['old_post']);
                        //$_SESSION['old_post']    = "";unset($_SESSION['old_post']);
                        ?>
                        <form method="post" action="/" id="loginForm">
                            <input type="hidden" name="from_what_form" value="login">
                            <input type="hidden" name="version" value="newLayout">
                            <div class="form-group">
                                <input class="form-control" type="text" name="login_email" value="" placeholder="e-mail address" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password" name="login_password" value="" placeholder="password"  />
                            </div>
                            <div class="row">
                                <div class="col-xs-12 terms_and_cond">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <input type="checkbox" class="styled-checkbox" name="remember_me" value="remember_me" />
                                            <label for="styled-checkbox-2">remember me</label>
                                        </div>
                                    </div>
                                </div>
                                <?//if (!is_null($alert_message)):?>
                                    <div class="col-md-12 alert_modal">
                                        <?// if(count($alert_message) > 1) {
                                            //foreach ($alert_message as $alert_message_r) { echo $alert_message_r.'<br/>'; }
                                        //} if(count($alert_message) == 1) {
                                        //    echo $alert_message;
                                        //} ?>
                                    </div>
                                <?// endif; ?>
                                <div class="col-xs-12">
                                    <div class="form-group text-center margin_btn_10">
                                        <br/>
                                        <button type="submit" class="btn btn-default-new-layout btn-small-white-register-login">
                                            LOGIN       
                                        </button>
                                    </div>
                                    <div class="row oder_fb">            
                                        <div class="col-xs-5 line_befor_oder_fb"></div>
                                        <div class="col-xs-2 text-center">
                                            OR
                                        </div>
                                        <div class="col-xs-5 line_after_oder_fb"></div>
                                    </div>
                                                   
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-body" id="reset_content">
                        <div class="form-group text-center terms_and_cond">
                            
                            <div class="collapse" id="collapsepassword">
                                <div class="well">      
                                    <form method="POST" action="/">
                                        <input type="hidden" name="from_what_form" value="forgot">
                                        <input type="hidden" name="version" value="newLayout">
                                        <p>forgot password?</p>
                                        <div class="form-group">
                                            <input type="email" name="forgot_password_email" class="form-control" id="exampleInputEmail1" placeholder="e-mail address">
                                        </div>
                                        <button type="submit" class="btn btn-default-new-layout btn-small-white">SEND</button> 
                                    </form>
                                </div>
                            </div>
                            <br/>
                            <a type="button" data-toggle="collapse" data-target="#collapsepassword" aria-expanded="false" aria-controls="collapsepassword" id="switch_txt_login">forgot password?</a>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?//=get_translation("switch_to_register_text"); ?> <a class="RegisterForm" id="RegisterForm_load" onclick="loadLoginForm(this.className); return false"><?//=get_translation("switch_to_register"); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(document).ready(function(){
            // used for direct link
            $('#myLogin').on('shown.bs.modal', function (event) {
                var what = $(event.relatedTarget).attr('data-form'); 
                
            });

            <?  if(Route::currentRouteName() == 'home') { ?>
            var scroll_pos = 0;
            var width = $( window ).width();
            $(document).scroll(function() { 
                scroll_pos = $(this).scrollTop();
                if(scroll_pos > 495 && width > 797) {
                    $(".navbar-default").css('background-color', '#000000');
                    $(".navbar-brand span").css('top', '-90px');
                } else {
                    $(".navbar-default").css('background-color', 'rgba(0,0,0,0.35)');
                    $(".navbar-brand span").css('top', '-68px');  
                }
            });
            <? } ?>
        });
        </script>

        @yield('content')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('/resources/assets/js/app.js') }}"></script>

    <footer>
        <nav class="to_hide_on_mobile">
            <div class="container">
                <div class="row nopadding">
                    <?=breadcrumbs()?>
                </div>
            </div>
        </nav>
        <div class="container footer_extra2">
            <div class="col-xs-12 col-md-3">
                <a class="link_footer colap_footer_menu" role="button" data-toggle="collapse" href="#footer_1" aria-expanded="false" aria-controls="footer_1">
                    <div class="div_colaps_footer">
                        <a class="navbar-brand2" href="{{ url('/') }}">
                            <img src="{{ url('/') }}/resources/assets/images/logo_bun.png" class="logoFooter">
                            <span>{{ config('sitename', 'LatinLove') }}</span>
                        </a>
                        <span class="colap_footer_span glyphicon glyphicon-plus"></span>
                    </div>
                </a>
                <div class="collapse in" id="footer_1">
                    <div>
                        <div class="input-group NewsletterLocationFooter">
                            <form method="POST" action="<?=route('store-newsletter')?>">
                                <?=csrf_field()?>
                                <input type="text" name="email" placeholder="Subscribe to newsletter" class="search-query form-control"> 
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-2">
                <a class="link_footer colap_footer_menu" role="button" data-toggle="collapse" href="#footer_2" aria-expanded="false" aria-controls="footer_2">
                    <div class="div_colaps_footer">
                        LatinLoveDanceSchool
                        <span class="colap_footer_span glyphicon glyphicon-plus"></span>
                    </div>
                </a>
                <div class="collapse in" id="footer_2">
                    <div>
                        <ul>
                            <li><a href="{{ route('about-us') }}" title="About us">About us</a></li>
                            <li><a href="{{ route('events') }}" title="Events">Events</a></li>
                            <li><a href="{{ route('franchise') }}" title="Franchise">Franchise</a></li>
                            <li><a href="{{ route('dance-classes') }}" title="Dance styles">Dance styles</a></li>
                            <li><a href="{{ route('services') }}" title="Services">Services</a></li>
                            <li><a href="{{ route('contact') }}" title="Contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-2">
                <a class="link_footer colap_footer_menu" role="button" data-toggle="collapse" href="#footer_3" aria-expanded="false" aria-controls="footer_3">
                    <div class="div_colaps_footer">
                        DANCE STYLES
                        <span class="colap_footer_span glyphicon glyphicon-plus"></span>
                    </div>
                </a>
                <div class="collapse in" id="footer_3">
                    <div>
                        <ul>
                        <? $danceClassxx_c = App\DanceClass::where('active','=','yes')->orderBy('order_nr', 'asc')->get(); ?>
                        <? foreach ($danceClassxx_c as $danceClasses_r) { ?>
                            <li><a href="<?=route('dance-class-name', ['name' => strtolower(str_replace(' ', '-', $danceClasses_r->name)) ])?>" title="<?=$danceClasses_r->name?>"><?=$danceClasses_r->name?></a></li>
                        <? } ?>         
                    </ul>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-2">
                <a class="link_footer colap_footer_menu" role="button" data-toggle="collapse" href="#footer_4" aria-expanded="false" aria-controls="footer_4">
                    <div class="div_colaps_footer_last">
                        FRANCHISE
                        <span class="colap_footer_span glyphicon glyphicon-plus"></span>
                    </div>
                </a>
                <div class="collapse in" id="footer_4">
                    <div>
                        <ul>
                            <li><a href="{{ route('franchise') }}" title="Franchise">Affiliate with us</a></li>
                            <li><a href="{{ route('franchise') }}" title="Why we should be partners">Why we should be partners</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <a class="link_footer colap_footer_menu" role="button" data-toggle="collapse" href="#footer_5" aria-expanded="false" aria-controls="footer_5">
                    <div class="div_colaps_footer_last">
                        SOCIAL MEDIA
                        <span class="colap_footer_span glyphicon glyphicon-plus"></span>
                    </div>
                </a>
                <div class="collapse in" id="footer_5">
                    <div class="social-links">
                        <ul>
                            <li>
                                <a class="fb" data-nav="nav_Facebook" href="https://www.facebook.com/LatinLoveLondon/" id="footer-facebook-icon" target="_blank"></a>
                            </li>
                            <li>
                                <a class="tw" data-nav="nav_Twitter" href="https://twitter.com/LatinLoveDance1" target="_blank"></a>
                            </li>
                            <li>
                                <a class="gp" data-nav="nav_GooglePlus" href="https://www.youtube.com/channel/UC2G96AoL01qDustAb0lVdXw" target="_blank"></a>
                            </li>
                            <li>
                                <a class="ig" data-nav="nav_Instagram" href="https://www.instagram.com/latin.love.london/" id="footer-instagram-icon" target="_blank"></a>
                            </li>
                            <li>
                                <a class="tb" data-nav="nav_Tumblr" href="https://latinlove.tumblr.com/" id="footer-tumblr-icon" target="_blank"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>            
        </div>

        <div class="container footer_final">
            <hr>
            © latinlovedanceschool.com ATENTION! latinlove is a trademark. 
        </div>
    </footer>
    
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=162397747773920&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <script type="text/javascript" async src="//platform.twitter.com/widgets.js"></script>
    <script id="tumblr-js" async src="https://assets.tumblr.com/share-button.js"></script>
    <script src="{{ url('/') }}/vendors/fullcalendar-nou/lib/moment.min.js"></script>
    <script src="{{ url('/') }}/vendors/fullcalendar-nou/fullcalendar.js"></script>
</body>
</html>
