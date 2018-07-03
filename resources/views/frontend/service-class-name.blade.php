@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 text-center NormalPageH1">
                <h1><?=$service_r->title?></h1>
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1 pozaFrontend2">
                <div style="background: url('<?=url('/').'/'.$service_r->image;?>')"></div>
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <?=$service_r->description?>
            </div>
        </div>
    </div>
@endsection