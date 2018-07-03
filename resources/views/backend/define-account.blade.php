@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Edit account</h3>
                    <span>your current profile level is at <?=$user_logat_r->getProfileLevel()?></span>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-8">
                            <form class="form-horizontal" method="POST" action="{{ route('complete-profile') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="name" class="control-label">Name</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ $user_logat_r->name }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="email" class="control-label">E-Mail Address</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ $user_logat_r->email }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="phone" class="control-label">Phone number</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="phone" type="text" class="form-control" name="phone" value="{{ $user_logat_r->phone }}" required autofocus>

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="country" class="control-label">Choose country</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <select name="country" class="form-control" required>    
                                            <? foreach ($country_c as $country_r) { ?>
                                                <option value="<?=$country_r->country_name?>" <?=$user_logat_r->country == $country_r->country_name ? 'selected':''?>><?=$country_r->country_name?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="city" class="control-label">City</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="city" type="text" class="form-control" name="city" value="{{ $user_logat_r->city }}" required autofocus>

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="zipcode" class="control-label">Zipcode</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="zipcode" type="text" class="form-control" name="zipcode" value="{{ $user_logat_r->zipcode }}" required autofocus>

                                        @if ($errors->has('zipcode'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('zipcode') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="gender" class="control-label">Gender</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <select name="gender" class="form-control" required>
                                            <option value="">Select your gender</option>
                                            <option value="male" <?=$user_logat_r->gender=='male'?'selected':''?>>male</option>
                                            <option value="female" <?=$user_logat_r->gender=='female'?'selected':''?>>female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('profile_image') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="profile_image" class="control-label">Your profile image</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input type="file" name="profile_image" id="profile_image" value="{{ $user_logat_r->profile_image }}">
                                    </div>
                                </div>

                                <br/>
                                <div class="form-group">
                                   <div class="col-xs-12 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            Update profile
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-4 text-center">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h3><?=$user_logat_r->name?></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-xs-offset-3 text-center">
                                    <img src="<?=$user_logat_r->avatar()?>" class="img-responsive img-circle" style="width: 100px;height: 100px;margin:0 auto!important;">
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