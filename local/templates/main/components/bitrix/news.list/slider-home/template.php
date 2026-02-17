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
?>

<main class="main-content">
    <section class="slideshow">
        <div class="slideshow-inner">
            <div class="slides">
<div class="slider-index">
	<?
    $i = 1;
    foreach ($arResult['ITEMS'] as $arItem):?>
        <div class="slide <?echo ($i == 1 ? 'is-active': '')?> ">
            <div class="slide-content">
                <div class="caption">
                    <div class="title"><?=$arItem['PREVIEW_TEXT']?></div>
                    <div class="text">
                        <p><?=$arItem['NAME']?></p>
                    </div>
                    <a href="<?=$arItem['PROPERTIES']['ATT_LINK']['VALUE']?>" class="btn d-none d-md-block">
                        <span class="btn-inner">Подробнее</span>
                    </a>
                </div>
            </div>
            <a href="<?=$arItem['PROPERTIES']['ATT_LINK']['VALUE']?>" class="btn d-md-none">
                <span class="btn-inner">Подробнее</span>
            </a>
            <div class="image-container sl-<?=$i?>">
                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"  class="image" />
            </div>
        </div>
	<?
    $i++;
    endforeach?>
</div>
            </div>

            <div class="arrows">

                <div class="arrow next">
          <span class="svg svg-arrow-right">
            <svg width="170" height="159" viewBox="0 0 170 159" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M106.598 39.2861L146.811 79.4999L106.598 119.714" stroke="#2C2C2C" stroke-width="4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M2 80L146 80" stroke="#2C2C2C" stroke-width="4" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
          </span>
                </div>
            </div>
        </div>
    </section>
</main>


	
		