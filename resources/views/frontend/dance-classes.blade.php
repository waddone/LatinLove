@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1 titleH3">
                <h1>Dance styles</h1>
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <? foreach ($danceClasses_c as $danceClasses_r) { ?>
                    <div class="row danceClassesBorder">
                        <div class="col-xs-12 titleH3">
                            <h3><?=$danceClasses_r->name;?></h3>
                        </div>
                        <div class="col-xs-12 col-md-2 pozaFrontend noppading">
                            <a href="<?=route('dance-class-name', ['name' => strtolower(str_replace(' ', '-', $danceClasses_r->name)) ])?>">
                                <div style="background: url('<?=url('/').'/'.$danceClasses_r->image1;?>')"></div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-10 textAditional">
                            <p><?=trim_text($danceClasses_r->description, 350);?></p>
                            <p class="textcenterMob">
                                <a href="<?=route('dance-class-name', ['name' => strtolower(str_replace(' ', '-', $danceClasses_r->name)) ])?>" class="btn-default-new-layout btn-new-layout-red">read more</a>
                            </p>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection