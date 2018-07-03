@extends('layouts.frontend.app')

@section('content')
    <div class="container-fluid banners" id="banner">
        <div class="row">
            <div class="col-xs-12 carousel slide"  id="carousel-example-generic" data-ride="carousel">
                <div>
                    <!-- Indicators 
                    <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    </ol>
                    -->
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <img src="{{ url('/images/banner_1.jpg') }}" alt="...">
                            <div class="carousel-caption">
                                <span class="quote">Quote</span>
                                <div class="right_line"></div>
                                <h2 class="h2_banner">
                                    <p>Dance is the hidden<br/> language of the soul</p>
                                </h2>
                                <div class="left_line"></div>
                                <span class="author">Martha Graham</span>
                            </div>
                        </div>
                        <!--
                        <div class="item">
                            <img src="..." alt="...">
                            <div class="carousel-caption">
                                ...
                            </div>
                        </div>
                        -->
                    </div>

                    <!-- Controls 
                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                    -->
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center presentation">
                <h2 class="upper grey">LatinLove - Start learning dance with us</h2>
                <p class="grey_75">
                    Companisto is a community of likeminded individuals with a pioneering mindset whose goal is to pave the way for innovation and entrepreneurship through investment and dedication and, when successful in these pursuits, earn a return on their investment. Companisto is a community of likeminded individuals with a pioneering mindset whose goal is to pave the way for innovation and entrepreneurship through investment and dedication and, when successful in these pursuits, earn a return on their investment.                
                </p>
                <div class="col-xs-12 buttons_block">
                    <br/>
                    <a class="btn-default-new-layout btn-new-layout-white" onclick="loadRegisterPopup();">Sign Up</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="btn-default-new-layout btn-new-layout-red" href="https://www.companisto.com/en/how-it-works">How It Works</a>
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid text-center OurDanceClasses">
        <h2>Our dance classes</h2>
        <div class="row">
            <div class="col-md-10 noppading">
                <div class="carousel slide multi-item-carousel" id="theCarousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-xs-4 poza_block" style="background: url({{ url('/images/Salsa4.jpg') }})">
                                <h4>SALSA CLASS</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4 poza_block" style="background: url({{ url('/images/dasdas.jpg') }})">
               
                                <h4>BACHATA CLASS</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4 poza_block" style="background: url({{ url('/images/dsdsads.jpg') }})">
                                <h4>MERENGUE CLASS</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4 poza_block">
                                <h4>BACHATA CLASS</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4">
                                <a href="#1"><img src="{{ url('/images/merengue_class.jpg') }}" class="img-responsive"></a>
                                <h4>BACHATA CLASS</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4">
                                <a href="#1"><img src="{{ url('/images/merengue_class.jpg') }}" class="img-responsive"></a>
                                <h4>BACHATA CLASS</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-xs-4">
                                <a href="#1"><img src="{{ url('/images/merengue_class.jpg') }}" class="img-responsive"></a>
                                <h4>BACHATA CLASS</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2 controlersBlock">
                <div class="row">
                    <a class="left " href="#theCarousel" data-slide="prev">
                        <div class="col-xs-6 controlBlock text-center">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </div>
                    </a>
                    <a class="right " href="#theCarousel" data-slide="next">
                        <div class="col-xs-6 controlBlock text-center">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<script>
        // Instantiate the Bootstrap carousel

// for every slide in carousel, copy the next slide's item in the slide.
$( document ).ready(function() {
    $('.multi-item-carousel').carousel({
        interval: false
    });

    $('.multi-item-carousel .item').each(function(){
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));
      
        if (next.next().length>0) {
            next.next().children(':first-child').clone().appendTo($(this));
        } else {
            $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
        }
    });
});
</script>


<div class="container-fluid">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 text-center presentation">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                    <h2 class="upper grey">FRANCHISE - AFFILATE WITH US</h2>
                    </div>
                    <div class="col-md-2 text-center">
                        <img src="https://www.companisto.com/graphics/layout/companisto-andreas-riedel.jpg" alt="Andreas Riedel" class="img-responsive img-circle text-center">
                        BANU MIHAI
                    </div>
                    <div class="col-md-10">
                        <p class="grey_75">
                            Companisto is a community of likeminded individuals with a pioneering mindset whose goal is to pave the way for innovation and entrepreneurship through investment and dedication and, when successful in these pursuits, earn a return on their investment. Companisto is a community of likeminded individuals with a pioneering mindset whose goal is to pave the way for innovation and entrepreneurship through investment and dedication and, when successful in these pursuits, earn a return on their investment.                
                        </p>
                        <div class="col-xs-12 buttons_block">
                            <br/>
                            <a class="btn-default-new-layout btn-new-layout-red add_margin_left" onclick="loadRegisterPopup();">Affilate with us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
@endsection