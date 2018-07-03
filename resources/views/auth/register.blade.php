@extends('layouts.frontend.app')

@section('content')
<div class="container NormalPage">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default whant15paddingMob">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <!-- 
                        daca vine de pe alt site urmatoarele 2 inputuri sunt :
                        <input type="hidden" name="franciza" value="yes">
                        <input type="hidden" name="source" value="situl_respectiv">
                        -->
                        <input type="hidden" name="franciza" value="no">
                        <input type="hidden" name="source" value="site_mama">
                        <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <label for="name" class="control-label">Name</label>
                            </div>
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <label for="email" class="control-label">E-Mail Address</label>
                            </div>
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <label for="password" class="control-label">Password</label>
                            </div>
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <label for="password-confirm" class="control-label">Confirm Password</label>
                            </div>
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <label for="password-confirm" class="control-label">Choose country</label>
                            </div>
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <select name="country" class="form-control" required>    
                                    <? foreach ($country_c as $country_r) { ?>
                                        <option value="<?=$country_r->country_name?>" <?=$country_r->country_name=='United Kingdom'?'selected':''?>><?=$country_r->country_name?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <br/>

                        <div class="form-group">
                           <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
                                <button type="submit" class="btn-default-new-layout btn-new-layout-white">
                                    Register
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
                                <a href="{{ url('/') }}/login" class="login uppercase">LOGIN</a>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-center">
                                OR <br/><br/>
                                <a href="{{route('facebook-login')}}" class="btn-default-new-layout btn-new-layout-facebook">
                                    Facebook Login
                                </a>
                            </div>
                        </div>
                        <br/><br/>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
