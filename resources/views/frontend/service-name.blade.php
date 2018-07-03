@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 text-left NormalPageH1">
                <h1><?=$service_r->title?></h1>
            </div>
            <div class="col-xs-12 col-md-3 col-md-offset-1 pozaFrontend2">
                <div style="background: url('<?=url('/').'/'.$service_r->image;?>')"></div>
            </div>
            <div class="col-xs-12 col-md-8 descriptionEverywhere">
                <?=$service_r->description?>

                <br/>
                <br/>
                <div class="shareDiv">
                    <div class="fbDiv">
                        <div class="fb-share-button" data-href="<?=Route::currentRouteName();?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
                    </div>
                    <div class="GgDiv">
                        <a class="tumblr-share-button" href="https://www.tumblr.com/share"></a>
                    </div>
                    <div class="TwDiv">
                        <a href="http://www.twitter.com/share?url=<?=Route::currentRouteName();?>&text=<?=$service_r->title?>" class="twitter-share-button" data-show-count="true">Tweet</a>
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
        </div>
    </div>
@endsection