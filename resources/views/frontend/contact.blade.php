@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 whant15paddingMob">
                <div class="panel panel-default">
                    <div class="panel-heading">Contact</div>
                        <div class="panel-body whant15paddingMob">      

                            <div class="col-xs-12 col-md-8 col-md-offset-2 contact">
                                @include('common.errors') 
                            </div>
                            @if(Session::has('flash_message'))
                            <div class="col-xs-12 col-md-8 col-md-offset-2 alert alert-success contact">
                                <em> {!! session('flash_message') !!}</em>
                            </div>
                            @endif

                            <form action="{{ url('contact') }}" method="POST" class="form-horizontal">
                                {{ csrf_field() }}
                                <!-- Task Name -->
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-10 col-md-offset-1 text-left">
                                        <label for="contact-name" class="control-label">NAME * : </label>
                                        <input type="text" name="name" id="contact-name" class="form-control" value="{{old('name')}}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-10 col-md-offset-1 text-left">
                                        <label for="contact-email" class="control-label">EMAIL * : </label>
                                        <input type="text" name="email" id="contact-email" class="form-control" value="{{old('email')}}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-10 col-md-offset-1 text-left">
                                        <label for="contact-phone" class="control-label">PHONE * : </label>
                                        <input type="text" name="phone" id="contact-phone" class="form-control" value="{{old('phone')}}" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 col-md-10 col-md-offset-1 text-left">
                                        <label for="contact-description" class="control-label">TEXT * :</label>
                                        <textarea class="form-control" rows='5' name="description" id="contact-description" value="">{{old('description')}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <button type="submit" class="btn-default-new-layout btn-new-layout-white">
                                            SEND !
                                        </button>
                                    </div>
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection