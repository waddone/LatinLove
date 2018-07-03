@extends('layouts.frontend.app')

@section('content')
    <div class="container NormalPage">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 NormalPageH1 titleH3">
                <h1>Blog</h1>
            </div>
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <? foreach ($bloc_article_c as $bloc_article_r) { ?>
                    <div class="row danceClassesBorder">
                        <div class="col-xs-12 titleH3">
                            <h3><?=$bloc_article_r->title;?></h3>
                        </div>
                        <div class="col-xs-12 col-md-2 pozaFrontend noppading">
                            <a href="<?=route('blog-article', ['title' => strtolower(str_replace(' ', '-', $bloc_article_r->title)) ])?>">
                                <div style="background: url('<?=url('/').'/'.$bloc_article_r->image1;?>')"></div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-10 textAditional">
                            <p><?=trim_text($bloc_article_r->description, 350);?></p>
                            <p class="textcenterMob">
                                <a href="<?=route('blog-article', ['title' => strtolower(str_replace(' ', '-', $bloc_article_r->title)) ])?>" class="btn-default-new-layout btn-new-layout-red">read more</a>
                            </p>
                        </div>
                    </div>
                <? } ?>
            </div>
        </div>
    </div>
@endsection