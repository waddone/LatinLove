@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Plans and prices</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Add plan
                            </a>
                            
                            <div class="collapse" id="collapseExample">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="{{ route('add-plan') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="title" class="control-label">Plan name</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="text"  name="name" id="name" class="form-control" required autofocus>
                                                <input type="hidden" name="school_id" value="<?=$school_id?>">
                                                <input type="hidden" name="status" value="active">
                                                <input type="hidden" name="nrOfDetails" value="1" id="nrOfDetails" />
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="type" class="control-label">Plan type</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <select name="type" class="form-control">
                                                    <option value="">Choose type</option>
                                                    <option value="senior">Senior</option>
                                                    <option value="adults">Adults</option>
                                                    <option value="children">Children</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="type" class="control-label">Price</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="text" name="price" placeholder="Price ex: 60 - enter just digits" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('currency') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="currency" class="control-label">Price</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <select name="currency" id="currency4" class="form-control">
                                                    <option value="">Select currency</option>
                                                    <? foreach ($currency_c as $currency_r) { ?>
                                                        <option value="<?=$currency_r->code?>"><?=$currency_r->code?> - <?=$currency_r->country?></option>
                                                    <? } ?>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 text-left">
                                                <label for="details" class="control-label">Detail nr 1</label>
                                            </div>
                                            <div class="form-group cloneEl">
                                                <div class="col-xs-12 text-left">
                                                    <input type="text" name="detail1" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clone nopadding"></div>
                                        
                                        <div class="col-xs-12 text-right">
                                            <div class="col-xs-12 addNewDate">
                                                <a href="javascript:void(0)" id="addNewDetail" class="addNewDetail">+ Add extra detail</a>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="form-group">
                                            <div class="col-xs-12 text-left">
                                                <label for="front" class="control-label">Visible on front ?</label>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" name="front"> 
                                                    <option value="">Choose</option>
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-xs-12 text-left">
                                                <label for="position" class="control-label">Position</label>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control" name="position"> 
                                                    <option value="">Choose</option>
                                                    <option value="none">none</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                           <div class="col-xs-12 text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    Add plan
                                                </button>
                                            </div>
                                        </div>
                                        <br/>
                                    </form>
                                    <script>
                                    $(document).ready(function() {
                                        $('.addNewDetail').on('click', function () {
                                            var elNow = parseInt($('#nrOfDetails').val()) + 1;
                                            if(elNow > 10){
                                                var html  = '<div class="text-center" style="color:red"><strong>Maximum 10 extra details</strong></div>';
                                            } else {
                                                var html  = '<div class="form-group cloneEl'+elNow+'"><div class="col-xs-12 text-left"><label for="detail'+elNow+'" class="control-label">Detail nr '+elNow+'</label></div><div class="col-xs-12 text-left"><input type="text" name="detail'+elNow+'" class="form-control"></div></div>';
                                            }
                                            $('.clone').append(html);
                                            $('#nrOfDetails').val(elNow);
                                            $('#currency4').select2();
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
                                        <th class="no-sort img_an_mb" valing="top">Plan</th>
                                        <th class="no-sort img_an_mb" valing="top">Type</th>
                                        <th class="">Price</th>
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
                                        "ajax": "<?=url('/')?>/datatables/datatable-plans",
                                        "columns": [
                                            { "data": "name" },
                                            { "data": "type" },
                                            { "data": "price" },
                                            { "data": "status" },
                                            { "data": "actions" },
                                        ],
                                        "order": [],
                                        "columnDefs": [     
                                            { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 0 ], "orderable": false }, 
                                            { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 1 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 2 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 3 ], "orderable": false },
                                            { className: "no-sort", "targets": [ 4 ], "orderable": false },
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