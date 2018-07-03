@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Newsletter</h3>
                    <div class="clearfix"></div>
                    <!-- Display Validation Errors -->
                    @include('common.errors')
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" method="POST" action="<?=route('admin-newsletter-post')?>" enctype="multipart/form-data">
                                <?=csrf_field()?>
                                <input type="hidden" name="school_id" value="<?=$school_id?>">   
                                <div class="form-group">
                                    <div class="col-xs-12 text-left">
                                        <label for="description" class="control-label">List</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <select name="list" class="form-control">
                                            <option value="">Select recipients</option>
                                            <option value="all">All users</option>
                                            <option value="all-assigned">Users assigned to course</option>
                                            <option value="all-not-assigned">Users not assigned to any of courses</option>
                                            <option value="newsletter">Users assigned to newsletter</option>
                                            <? foreach ($course_c as $course_r) { ?>
                                            <option value="<?=$course_r->id?>">Users assigned to <?=$course_r->PlanName()?> <?=$course_r->Level()?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="form-group">
                                    <div class="col-xs-12 text-left">
                                        <label for="title" class="control-label">Newsletter title</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                </div>
                                <br/>
                                <div class="form-group">
                                    <div class="col-xs-12 text-left">
                                        <label for="description" class="control-label">Newsletter text</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <textarea id="description2" class="form-control" name="description"></textarea>
                                    </div>
                                </div>
                                <br/>
                                <div class="form-group">
                                   <div class="col-xs-12 text-center btnPadding">
                                        <button type="submit" class="btn btn-primary">Send newsletter</button>
                                    </div>
                                </div>
                                <br/>
                            </form>
                            <script>
                            $(function() {
                                $('#description2').froalaEditor();
                            });
                            </script>
                            
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection