@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1 titleH3">
                <h1>Teachers</h1>
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <? foreach ($teacher_c as $teacher_r) { ?>
                    <div class="row danceClassesBorder">
                        <div class="col-xs-12 titleH3">
                            <h3><?=$teacher_r->Name();?></h3>
                        </div>
                        <div class="col-xs-12 col-md-2 pozaFrontend noppading">
                            <a href="<?=route('teachers-name', ['name' => strtolower(str_replace(' ', '-', $teacher_r->Name())) ])?>">
                                <div style="background: url('<?=url('/').'/'.$teacher_r->ProfileImg();?>')"></div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-10 textAditional">
                            <p><?=trim_text($teacher_r->description(), 350);?></p>
                            <p>
                                <a href="<?=route('teachers-name', ['name' => strtolower(str_replace(' ', '-', $teacher_r->Name())) ])?>" class="btn-default-new-layout btn-new-layout-red">read more</a>
                            </p>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection