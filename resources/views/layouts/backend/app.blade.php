<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ url('/') }}/favicon.ico" type="image/ico" />
    <title>LatinLove account</title>
    <link href="{{ url('/') }}/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="{{ url('/') }}/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <link href="{{ url('/') }}/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="{{ url('/') }}/resources/assets/css/custom.css?ver=1.37" rel="stylesheet">
    <link href="{{ url('/') }}/resources/assets/css/data_table.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/') }}/vendors/fullcalendar-nou/fullcalendar.css" />
    <script src="{{ url('/') }}/vendors/jquery/dist/jquery.min.js"></script>
    <script src="{{ url('/') }}/resources/assets/js/jquery.dataTables.min.js"></script>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.6/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.6/css/froala_style.min.css' rel='stylesheet' type='text/css' />
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.7.6/js/froala_editor.min.js'></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://www.paypalobjects.com/api/checkout.js"></script>
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{{ url('/') }}" class="site_title">
                            <img src="{{ url('/') }}/resources/assets/images/logo_bun.png" alt="..." class="img-circle">
                            <span>LatinLove</span>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="<?=$user_logat_r->avatar()?>" alt="{{$user_logat_r->name}}" class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{{$user_logat_r->name}}</h2>
                        </div>
                    </div>
                    <br />
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-home"></i> Account <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('account') }}">Dashbord</a></li>
                                        <li><a href="{{ route('define-account') }}">Edit Profile</a></li>
                                        <li><a href="{{ route('reset-password-account') }}">Reset password</a></li>
                                    </ul>
                                </li>
                                <? if($user_logat_r->type == 'superadmin') { ?> 
                                <li><a><i class="fa fa-adn"></i> SuperAdmin <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('super-admin-first-page') }}">Main page</a></li>
                                        <li><a href="{{ route('super-admin-franchise') }}">Franchises</a></li>
                                        <li><a href="{{ route('super-admin-franchise') }}">Add Franchise</a></li>
                                    </ul>
                                </li>  
                                <? } ?>  
                                <? if($user_logat_r->type == 'admin' || $user_logat_r->type == 'superadmin') { ?> 
                                <li><a><i class="fa fa-fort-awesome"></i> My school <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('my-school') }}">My school</a></li>
                                        <li><a href="{{ route('admin-levels') }}">Group Levels</a></li>
                                        <li><a href="{{ route('my-school-dance-classes') }}">Dance styles <span class="badge bg-red fright"><?=$user_logat_r->DanceClassesCount()?></span></a></li>
                                        <li><a href="{{ route('my-school-dance-courses') }}">Dance groups <span class="badge bg-red fright"><?=$user_logat_r->DanceCoursesCount()?></span></a></li>
                                        <li><a href="{{ route('my-school-teachers') }}">Teachers <span class="badge bg-red fright"><?=$user_logat_r->School->TeacherCount()?></span></a></li>
                                        <li><a href="{{ route('my-school-students') }}">Students <span class="badge bg-red fright"><?=$user_logat_r->School->UserCount()?></span></a></li>
                                        <li><a href="{{ route('my-school-removed-students') }}">Removed Students <span class="badge bg-red fright"><?=$user_logat_r->School->RemovedUserCount()?></span></a></li>
                                        <li><a href="{{ route('my-school-events') }}">Events <span class="badge bg-red fright"><?=$user_logat_r->School->EventCount()?></span></a></li>
                                        <li><a href="{{ route('my-school-payments') }}">Payments</a></li>
                                        <li><a href="{{ route('admin-newsletter') }}">Newsletter</a></li>
                                        <!--
                                        <li><a href="{{ route('my-school-users') }}">Users <span class="badge bg-red fright"><?//=$user_logat_r->School->UserCount()?></span></a></li>
                                        -->
                                    </ul>
                                </li>  
                                <li><a><i class="fa fa-cog"></i> My school settings<span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('admin-plans') }}">Plan and prices</a></li>
                                        <li><a href="{{ route('admin-about-us') }}">Edit about us</a></li>
                                        <li><a href="{{ route('admin-services') }}">Other services</a></li>
                                        <li><a href="{{ route('admin-quotes') }}">Home quotes</a></li>
                                        <li><a href="{{ route('admin-blog') }}">Blog</a></li>
                                        <li><a href="{{ route('admin-reviews') }}">Reviews</a></li>
                                    </ul>
                                </li>  
                                <? } ?>
                                <?if($user_logat_r->type == 'client') { ?> 
                                <li><a><i class="fa fa-edit"></i> Join dance courses <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('account-join-courses') }}">Join courses</a></li>
                                    </ul>
                                </li>

                                <li><a><i class="fa fa-calendar"></i> Events <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('account-join-events') }}">Join events</a></li>
                                    </ul>
                                </li>  

                                <li><a><i class="fa fa-money"></i> Earn points <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="{{ route('earn-points') }}">My points</a></li>
                                        <li><a href="{{ route('how-it-works') }}">How it works</a></li>
                                        <li><a href="{{ route('earn-by-referral') }}">Earn by referral</a></li>
                                    </ul>
                                </li>  


                                <? } ?>               
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">LOGOUT</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="{{$user_logat_r->avatar()}}" alt="{{$user_logat_r->name}}" class="img-circle profile_img2"> {{$user_logat_r->name}}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li>
                                        <a href="{{ route('define-account') }}">
                                            <span class="badge bg-red pull-right"><?=$user_logat_r->getProfileLevel()?></span>
                                            <span>Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('reset-password-account') }}">
                                            Reset password
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">LOGOUT <i class="fa fa-sign-out pull-right"></i></a>
                                        <form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <?if($user_logat_r->type == 'client') { ?> 
                            <li class="">
                                <a href="javascript:;" class="user-profile" data-toggle="dropdown" aria-expanded="false">
                                    <span class="badge bg-green"><?=$user_logat_r->puncte?> points</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="user-profile" data-toggle="dropdown" aria-expanded="false">
                                    <span class="badge bg-red">
                                        <? if($user_logat_r->Subscription()->exists() ) { ?>
                                            subscribed until <?=$user_logat_r->SubscriptionLast->until_when?>
                                        <? } else { ?> 
                                            unsubscribed
                                        <? } ?>
                                    </span>
                                </a>
                                <!--
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green">6</span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                    <li>
                                        <a>
                                            <span class="image"><img src="" alt="Profile Image" /></span>
                                            <span>
                                                <span>John Smith</span>
                                                <span class="time">3 mins ago</span>
                                            </span>
                                            <span class="message">
                                                Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="text-center">
                                            <a>
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                                -->
                            </li>
                            <? } ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <div class="right_col" role="main">
                <!--
                <div class="row tile_count">
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
                  <div class="count">2500</div>
                  <span class="count_bottom"><i class="green">4% </i> From last Week</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
                  <div class="count">123.50</div>
                  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
                  <div class="count green">2,500</div>
                  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
                  <div class="count">4,567</div>
                  <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
                  <div class="count">2,315</div>
                  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                  <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
                  <div class="count">7,325</div>
                  <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                </div>
                </div>
                -->
                <? if($user_logat_r->getProfileLevel() != '100%') { ?> 
                <div class="row">
                    <div class="col-xs-12">
                        <div class="x_panel warning">
                            warning you profile is currently completed <?=$user_logat_r->getProfileLevel()?>. Please complete your profile 100%.
                            <br/>
                            <br/>
                            <div class="col-xs-12 text-center">
                                <a href="{{ route('define-account') }}" class="btn btn-primary">Complete your profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                <? } ?>

                @yield('content')
                <br />
            </div>

            <footer>
                <div class="pull-right">
                    LatinLove
                </div>
                <div class="clearfix"></div>
            </footer>
    
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(document).on("click",".openSaysMe",function() {
                var id     = $(this).data("id");
                var modal  = $(this).data("modal");
                var dowhat = $(this).data("dowhat");
                openModal(id,modal,dowhat);
            });
            function openModal(id,modal,dowhat) {
                id     = typeof id     !== 'undefined' ? id  : null;
                modal  = typeof modal  !== 'undefined' ? modal  : null;
                dowhat = typeof dowhat !== 'undefined' ? dowhat  : null;
                $('#ModalGeneral').modal('show');
                $('#showModalContent').html('<div class="modal-header text-center"></div><div class="modal-body lower-on-sm text-center img_centered"><img id="imageLoading" class="img-responsive" src="{{url('/')}}/resources/assets/images/image_loading.gif"></div><div class="modal-footer text-center"></div>');
                $.ajax({
                    <? if (App::environment('local')) { ?> 
                    url:"<?=url('/')?>/latinlove/modale/"+modal+"/"+dowhat+"/"+id+"/",
                    <? } else { ?> 
                    url:"<?=url('/')?>/modale/"+modal+"/"+dowhat+"/"+id+"/",
                    <? } ?>
                    method:"GET",
                    success:function(data) {
                        $('#ModalGeneral').modal('show');
                        $('#showModalContent').html(data);  
                    }
                });
            };
        });
    </script>
    
    <script src="{{ url('/') }}/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{ url('/') }}/vendors/fastclick/lib/fastclick.js"></script>
    <script src="{{ url('/') }}/vendors/nprogress/nprogress.js"></script>
    <script src="{{ url('/') }}/vendors/Chart.js/dist/Chart.min.js"></script>
    <script src="{{ url('/') }}/vendors/gauge.js/dist/gauge.min.js"></script>
    <script src="{{ url('/') }}/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <script src="{{ url('/') }}/vendors/iCheck/icheck.min.js"></script>
    <script src="{{ url('/') }}/vendors/skycons/skycons.js"></script>
    <script src="{{ url('/') }}/vendors/Flot/jquery.flot.js"></script>
    <script src="{{ url('/') }}/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="{{ url('/') }}/vendors/Flot/jquery.flot.time.js"></script>
    <script src="{{ url('/') }}/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="{{ url('/') }}/vendors/Flot/jquery.flot.resize.js"></script>
    <script src="{{ url('/') }}/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="{{ url('/') }}/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="{{ url('/') }}/vendors/flot.curvedlines/curvedLines.js"></script>
    <script src="{{ url('/') }}/vendors/DateJS/build/date.js"></script>
    <script src="{{ url('/') }}/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="{{ url('/') }}//vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <script src="{{ url('/') }}/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="{{ url('/') }}/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <script src="{{ url('/') }}/vendors/moment/min/moment.min.js"></script>
    <script src="{{ url('/') }}/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="{{ url('/') }}/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="{{ url('/') }}/resources/assets/js/custom.js?ver=1.05"></script>
    <script src="{{ url('/') }}/vendors/fullcalendar-nou/lib/moment.min.js"></script>
    <script src="{{ url('/') }}/vendors/fullcalendar-nou/fullcalendar.js"></script>
    <script src="{{ url('/') }}/vendors/fullcalendar-nou/jquery.qtip-1.0.min.js"></script>
    
    <script type="text/javascript">
        $('#myDatepicker1').datetimepicker({
            format: 'YYYY-MM-DD' });
        $('#myDatepicker2').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    </script>
</body>

</html>
