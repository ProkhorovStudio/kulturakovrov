<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$arrCount = ['one','two','three','four','five','six','seven','eight','nine','ten'];
?>



            <?
            $i = 0;
            foreach($arResult["ITEMS"] as $arItem):?>
<?php
        //echo "<pre>";
          //      print_r($arItem['COVERS']);
                ?>
<section id="two" class="d-none d-md-block <?=$arrCount[$i]?>">
    <div class="container">
        <div class="slider-block">
            <div class="slider-item" id="<?=$arrCount[$i]?>">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="type-cover">
                            <?=$arItem['PROPERTIES']['ATT_TYPE_COVER']['VALUE']?>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6">
                        <h2><?=$arItem['PROPERTIES']['ATT_TITLE']['~VALUE']['TEXT']?></h2>
                    </div>
                    <div class="col-xl-2 col-lg-3 d-none d-lg-block">
                        <a href="<?=$arItem['PROPERTIES']['ATT_LINK']['VALUE']?>" class="detail-link">все варианты</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-6">
                        <a href="<?=$arItem['PROPERTIES']['ATT_LINK']['VALUE']?>" class="detail-link d-lg-none">все</a>
                        <div class="slider-cover pk  <?=$arrCount[$i]?>">
                            <?foreach ($arItem['COVERS'] as $slideCover):?>
                            <a target="_blank" href="<?=$slideCover['LINK']?>" class="slider-cover__item">
                                <img src="<?=$slideCover['IMAGE']?>" alt="">
                            </a>
                            <?endforeach;?>
                        </div>
                        <div class="slider-cover__btns pk <?=$arrCount[$i]?>">
                            <div class="btns__left"></div>
                            <div class="slider-cover__dots pk <?=$arrCount[$i]?>"></div>
                            <div class="btns__right"></div>
                        </div>

                    </div>

                    <div class="bg-block" style="background: url('<?=$arItem['PREVIEW_PICTURE']['SRC']?>') no-repeat"></div>

                </div>
            </div>
        </div>

    </div>
</section>
           <?
            $i++;
            endforeach?>

<section id="two-mobile" class="d-block d-md-none">
    <div class="container">

        <div class="slider-dots-two">
            <?
            $i = 0;
            foreach ($arResult['DOTS-SLIDER'] as $typeCover):
                ?>
                <div class="slider-dots-two__item <?=($i == 0) ? 'active' : ''?>" data-id="<?=$i;?>"><?=$typeCover['NAME']?></div>
                <? $i++;
            endforeach;?>
        </div>
        <div class="slider-block-mobile">
            <?
            $i = 0;
            foreach($arResult["ITEMS"] as $arItem):?>
                <div class="slider-item" id="<?=$arrCount[$i]?>">
                    <div class="row">
                        <div class="col-xl-7 col-lg-6">
                            <h2><?=$arItem['PROPERTIES']['ATT_TITLE']['~VALUE']['TEXT']?></h2>
                            <a href="<?=$arItem['PROPERTIES']['ATT_LINK']['VALUE']?>" class="detail-link">все </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-sm-6">
                            <div class="slider-cover  mobile <?=$arrCount[$i]?>">
                                <?foreach ($arItem['COVERS'] as $slideCover):?>
                                    <a target="_blank" href="<?=$slideCover['LINK']?>" class="slider-cover__item">
                                        <img src="<?=$slideCover['IMAGE']?>" alt="">
                                    </a>
                                <?endforeach;?>
                            </div>
                            <div class="slider-cover__btns mobile <?=$arrCount[$i]?>">
                                <div class="btns__left"></div>
                                <div class="slider-cover__dots mobile <?=$arrCount[$i]?>"></div>
                                <div class="btns__right"></div>
                            </div>

                        </div>
                            <div class="bg-block ims-<?=$arrCount[$i]?>">
                                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>">
                            </div>
                    </div>
                </div>
                <?
                $i++;
            endforeach?>
        </div>

    </div>
</section>
<style>
    .slider-cover.one{
        z-index: 9 !important;
    }
    .slider-cover.two{
        z-index: 8 !important;
    }
    .slider-cover.three{
        z-index: 7 !important;
    }
</style>
<script>
    $(document).ready(function(){

        $('.slider-cover.pk.one').slick({
            dots:true,
            slidesToShow: 1,
            slidesToScroll: 1,
            appendDots: $('#two .slider-cover__btns.one .slider-cover__dots.one'),
            prevArrow:$('#two .slider-cover__btns.one .btns__left'),
            nextArrow:$('#two .slider-cover__btns.one .btns__right'),
        })
        $('.slider-cover.pk.two').slick({
            dots:true,
            slidesToShow: 1,
            slidesToScroll: 1,
            appendDots: $('#two .slider-cover__btns.two .slider-cover__dots.two'),
            prevArrow:$('#two .slider-cover__btns.two .btns__left'),
            nextArrow:$('#two .slider-cover__btns.two .btns__right'),
        })
        $('.slider-cover.pk.three').slick({
            dots:true,
            slidesToShow: 1,
            slidesToScroll: 1,
            appendDots: $('#two .slider-cover__btns.three .slider-cover__dots.three'),
            prevArrow:$('#two .slider-cover__btns.three .btns__left'),
            nextArrow:$('#two .slider-cover__btns.three .btns__right'),
        })
    })
    if($('body').width() < 768){
        $(document).ready(function(){

            $('.slider-cover.mobile.one').slick({
                dots:true,
                slidesToShow: 1,
                slidesToScroll: 1,
                appendDots: $('#two-mobile .slider-cover__btns.one .slider-cover__dots.one'),
                prevArrow:$('#two-mobile .slider-cover__btns.one .btns__left'),
                nextArrow:$('#two-mobile .slider-cover__btns.one .btns__right'),
            })
            $('.slider-cover.mobile.two').slick({
                dots:true,
                slidesToShow: 1,
                slidesToScroll: 1,
                appendDots: $('#two-mobile .slider-cover__btns.two .slider-cover__dots.two'),
                prevArrow:$('#two-mobile .slider-cover__btns.two .btns__left'),
                nextArrow:$('#two-mobile .slider-cover__btns.two .btns__right'),
            })
            $('.slider-cover.mobile.three').slick({
                dots:true,
                slidesToShow: 1,
                slidesToScroll: 1,
                appendDots: $('#two-mobile .slider-cover__btns.three .slider-cover__dots.three'),
                prevArrow:$('#two-mobile .slider-cover__btns.three .btns__left'),
                nextArrow:$('#two-mobile .slider-cover__btns.three .btns__right'),
            })
        })
    }
</script>
