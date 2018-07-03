@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3>My school users - <?=$user_logat_r->School->UserCount() == '1' ? $user_logat_r->School->UserCount() .' school student' : $user_logat_r->School->UserCount(). ' school students' ?> signed up</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <table id="datatable_school_users" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-sort img_an_mb" valing="top">User name</th>
                                        <th class="hidden-xs hidden-sm">Status</th>
                                        <th class="hidden-xs hidden-sm">Actions</th>
                                    </tr>
                                </thead>
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
                                        "ajax": "<?=url('/')?>/datatables/datatable-school-users",
                                        "columns": [
                                            { "data": "name" },
                                            { "data": "status" },
                                            { "data": "actions" }
                                        ],
                                        "order": [],
                                        "columnDefs": [     
                                            { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 0 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 1 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 2 ], "orderable": false }
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