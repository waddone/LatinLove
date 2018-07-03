@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Earn points by referree</h3>
                    <span>Currently you have <?=$user_logat_r->puncte?> points</span>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Add friend / referrer
                            </a>
                            
                            <div class="collapse" id="collapseExample">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="{{ route('add-friend') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                        <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>" />
                                        <input type="hidden" name="status" value="notsentyet">
                                        
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">    
                                                <label for="name" class="control-label">Friend name</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">    
                                                <label for="name" class="control-label">Friend email</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="text" name="email" class="form-control">
                                            </div>
                                        </div>
                                            
                                        <div class="form-group">
                                           <div class="col-xs-12 text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    Add friend
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
                            <table id="datatable_friends" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="no-sort img_an_mb" valing="top">Name</th>
                                        <th class="hidden-xs hidden-sm">Email</th>
                                        <th class="hidden-xs hidden-sm">Status</th>
                                        <th class="">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                            <div id="pageInfo"></div>
                            <script>
                                $(document).ready(function() {
                                    var table = $('#datatable_friends').DataTable( {
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
                                        "ajax": "<?=url('/')?>/datatables/datatable-friends",
                                        "columns": [
                                            { "data": "name" },
                                            { "data": "email" },
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