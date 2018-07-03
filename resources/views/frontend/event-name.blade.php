@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1">
                <h1><?=$event_r->title?></h1>
            </div>
            <div class="col-xs-12 col-md-3 col-md-offset-1 pozaFrontend2">
                <div style="background: url('<?=url('/').'/'.$event_r->image;?>')"></div>
            </div>
            <div class="col-xs-12 col-md-8 descriptionEverywhere">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="blablabla">
                            <i class="fas fa-map-marker-alt"></i>  <?=$event_r->place;?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="blablabla">
                            <i class="fas fa-money-bill-alt"></i>  
                            <? if($event_r->payment == 'free') {
                                echo 'free';
                            } else {
                                echo $event_r->price;
                            
                                if($event_r->currency == 'lira') {
                                    $currency = 'british pounds';
                                } else {
                                    $currency = $event_r->currency;
                                }
                                echo $currency;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="blablabla">
                            <i class="far fa-calendar-alt"></i> <?=substr($event_r->date, 0,10)?>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="blablabla">
                            <i class="fas fa-clock"></i> <?=$event_r->hour;?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <?=$event_r->description?>
                    </div>
                </div>
            </div>
            

            <div class="col-xs-12 col-md-10 col-md-offset-1" id="booknow">
                <br/>
                <h3>SHARE THIS EVENT</h3>
                <div class="shareDiv">
                    <div class="fbDiv">
                        <div class="fb-share-button" data-href="<?=route('events-name', ['name' => strtolower(str_replace(' ', '-', $event_r->title)) ])?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
                    </div>
                    <div class="GgDiv">
                        <a class="tumblr-share-button" href="https://www.tumblr.com/share"></a>
                    </div>
                    <div class="TwDiv">
                        <a href="http://www.twitter.com/share?url=<?=route('events-name', ['name' => strtolower(str_replace(' ', '-', $event_r->title)) ])?>&text=<?=$event_r->title?>" class="twitter-share-button" data-show-count="true">Tweet</a>
                        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div>
                    <!--
                    <div class="ThDiv">
                        <g:plus action="share"></g:plus>
                        <script src="https://apis.google.com/js/platform.js" async defer></script>
                    </div>
                    -->
                </div>

            </div>



            <div class="col-xs-12 col-md-10 col-md-offset-1" id="booknow">
                <br/><br/>
                <h3>BOOK NOW THIS <?=$event_r->payment == 'free'?'FREE ':''?>EVENT</h3>
                <? if($event_r->EventInProgres() == true) { ?> 

                    @if ( Auth::check() ) 

                        <?if(Auth::user()->HasbookedThisEvent($event_r->id) == true) { ?>
                            you already book this event
                        <? } else { ?>    
                            <form class="form-horizontal" method="POST" action="<?=route('add-event-booking')?>" enctype="multipart/form-data">
                                <?=csrf_field()?>
                                <input type="hidden" name="school_id" value="<?=config('app.school_id')?>">
                                <input type="hidden" name="user_id" value="<?=Auth::user()->id?>">
                                <input type="hidden" name="event_id" value="<?=$event_r->id?>">
                                <? if($event_r->payment == 'free') { ?>
                                <input type="hidden" name="payment" value="free">
                                <? } else { ?>
                                <div class="form-group>">
                                    <div class="col-xs-12 text-left">
                                        <label for="name" class="control-label">Select payment</label>
                                    </div>
                                    <div class="col-xs-12 text-left">
                                        <select name="payment" class="form-control">
                                            <option value="">Select payment</option>
                                            <? if ($event_r->payment == 'all') { ?>
                                                <option value="paypall">Paypall</option>
                                                <option value="cash">Cash</option>
                                                <option value="bank">Bank transfer</option>
                                            <? } if ($event_r->payment == 'cash') { ?>
                                                <option value="cash">Cash</option>
                                            <? } if ($event_r->payment == 'online') { ?>   
                                                <option value="paypall">Paypall</option>
                                            <? } if ($event_r->payment == 'bank') { ?>   
                                                <option value="bank">Bank transfer</option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <?  } ?>
                                <div class="form-group>">
                                    <div class="col-xs-12 text-center">
                                        <br/>
                                        <br/>
                                        <button type="submit" class="btn btn-primary">
                                            BOOK NOW
                                        </button>
                                    </div>
                                </div>
                            </form>
                        <? } ?>
                    @else 
                    to book this event you need to have an account and to be loged with your credentials 
                    @endif

                <? } // end event is in progres
                else { ?>
                    This event is gone
                <? } ?>
            </div>
        </div>
    </div>
@endsection