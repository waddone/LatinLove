@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 SmallPadddingMobile">
            <div class="x_panel">
                <div class="x_title">
                    <h3>My school details</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <form class="form-horizontal" method="POST" action="{{ route('complete-school-details') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="name" class="control-label">School name</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="name" type="text" class="form-control" name="name" value="<?=is_object($school_r)? $school_r->name : ''?>" required autofocus>
                                        <input type="hidden" name="user_id" value="<?=$user_logat_r->id?>">

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="owner" class="control-label">Owner</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="owner" type="text" class="form-control" name="owner" value="{{ $user_logat_r->name }}" disabled>
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
                                        <label for="phone_1" class="control-label">Phone number 1</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="phone_1" type="text" class="form-control" name="phone_1" value="<?=is_object($school_r)? $school_r->phone_1 : ''?>" required autofocus>

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone_1') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="phone_2" class="control-label">Phone number 2</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="phone_2" type="text" class="form-control" name="phone_2" value="<?=is_object($school_r)? $school_r->phone_2 : ''?>" autofocus>

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone_2') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="phone_3" class="control-label">Phone number 3</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="phone_3" type="text" class="form-control" name="phone_3" value="<?=is_object($school_r)? $school_r->phone_3 : ''?>" autofocus>

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone_3') }}</strong>
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
                                            <? if(is_object($school_r)) {
                                                $selected = $school_r->country;
                                            } else {
                                                $selected = '';
                                            } ?>    
                                            <option value="">Choose country</option>
                                            <? foreach ($country_c as $country_r) { ?>
                                                <option value="<?=$country_r->country_name?>" <?=$selected == $country_r->country_name ? 'selected':''?>><?=$country_r->country_name?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="city" class="control-label">City</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="city" type="text" class="form-control" name="city" value="<?=is_object($school_r)? $school_r->city : ''?>" required autofocus>

                                        @if ($errors->has('city'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('city') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="address" class="control-label">Address</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="address" type="text" class="form-control" name="address" value="<?=is_object($school_r)? $school_r->address : ''?>" required autofocus>

                                        @if ($errors->has('zipcode'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                                    <div class="col-xs-12 text-left">
                                        <label for="zipcode" class="control-label">Zipcode</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <input id="zipcode" type="text" class="form-control" name="zipcode" value="<?=is_object($school_r)? $school_r->zipcode : ''?>" required autofocus>

                                        @if ($errors->has('zipcode'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('zipcode') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <br/>
                                <div class="form-group">
                                   <div class="col-xs-12 text-center">
                                        <button type="submit" class="btn btn-primary">
                                            Update school details
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