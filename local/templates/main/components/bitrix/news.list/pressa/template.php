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
<style>
    .pressa_list img{
        box-shadow:0 8px 10px rgb(0 0 0 / 6%);
    }
    .pressa_list{
        margin-bottom:30px;
    }
    .pressa_list a{
        text-decoration: none;
    }
    .pressa_list a:hover .name_journal{
        color: #B7814B;
    }
    .pressa_list .description p{
        margin:0;
        line-height:1.2;
    }
    .pressa_list .description a{
        font-size: 14px;
        color: #c9c1c1;
        margin: 0;
        transition:all .3s;
    }
    .pressa_list .description a:hover{
        color:#000;
        text-decoration:underline;
    }
    .name_journal{
        margin-top: 21px;
        font-weight: 500;
        color: #000;
        font-size: 22px;
        transition: all .3s;
    }
    @media (max-width:400px){
        .name_designer{
            font-size: 16px;
        }
    }
</style>
<div class="row">
    <?foreach ($arResult['ITEMS'] as $arItem):?>
    <div class="col-6 col-md-3 pressa_list" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

        <a target="_blank"  href="<?=CFile::getPath($arItem['PROPERTIES']['ATT_PDF']['VALUE'])?>" title="<?=$arItem['NAME']?>"><img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['NAME']?>">
            <div class="name_journal"><?=$arItem['NAME']?></div></a>
        <div class="description"></div>

    </div>
    <?endforeach;?>

</div>


