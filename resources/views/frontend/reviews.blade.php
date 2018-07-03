@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1 titleH3">
                <h1>Reviews from students</h1>
            </div>
            <div class="col-xs-12">
                <div class="row">
                    <? 
                    $x = 0;
                    foreach ($review_c as $review_r) {
                        echo '<div class="col-xs-12 col-md-4"  style="height:450px;">';
                        echo str_replace('data-width=""', 'data-width="" data-height="400"',$review_r->post);
                        echo '</div>';
                    } ?>
                </div>
            </div>
        </div>
    </div>
@endsection