@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1 titleH3">
                <h1>Other services offered</h1>
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <? foreach ($service_c as $service_r) { ?>
                    <div class="row danceClassesBorder">
                        <div class="col-xs-12 titleH3">
                            <h3><?=$service_r->title;?></h3>
                        </div>
                        <div class="col-xs-12 col-md-2 pozaFrontend noppading">
                            <a href="<?=route('services-name', ['name' => strtolower(str_replace(' ', '-', $service_r->title)) ])?>">
                                <div style="background: url('<?=url('/').'/'.$service_r->image;?>')"></div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-10 textAditional">
                            <p><?=trim_text($service_r->description, 350);?></p>
                            <p>
                                <a href="<?=route('services-name', ['name' => strtolower(str_replace(' ', '-', $service_r->title)) ])?>" class="btn-default-new-layout btn-new-layout-red">read more</a>
                            </p>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection