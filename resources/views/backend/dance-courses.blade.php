@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>My dance courses - <?=$user_logat_r->DanceCoursesCount() == '1' ? $user_logat_r->DanceCoursesCount() .' dance class' : $user_logat_r->DanceCoursesCount(). ' dance courses' ?> assigned</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Add dance courses
                            </a>
                            
                            <div class="collapse" id="collapseExample">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="{{ route('add-dance-course') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                                <input type="hidden" name="nrOfDates" value="1" id="nrOfDates" />
                                                <input type="hidden" name="active" value="yes">
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <label for="name" class="control-label">Select Plan</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <select name="plan_id" id="plan_id" class="form-control">
                                                    <option value="">Select plan</option>
                                                    <? foreach ($plans as $plan) { ?>
                                                        <option value="<?=$plan->id?>"><?=$plan->name?></option>
                                                    <? } ?>
                                                </select>
                                            </div>

                                            
                                            <div class="col-xs-12 text-left">
                                                <label for="name" class="control-label">Level</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <select name="level_id" id="level_id" class="form-control">
                                                    <option value="">Select level</option>
                                                    <? foreach ($levels as $level) { ?>
                                                        <option value="<?=$level->id?>"><?=$level->name?></option>
                                                    <? } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 text-left">
                                                <label for="dateRangeCourse" class="control-label">Choose range of dates for this course</label>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="input-group date">
                                                    <input type="text" name="dateRangeCourse" id="dateRangeCourse" class="form-control" value="<?=date("Y-m-d")?> - <?=date('Y-m-d', strtotime("+3 months", strtotime(date("Y-m-d"))))?>">
                                                    <span class="input-group-addon">
                                                       <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-12 text-left">
                                                <label for="dateRangeCourse" class="control-label">Choose days and hours for this course</label>
                                            </div>
                                            <div class="cloneEl">
                                                <div class="col-xs-6">
                                                    <div class="input-group date">
                                                        <select name="selectRange1" id="selectRange1" class="form-control">
                                                            <option value="everyDay">Every day</option>
                                                            <option value="MoToFr">Monday - Friday</option>
                                                            <option value="SaToSu">Saturday - Sunday</option>
                                                            <option value="Mo">Monday</option>
                                                            <option value="Tu">Tuesday</option>
                                                            <option value="We">Wednesday</option>
                                                            <option value="Th">Thurday</option>
                                                            <option value="Fr">Friday</option>
                                                            <option value="Sa">Saturday</option>
                                                            <option value="Su">Sunday</option>
                                                        </select>
                                                        <span class="input-group-addon">
                                                           <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="input-group date">
                                                        <select name="selectHour1" id="selectHour1" class="form-control">
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
                                                                    echo '<option value="'.$hourAndMinutes.'">'.$hourAndMinutes.'</option>';  
                                                                }  
                                                            } ?>
                                                        </select>
                                                        <span class="input-group-addon">
                                                           <span class="glyphicon glyphicon-time"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="clone nopadding"></div>

                                            <div class="col-xs-12 text-right">
                                                <div class="col-xs-12 addNewDate">
                                                    <a href="javascript:void(0)" id="addNewDate">+ Add new date and hour</a>
                                                </div>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="form-group">
                                           <div class="col-xs-12 text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    Add dance course
                                                </button>
                                            </div>
                                        </div>
                                        <br/>
                                    </form>
                                    <script>
                                    $(function() {
                                        $('#level_id, #dance_classes_id').select2();
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
                                            var elNow = parseInt($('#nrOfDates').val()) + 1;
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
                                            $('#nrOfDates').val(elNow);

                                        });
                                    });
                                    </script>
                                </div>
                            </div>
                            <br/>
                            <br/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="datatable_dance_classes" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-sort img_an_mb" valing="top">Dance classes</th>
                                        <th class="hidden-xs hidden-sm">Details</th>
                                        <th class="hidden-xs hidden-sm">Status</th>
                                        <th class="">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="pageInfo"></div>
                            <script>
                                $(document).ready(function() {
                                    var table = $('#datatable_dance_classes').DataTable( {
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
                                        "ajax": "<?=url('/')?>/datatables/datatable-dance-courses",
                                        "columns": [
                                            { "data": "name" },
                                            { "data": "description" },
                                            { "data": "status" },
                                            { "data": "actions" },
                                        ],
                                        "order": [],
                                        "columnDefs": [     
                                            { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 0 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 1 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 2 ], "orderable": false },
                                            { className: "no-sort xs-text-left sm-text-left", "targets": [ 3 ], "orderable": false },
                                        ]
                                    } );
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