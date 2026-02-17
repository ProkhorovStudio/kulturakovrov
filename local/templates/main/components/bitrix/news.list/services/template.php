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
<?
$i = 0;
foreach($arResult["ITEMS"] as $arItem):?>
	<?
    $i++;
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <div class="col-lg-6" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="item-services item-<?=$i?>">
            <div class="item-services__bg">
                <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
            </div>
            <div class="item-services__title"><?=$arItem['NAME']?></div>
            <p class="item-services__desc"><?=$arItem['PREVIEW_TEXT']?></p>
            <div class="btn-more" data-call="<?=$arItem['PROPERTIES']['ATT_TEXT_MODAL']['VALUE']?>" data-counter="form-<?=$i?>"  ><?=$arItem['PROPERTIES']['ATT_TEXT_BTN']['VALUE']?></div>
        </div>
    </div>
<?endforeach;?>
</div>
