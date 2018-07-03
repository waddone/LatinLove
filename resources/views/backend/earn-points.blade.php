@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3>My points</h3>
                    <span>Currently you have <?=$user_logat_r->puncte?> points</span>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <h3>As soon as you reach 600 points you can apply for one free month subscription</h3>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 fixed_height_320">
            <div class="x_panel fixed_height_320">
                <div class="x_title">
                    <h3>My Points</h3>
                    <div class="subtitle">Earn 600 points and get a free month subcription</div>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="col-xs-12">
                    <div style="text-align: center; margin-bottom: 17px">
                        <span class="chart" data-percent="<?=$user_logat_r->PercentagePoints();?>">
                        <span class="percent"><?=$user_logat_r->PercentagePoints();?></span>
                        <canvas height="110" width="110"></canvas></span>
                    </div>
                  </div>
                  <div class="col-xs-12 text-center">
                    
                    <h3 class="name_title"><?=$user_logat_r->puncte;?> points</h3>
                    Currently you have <?=$user_logat_r->puncte;?> points.
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection