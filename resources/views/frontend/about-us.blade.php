@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1">
                <h1>About us</h1>
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1 pozaFrontend2">
                <div style="background: url('<?=url('/').'/'.$about_r->image;?>');background-position: center center !important;"></div>
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1 descriptionEverywhere">
                <br/><br/>
                <?=is_object($about_r) ? $about_r->text : '' ?>
            </div>
        </div>
    </div>
@endsection