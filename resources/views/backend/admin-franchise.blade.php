@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Admin toate francizele</h3>
                    <span>tot felul de tampenii</span>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="datatable_franchise" class="display dt-responsive nowrap bulk_action" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th class="hidden-xs hidden-sm"><input type="checkbox" id="flowcheckall" /></th>
                                        <th class="no-sort img_an_mb" valing="top">IMAGE</th>
                                        <th class="hidden-xs hidden-sm">FRANCHISE NAME</th>
                                        <th class="hidden-xs hidden-sm">LOCATION</th>
                                        <th class="hidden-xs hidden-sm">JOIN ON</th>
                                    </tr>
                                </thead>
                                
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th id="select_local" class="hidden-xs hidden-sm">    
                                            <select id="select_location" name="select_location">
                                                <option value="">Chosse location</option>
                                                <?
                                                foreach ($franchise_location_c as $franchise_location_r) {
                                                    echo '<option value="'.$franchise_location_r->city.'">'.$franchise_location_r->city.'</option>';
                                                }
                                                ?>
                                            </select>                                   
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                                
                            </table>
                            <div id="onCheckAll" style="display:none;">
                                <div class="col-xs-12 text-center marginTop">
                                    <button class="btnNew btnSterge" id="DeactivateAll">DEZACTIVEAZA ANUNTURILE SELECTATE<i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                                <div class="closeModalx" id="closeModalx">Inchide</div>
                            </div>
                            <div id="pageInfo"></div>
                            <script>
                                $(document).ready(function() {
                                    var table = $('#datatable_franchise').DataTable( {
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
                                        "ajax": "<?=url('/')?>/datatables/datatable-franchise",
                                        "columns": [
                                            { "data": "all" },
                                            { "data": "img" },
                                            { "data": "franchise" },
                                            { "data": "location" },
                                            { "data": "created_at" },
                                        ],
                                        "order": [],
                                        "columnDefs": [
                                            { className: "no-sort hidden-xs hidden-sm", "targets": [ 0 ],"orderable": false },       
                                            { className: "no-sort xs-text-left sm-text-left img_an_mb", "targets": [ 1 ], "orderable": false },  
                                            { className: "no-sort hidden-xs hidden-sm warpesTd", "targets": [ 2 ], "orderable": false },
                                            { className: "no-sort xs-text-left sm-text-left", "targets": [ 3 ], "orderable": false },
                                            { className: "text-center hidden-xs hidden-sm", "targets": [ 4 ], "orderable": false },
                                        ]
                                    } );
                                    
                                    table.columns(3).every( function () {
                                        var that = this;
                                        $( '#select_location', this.footer() ).on( 'keypress keyup change', function (e) {
                                            that.search($(this).val()).draw();
                                        });
                                    } );
                                    
                                    $('#datatable_franchise tfoot tr').appendTo('#datatable_franchise thead');
                                    $('#closeModalx').click(function () {
                                        $('#flowcheckall').attr('checked', false);
                                        $('#datatable_franchise tbody input[type="checkbox"]').attr('checked', false);
                                        $('#onCheckAll').hide();
                                    });
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
                            <!--
                            modal
                            -->
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection