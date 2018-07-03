@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>About us - edit</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" method="POST" action="{{ route('admin-about-us-post') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <input type="hidden" name="school_id" value="<?=$school_r->id?>">
                                <input type="hidden" name="uid" value="about-us">
                                <input type="hidden" name="update" value="<?=$about_r->image?>">

                                <div class="form-group">
                                    <div class="col-xs-12 text-left">
                                        <label for="text" class="control-label">About us text</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <textarea id="text" class="form-control" name="text"><?=is_object($about_r) ? $about_r->text:'' ?></textarea>
                                    </div>
                                </div>
                                <br/>
                                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                        <div class="col-xs-12 text-left">
                                            <label for="image" class="control-label">Add image</label>
                                        </div>
                                        <div class="col-xs-12 text-left">
                                            <input type="file" name="image" id="image" value="<?=$about_r->image?>">
                                        </div>
                                    </div>
                                <br/>
                                <script>
                                $(function() {
                                    $('#text').froalaEditor();
                                });
                                </script>

                                <br/>
                                <div class="form-group">
                                   <div class="col-xs-12 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            Update about us
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection