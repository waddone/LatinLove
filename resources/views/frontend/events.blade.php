@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1 titleH3">
                <h1>Events</h1>
            </div>

            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <? foreach ($events_c as $events_r) { ?>
                    <div class="row danceClassesBorder">
                        <div class="col-xs-12 titleH3">
                            <h3><?=$events_r->title;?></h3>
                        </div>
                         <div class="col-xs-12 col-md-2 pozaFrontend noppading">
                            <a href="<?=route('events-name', ['name' => strtolower(str_replace(' ', '-', $events_r->title)) ])?>">
                                <div style="background: url('<?=url('/').'/'.$events_r->image;?>')"></div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-10 textAditional">
                            <div class="row">
                                <div class="col-xs-6 col-md-3 noppadingMob">
                                    <div class="blablabla">
                                        <i class="fas fa-map-marker-alt"></i> <?=$events_r->place;?>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3 noppadingMob">
                                    <div class="blablabla">
                                        <i class="fas fa-money-bill-alt"></i>  
                                        <? if($events_r->payment == 'free') {
                                            echo 'free';
                                        } else {
                                            echo $events_r->price;
                                        
                                            if($events_r->currency == 'lira') {
                                                $currency = ' british pounds';
                                            } else {
                                                $currency = $events_r->currency;
                                            }
                                            echo $currency;
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3 noppadingMob">
                                    <div class="blablabla">
                                        <i class="far fa-calendar-alt"></i> <?=substr($events_r->date, 0,10)?>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-md-3 noppadingMob">
                                    <div class="blablabla">
                                        <i class="fas fa-clock"></i> <?=$events_r->hour;?>
                                    </div>
                                </div>
                            </div>
                            <p><?=trim_text($events_r->description, 200);?></p>
                            <div class="row booknow">
                                <div class="col-xs-12 col-md-8 bookButtons">
                                    <a href="<?=route('events-name', ['name' => strtolower(str_replace(' ', '-', $events_r->title)) ])?>#booknow" class="btn btn-primary">Book now !</a>
                                    <a href="<?=route('events-name', ['name' => strtolower(str_replace(' ', '-', $events_r->title)) ])?>#booknow" class="btn btn-primary">Interested ?</a>
                                </div>
                                <div class="col-xs-12 col-md-4 viewevent">
                                    <a href="<?=route('events-name', ['name' => strtolower(str_replace(' ', '-', $events_r->title)) ])?>" class="btn-default-new-layout btn-new-layout-red">view event</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection