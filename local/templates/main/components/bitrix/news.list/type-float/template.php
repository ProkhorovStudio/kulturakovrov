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
function getEncodedFileUrl($fileId) {
    $filePath = CFile::GetPath($fileId);
    return dirname($filePath) . '/' . rawurlencode(basename($filePath));
}
?>

<section class="sthree">


                <div class="slider-float">
    <?php
    foreach($arResult["ITEMS"] as $arItem):
        $imageOne = getEncodedFileUrl($arItem['PROPERTIES']['ATT_IMAGE_1']['VALUE']);
        $imageTwo = getEncodedFileUrl($arItem['PROPERTIES']['ATT_IMAGE_2']['VALUE']);
        $imageThree = getEncodedFileUrl($arItem['PROPERTIES']['ATT_IMAGE_3']['VALUE']);
        ?>
        <div class="slider-float__item">
            <div class="image-one" style="background-image: url(<?=$imageOne?>)"></div>
            <div class="image-two" style="background-image: url(<?=$imageTwo?>)"></div>
            <div class="image-three" style="background-image: url(<?=$imageThree?>)"></div>
            <div class="descripton-slider">
                <p class="text"><?=$arItem['PREVIEW_TEXT']?></p>
                <p class="title-three"><?=$arItem['NAME']?></p>
                <a href="<?=$arItem['PROPERTIES']['ATT_LINK']['VALUE']?>" class="more-three">смотреть все</a>
            </div>
        </div>
    <?php endforeach; ?>
                </div>
</section>


