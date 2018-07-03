@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>My school teachers - <?=$user_logat_r->School->TeacherCount() == '1' ? $user_logat_r->School->TeacherCount() .' teacher' : $user_logat_r->School->TeacherCount() .' teachers'?> assigned</h3>
                    <div class="clearfix"></div>
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Add teacher
                            </a>
                            
                            <div class="collapse" id="collapseExample">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="{{route('add-school-teachers')}}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="name" class="control-label">Choose user</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="hidden" name="school_id" value="<?=$user_logat_r->School->id?>">
                                                <input type="hidden" name="active" value="yes">
                                                <select name="user_id" id="teacher" class="form-control">
                                                    <option value="">Choose teacher</option>
                                                    <?
                                                    foreach ($all_users as $all_users_r) {
                                                        echo '<option value="'.$all_users_r->id.'">'.$all_users_r->name.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('dance_class_id') ? ' has-error' : '' }}">
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
                                                $('#teacher, #course_id').select2();
                                            });
                                        </script>
                                        <br/>
                                        <div class="form-group">
                                           <div class="col-xs-12 text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    Add teacher
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
                            <br/>
                            <br/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="datatable_dance_classes" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-sort img_an_mb" valing="top">Image</th>
                                        <th class="no-sort img_an_mb" valing="top">Name</th>
                                        <th class="">Dance course</th>
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
                                        "ajax": "<?=url('/')?>/datatables/datatable-teachers",
                                        "columns": [
                                            { "data": "image" },
                                            { "data": "name" },
                                            { "data": "danceclass" },
                                            { "data": "status" },
                                            { "data": "actions" },
                                        ],
                                        "order": [],
                                        "columnDefs": [     
                                            { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 0 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 1 ], "orderable": false }, 
                                            { className: "no-sort xs-text-left sm-text-left", "targets": [ 2 ], "orderable": false },
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 3 ], "orderable": false },
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