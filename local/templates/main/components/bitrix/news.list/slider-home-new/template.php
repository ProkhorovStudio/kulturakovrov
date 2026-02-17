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
    <section class="slideshow new">
        <div class="slideshow-inner">
            <div class="slides">
<div id="slider-top" class="slider-index">

	<?
    $i = 1;
    foreach ($arResult['ITEMS'] as $arItem):?>
        <div class="slide <?echo ($i == 1 ? 'is-active': '')?> ">
            <div class="slide-content">
                <div class="bottom caption">
                    <div class="left-block">
                        <div class="title"><?=$arItem['PREVIEW_TEXT']?></div>
                        <div class="text">
                            <p><?=$arItem['NAME']?></p>
                        </div>
                        <a href="<?=$arItem['PROPERTIES']['ATT_LINK']['VALUE']?>" class="btn d-none d-md-block">
                            <span class="btn-inner">Подробнее</span>
                        </a>
                    </div>

                </div>
            </div>
            <div class="image-container sl-<?=$i?>">
                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"  class="image" />
            </div>
        </div>
	<?
    $i++;
    endforeach?>

</div>

                <div class="arrows new-arr">
                    <div class="arrow prev">
          <span class="svg svg-arrow-left">
            <svg width="82" height="77" viewBox="0 0 82 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M51.3242 19.4082L70.67 38.754L51.3242 58.0997" stroke="#2C2C2C" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M1 38.9941L70.2759 38.9941" stroke="#2C2C2C" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
                    </div>
                    <div class="arrow next">
          <span class="svg svg-arrow-right">
            <svg width="82" height="77" viewBox="0 0 82 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M51.3242 19.4082L70.67 38.754L51.3242 58.0997" stroke="#2C2C2C" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M1 38.9941L70.2759 38.9941" stroke="#2C2C2C" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
                    </div>
                </div>

</div>



        </div>
    </section>
</main>


	
		