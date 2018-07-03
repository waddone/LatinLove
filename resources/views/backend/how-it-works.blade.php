@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h3>How it works</h3>
                    <span>Currently you have <?=$user_logat_r->puncte?> points</span>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-xs-12">
                            <ul>
                                <li>The moment you get started you already have 60 points </li>
                                <li>First month subscription of £40 gives you an extra 40 points </li>
                                <li>Refer a friend that will join and win 100 points </li>
                                <li>Join by class £9 gives you 9 points </li>
                                <li>Monthly subscription £60 </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection