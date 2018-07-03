@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>My events</h3>
                    <div class="clearfix"></div>
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Add event 
                            </a>
                            
                            <div class="collapse" id="collapseExample">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="<?=route('add-events')?>" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="title" class="control-label">Event name</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input id="title" type="text" class="form-control" name="title" value="" required autofocus>
                                                <input type="hidden" name="school_id" value="<?=$school_id?>">
                                                <input type="hidden" name="status" value="active">
                                                @if ($errors->has('title'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('title') }}</strong>
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

                                        <div class="form-group{{ $errors->has('place') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="place" class="control-label">Location</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                <input type="text" name="place" id="place" class="form-control">
                                            </div>
                                        </div>
                                        <br/>

                                        <div class="form-group{{ $errors->has('place') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="date" class="control-label">Choose date and hour</label>
                                            </div>
                                            <div class="col-xs-6 text-left">
                                                <div class="input-group date">
                                                    <input type="text" class="form-control has-feedback-left" id="single_cal2" name="date">
                                                    <span class="input-group-addon">
                                                       <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                    <div class="input-group date">
                                                        <select name="hour" id="selectHour1" class="form-control">
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
                                        <br/>
                                        <div class="form-group">
                                            <div class="col-xs-12 text-left">
                                                <label class="">
                                                    <input type="checkbox" name="free"> This event is free ? 
                                                </label>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="price" class="control-label">Price & currency</label>
                                            </div>
                                            <div class="col-xs-6 text-left">
                                                <input type="text" name="price" id="price" class="form-control">
                                            </div>
                                        
                                            <div class="col-xs-6 text-left">
                                                <select name="currency" id="currency" class="form-control">
                                                    <option value="">Select currency</option>
                                                    <? foreach ($currency_c as $currency_r) { ?>
                                                        <option value="<?=$currency_r->code?>"><?=$currency_r->code?> - <?=$currency_r->country?></option>
                                                    <? } ?>
                                                    
                                                </select>
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
                                                    Add event
                                                </button>
                                            </div>
                                        </div>
                                        <br/>
                                    </form>
                                    <script>
                                    $(function() {
                                        $('#description').froalaEditor();
                                        $('#currency').select2();
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
                            <table id="datatable_school_users" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="hidden-xs hidden-sm" valing="top">Img</th>
                                        <th class="no-sort img_an_mb" valing="top">Title</th>
                                        <th class="hidden-xs hidden-sm">Status</th>
                                        <th class="hidden-xs hidden-sm">Location & date</th>
                                        <th class="hidden-xs hidden-sm">Attending</th>
                                        <th class="">Actions</th>
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
                                        "ajax": "<?=url('/')?>/datatables/datatable-events",
                                        "columns": [
                                            { "data": "img" },
                                            { "data": "title" },
                                            { "data": "status" },
                                            { "data": "location" },
                                            { "data": "attending" },
                                            { "data": "actions" }
                                        ],
                                        "order": [],
                                        "columnDefs": [     
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 0 ], "orderable": false }, 
                                            { className: "no-sort ", "targets": [ 1 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 2 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 3 ], "orderable": false }, 
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 4 ], "orderable": false },
                                            { className: "no-sort", "targets": [ 5 ], "orderable": false }
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