@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Subscribe for <?=date('F Y')?></h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" method="POST" action="{{ route('account-subscribe-post') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">
                                <input type="hidden" name="school_id" value="<?=Config::get('app.school_id')?>">

                                <div class="control-group">
                                    <div class="col-xs-12 text-left">
                                        <label for="until_when" class="control-label">Subscribtion starting from</label>
                                    </div>
                                   
                                    <div class="col-xs-12 col-md-4 xdisplay_inputx form-group has-feedback">
                                        <input type="text" class="form-control has-feedback-left" id="single_cal2" placeholder="date" name="starting_from">
                                        <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                                        <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                                    </div>
                                    
                                  </div>
            
                                <div class="form-group{{ $errors->has('until_when') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="until_when" class="control-label">Subscribe</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <select name="until_when" class="form-control" required>
                                            <option value="1">1 month</option>
                                            <option value="2">2 months</option>
                                            <option value="3">3 months</option>
                                        </select>
                                    </div>
                                </div>
                                <br/>
                                <div class="form-group">
                                   <div class="col-xs-12 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            Subscribe
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