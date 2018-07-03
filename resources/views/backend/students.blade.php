@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>My school students - <?=$user_logat_r->School->UserCount() == '1' ? $user_logat_r->School->UserCount() .' school student' : $user_logat_r->School->UserCount(). ' school students' ?> signed up</h3>
                    <div class="clearfix"></div>
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Add student ( with account)
                            </a>
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample2" aria-expanded="false" aria-controls="collapseExample2">
                                Add student ( without account)
                            </a>
                            <div class="collapse" id="collapseExample">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="{{route('add-school-student')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="payment_type" value="cash">
                                        <input type="hidden" name="school_id" value="<?=Config::get('app.school_id')?>">
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="name" class="control-label">Choose user</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <select name="user_id" id="user_id" class="form-control">
                                                    <option value="">Choose student</option>
                                                    <?
                                                    foreach ($all_users as $all_users_r) {
                                                        $status = '';
                                                        if($all_users_r->level == 'none') {
                                                            $status = 'unsigned';
                                                        }
                                                        if($all_users_r->level == 'teacher') {
                                                            $status = 'teacher';
                                                        }
                                                        if($all_users_r->level == 'beginner' || $all_users_r->level == 'improver' || $all_users_r->level == 'intermediate' || $all_users_r->level == 'advanced') {
                                                            $status = 'client';
                                                        }
                                                        echo '<option value="'.$all_users_r->id.'">'.$all_users_r->name.' - '.$status.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('dance_course_id') ? ' has-error' : '' }}">
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
                                        <div class="col-xs-12 col-md-6 xdisplay_inputx form-group has-feedback">
                                            <label for="starting_from" class="control-label">Payment and subscribtion starting from</label>
                                            <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="date" name="starting_from">
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
                                        <script>
                                            $(document).ready(function() {
                                                $('#user_id, #dance_course_id').select2();
                                            });
                                        </script>
                                        <div class="form-group">
                                           <div class="col-xs-12 text-center">
                                                <br/>
                                                <br/>
                                                <button type="submit" class="btn btn-primary">
                                                    Subscribe user
                                                </button>
                                            </div>
                                        </div>
                                        <br/>
                                    </form>
                                    <script>
                                    $(function() {
                                        $('#description').froalaEditor();
                                    });
                                    </script>
                                </div>
                            </div>
                            <div class="collapse" id="collapseExample2">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="{{route('add-school-student-no-account')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="payment_type" value="cash">
                                        <input type="hidden" name="school_id" value="<?=Config::get('app.school_id')?>">

                                        <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="user_name" class="control-label">Student name</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="text" name="user_name" placeholder="Student name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="user_name" class="control-label">Student email (if he/she doesn't have an email, leave it preset with no@email.com)</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="text" name="user_email" value="no@email.com" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="gender" class="control-label">Gender</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input id="user_phone" type="text" class="form-control" name="user_phone" value="" required autofocus>
                                                <select name="gender" required autofocus class="form-control">
                                                    <option value="">Select gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>

                                                @if ($errors->has('gender'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('gender') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('user_phone') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="user_phone" class="control-label">Phone number</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input id="user_phone" type="text" class="form-control" name="user_phone" value="" required autofocus>

                                                @if ($errors->has('city'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('user_phone') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="country" class="control-label">Choose country</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <select name="country" id="country" class="form-control" required>    
                                                    <? foreach ($country_c as $country_r) { ?>
                                                        <option value="<?=$country_r->country_name?>" <?=$user_logat_r->country == $country_r->country_name ? 'selected':''?>><?=$country_r->country_name?></option>
                                                    <? } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="city" class="control-label">City</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input id="city" type="text" class="form-control" name="city" value="{{ $user_logat_r->city }}" required autofocus>

                                                @if ($errors->has('city'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('city') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="zipcode" class="control-label">Zipcode</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input id="zipcode" type="text" class="form-control" name="zipcode" value="{{ $user_logat_r->zipcode }}" required autofocus>

                                                @if ($errors->has('zipcode'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('zipcode') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('dance_course_id') ? ' has-error' : '' }}">
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
                                        <div class="col-xs-12 col-md-6 xdisplay_inputx form-group has-feedback">
                                            <label for="starting_from" class="control-label">Payment and subscribtion starting from</label>
                                            <input type="text" class="form-control has-feedback-left" id="single_cal3" placeholder="date" name="starting_from">
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
                                        <script>
                                            $(document).ready(function() {
                                                $('#country').select2();
                                            });
                                        </script>
                                        <div class="form-group">
                                           <div class="col-xs-12 text-center">
                                                <br/>
                                                <br/>
                                                <button type="submit" class="btn btn-primary">
                                                    Add account and subscribe user
                                                </button>
                                            </div>
                                        </div>
                                        <br/>
                                    </form>
                                </div>
                            </div>
                            <br/>
                            <br/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="datatable_school_users" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="hidden-xs hidden-sm" valing="top">Nr</th>
                                        <th class="no-sort img_an_mb" valing="top">User name</th>
                                        <th class="">Status</th>
                                        <th class="hidden-xs hidden-sm">Level</th>
                                        <th class="">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>    
                                        <select name="selectCourse" id="selectCourse">
                                            <option value="">Group</option>
                                            <? foreach ($courses as $courses_r) { ?>
                                                <option value="<?=$courses_r->id?>"><?=$courses_r->planName()?></option>
                                            <? } ?>
                                        </select>                                   
                                    </th>
                                    <th>    
                                        <select name="selectStatus" id="selectStatus">
                                            <option value="">Status</option>
                                            <option value="subscribed">Subscribed</option>
                                            <option value="unsubscribed">Unsubscribed</option>
                                        </select>                                   
                                    </th>
                                    <th>
                                        <select name="selectLevel" id="selectLevel">
                                            <option value="">Level</option>
                                            <? foreach ($levels as $level_r) { ?>
                                                <option value="<?=$level_r->name?>"><?=$level_r->name?></option>
                                            <? } ?>
                                        </select>  
                                    </th>
                                    <th>
                                        <div class="hidden-md hidden-lg FilterMobDist">
                                        <select name="selectLevel" id="selectLevel2">
                                            <option value="">Level</option>
                                            <? foreach ($levels as $level_r) { ?>
                                                <option value="<?=$level_r->name?>"><?=$level_r->name?></option>
                                            <? } ?>
                                        </select>

                                        </div>
                                        <select name="selectGender" id="selectGender">
                                            <option value="">Gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select> 
                                        
                                        
                                    </th>
                                </tr>
                            </tfoot>
                            </table>
                            <div id="pageInfo"></div>
                            <script>
                                $(document).ready(function() {
                                    var table = $('#datatable_school_users').DataTable( {
                                        "bLengthChange": true,
                                        "bInfo": true,
                                        "pageLength": 20,
                                        "lengthMenu": [[20, 40, 60, 80, 100 -1], [20, 40, 60, 80, 100, "all"]],
                                        "deferRender": false,
                                        "cache": false,
                                        "serverSide": true,
                                        "language": {
                                            "search": "",
                                            "searchPlaceholder": "SEARCH..."
                                        },            
                                        "ajax": "<?=url('/')?>/datatables/datatable-school-students",
                                        "columns": [
                                            { "data": "nr" },
                                            { "data": "name" },
                                            { "data": "status" },
                                            { "data": "level" },
                                            { "data": "actions" }
                                        ],
                                        "order": [],
                                        "columnDefs": [     
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 0 ], "orderable": false }, 
                                            { className: "no-sort", "targets": [ 1 ], "orderable": false }, 
                                            { className: "no-sort", "targets": [ 2 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 3 ], "orderable": false }, 
                                            { className: "no-sort", "targets": [ 4 ], "orderable": false }
                                        ]
                                    } );

                                    table.columns(1).every( function () {
                                        var that = this;
                                        $( '#selectCourse', this.footer() ).on( 'keypress keyup change', function (e) {
                                            that.search($(this).val()).draw();
                                        });
                                    } );
                                    table.columns(2).every( function () {
                                        var that = this;
                                        $( '#selectStatus', this.footer() ).on( 'keypress keyup change', function (e) {
                                            that.search($(this).val()).draw();
                                        });
                                    } );
                                    table.columns(3).every( function () {
                                        var that = this;
                                        $( '#selectLevel', this.footer() ).on( 'keypress keyup change', function (e) {
                                            that.search($(this).val()).draw();
                                        });
                                    } );
                                    table.columns(3).every( function () {
                                        var that = this;
                                        $( '#selectLevel2', this.footer() ).on( 'keypress keyup change', function (e) {
                                            that.search($(this).val()).draw();
                                        });
                                    } );
                                    
                                    table.columns(4).every( function () {
                                        var that = this;
                                        $( '#selectGender', this.footer() ).on( 'keypress keyup change', function (e) {
                                            that.search($(this).val()).draw();
                                        });
                                    } );
                                    
                                    $('#datatable_school_users tfoot tr').appendTo('#datatable_school_users thead');
                                });
                            </script>

                            <div class="modal fade" id="ModalGeneral" tabindex="-1" role="dialog">  
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content showModalContent" id="showModalContent">
                                        <div class="modal-header text-center">
                                        </div>
                                        <div class="modal-body lower-on-sm text-center img_centered">
                                            <img id="imageLoading" class="img-responsive" src="{{url('/')}}/resources/assets/images/image_loading.gif">
                                        </div>
                                        <div class="modal-footer text-center">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection