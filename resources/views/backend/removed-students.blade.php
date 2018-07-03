@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Removed students - <?=$user_logat_r->School->RemovedUserCount() == '1' ? $user_logat_r->School->RemovedUserCount() .' student' : $user_logat_r->School->RemovedUserCount(). ' students' ?></h3>
                    <div class="clearfix"></div>
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                </div>
                <div class="x_content">
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
                                        "ajax": "<?=url('/')?>/datatables/datatable-school-removed-students",
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