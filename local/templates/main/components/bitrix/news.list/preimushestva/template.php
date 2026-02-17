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

$list = ['one','two','three','four'];
?>
<div class="row">
    <?
    $i = 0;
    foreach($arResult["ITEMS"] as $arItem):?>
	<?

	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

    <div class="col-md-3 col-sm-6 col-6" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="bg-block <?=$list[$i]?>">
            <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
        </div>
        <div class="desc-block"><?=$arItem['~NAME']?></div>

        <?if($arItem['PROPERTIES']['ATT_LINK']['VALUE']):?>
            <a href="<?=$arItem['PROPERTIES']['ATT_LINK']['VALUE']?>" class="button-more">подробнее</a>
        <?endif;?>

    </div>
<?
$i++;
endforeach;?>
    <div class="line"></div>
</div>