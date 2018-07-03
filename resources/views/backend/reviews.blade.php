@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Facebook Reviews</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="btn btn-primary" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Add facebook review
                            </a>
                            
                            <div class="collapse" id="collapseExample">
                                <div class="well">
                                    <form class="form-horizontal" method="POST" action="{{ route('add-review') }}" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('post') ? ' has-error' : '' }}">
                                            <div class="col-xs-12 text-left">
                                                <label for="post" class="control-label">Review code</label>
                                            </div>
                                            <div class="col-xs-12 text-left">
                                                
                                                <textarea id="post" class="form-control" name="post" value="" required autofocus></textarea>
                                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                                <input type="hidden" name="status" value="active">
                                                @if ($errors->has('post'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('post') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                           <div class="col-xs-12 text-center">
                                                <button type="submit" class="btn btn-primary">
                                                    Add review
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
                        <? foreach ($review_c as $review_r) {
                            echo '<div class="col-xs-12 col-md-4">';
                            echo $review_r->post;
                            echo '</div>';
                        } ?>
                    </div>
                    <div id="fb-root"></div>
                    <script>(function(d, s, id) {
                      var js, fjs = d.getElementsByTagName(s)[0];
                      if (d.getElementById(id)) return;
                      js = d.createElement(s); js.id = id;
                      js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=162397747773920&autoLogAppEvents=1';
                      fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection