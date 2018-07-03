@extends('layouts.frontend.app')

@section('content')
<div class="container NormalPage">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 whant15paddingMob">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>

                <div class="panel-body whant15paddingMob">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <label for="email" class="control-label">E-Mail Address</label>
                            </div>
                            <div class="col-xs-12 col-md-8 col-md-offset-2 text-left">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
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
                            <div class="col-xs-12 col-md-8 col-md-offset-2">
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
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        <br/>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12 col-md-8 col-md-offset-2">
                                <button type="submit" class="btn-default-new-layout btn-new-layout-white">
                                    Login
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-md-4 col-md-offset-2 text-left">
                                <a class="btn btn-link nopaddingMob" href="{{ route('password.request') }}">Forgot Your Password ?</a>
                            </div>
                            <div class="col-xs-6 col-md-4 text-right">
                                <a href="{{ url('/') }}/register" class="btn btn-link nopaddingMob">Need a new account ?</a>
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
