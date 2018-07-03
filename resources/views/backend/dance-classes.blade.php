@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>My dance styles - <?=$user_logat_r->DanceClassesCount() == '1' ? $user_logat_r->DanceClassesCount() .' dance style' : $user_logat_r->DanceClassesCount(). ' dance styles' ?> assigned</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Add dance style
                            </a>
                            
                            <div class="collapse" id="collapseExample">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="{{ route('add-dance-class') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="name" class="control-label">Dance class name</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                                 <input type="hidden" name="active" value="yes">
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="description" class="control-label">Description</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <textarea id="description" class="form-control" name="description"></textarea>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="form-group{{ $errors->has('order_nr') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="order_nr" class="control-label">Order nr</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="text" name="order_nr" id="order_nr" value="">
                                            </div>
                                        </div>
                                        <br/>

                                        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="image" class="control-label">Add image</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="file" name="image" id="image" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                           <div class="col-xs-12 text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    Add dance style
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
                                        <th class="no-sort img_an_mb" valing="top">Dance styles</th>
                                        <th class="hidden-xs hidden-sm">Description</th>
                                        <th class="">Status</th>
                                        <th class="hidden-xs hidden-sm">Order</th>
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
                                        "ajax": "<?=url('/')?>/datatables/datatable-dance-classes",
                                        "columns": [
                                            { "data": "image" },
                                            { "data": "name" },
                                            { "data": "description" },
                                            { "data": "status" },
                                            { "data": "order" },
                                            { "data": "actions" },
                                        ],
                                        "order": [],
                                        "columnDefs": [     
                                            { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 0 ], "orderable": false }, 
                                            { className: "no-sort xs-text-left sm-text-left", "targets": [ 1 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 2 ], "orderable": false },
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 3 ], "orderable": false },
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 4 ], "orderable": false },
                                            { className: "no-sort xs-text-left sm-text-left", "targets": [ 5 ], "orderable": false },
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