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
<div class="row">
    <div class="offset-xl-6 col-xl-6 offset-lg-6 col-lg-6 offset-md-5 col-md-7 offset-sm-4 col-sm-8">
        <div class="slider-logo">
        <?foreach($arResult["ITEMS"] as $arItem):?>

            <div class="slider-logo__item" >
                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
            </div>
<?endforeach;?>
        </div>
    </div>
</div>
