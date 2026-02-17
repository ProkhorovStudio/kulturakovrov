
<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;
use Bitrix\Main\Loader;
use Ldo\Develop\Hlblock;
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
//$this->addExternalCss('/bitrix/css/main/bootstrap.css');

$templateLibrary = array('popup', 'fx', 'ui.fonts.opensans');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$haveOffers = !empty($arResult['OFFERS']);

$templateData = [
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => [
        'ID' => $arResult['ID'],
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
    ],
];
if ($haveOffers)
{
    $templateData['ITEM']['OFFERS_SELECTED'] = $arResult['OFFERS_SELECTED'];
    $templateData['ITEM']['JS_OFFERS'] = $arResult['JS_OFFERS'];
}
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
    'STICKER_ID' => $mainId.'_sticker',
    'BIG_SLIDER_ID' => $mainId.'_big_slider',
    'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId.'_slider_cont',
    'OLD_PRICE_ID' => $mainId.'_old_price',
    'PRICE_ID' => $mainId.'_price',
    'DESCRIPTION_ID' => $mainId.'_description',
    'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
    'PRICE_TOTAL' => $mainId.'_price_total',
    'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
    'QUANTITY_ID' => $mainId.'_quantity',
    'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
    'QUANTITY_UP_ID' => $mainId.'_quant_up',
    'QUANTITY_MEASURE' => $mainId.'_quant_measure',
    'QUANTITY_LIMIT' => $mainId.'_quant_limit',
    'BUY_LINK' => $mainId.'_buy_link',
    'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
    'COMPARE_LINK' => $mainId.'_compare_link',
    'TREE_ID' => $mainId.'_skudiv',
    'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
    'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
    'OFFER_GROUP' => $mainId.'_set_group_',
    'BASKET_PROP_DIV' => $mainId.'_basket_prop',
    'SUBSCRIBE_LINK' => $mainId.'_subscribe',
    'TABS_ID' => $mainId.'_tabs',
    'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
    'TABS_PANEL_ID' => $mainId.'_tabs_panel'
);
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

if ($haveOffers)
{
    $actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer)
    {
        if ($offer['MORE_PHOTO_COUNT'] > 1)
        {
            $showSliderControls = true;
            break;
        }
    }
}
else
{
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = array();
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y')
{
    $skuDescription = false;
    foreach ($arResult['OFFERS'] as $offer)
    {
        if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '')
        {
            $skuDescription = true;
            break;
        }
    }
    $showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}
else
{
    $showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}

$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-default' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);
$productType = $arResult['PRODUCT']['TYPE'];

$arParams['MESS_BTN_BUY'] = $arParams['MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCE_CATALOG_BUY');
$arParams['MESS_BTN_ADD_TO_BASKET'] = $arParams['MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCE_CATALOG_ADD');

if ($arResult['MODULES']['catalog'] && $arResult['PRODUCT']['TYPE'] === ProductTable::TYPE_SERVICE)
{
    $arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE_SERVICE']
        ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE_SERVICE')
    ;
    $arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE_SERVICE']
        ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE_SERVICE')
    ;
}
else
{
    $arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE']
        ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE')
    ;
    $arParams['MESS_NOT_AVAILABLE'] = $arParams['MESS_NOT_AVAILABLE']
        ?: Loc::getMessage('CT_BCE_CATALOG_NOT_AVAILABLE')
    ;
}

$arParams['MESS_BTN_COMPARE'] = $arParams['MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCE_CATALOG_COMPARE');
$arParams['MESS_PRICE_RANGES_TITLE'] = $arParams['MESS_PRICE_RANGES_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_PRICE_RANGES_TITLE');
$arParams['MESS_DESCRIPTION_TAB'] = $arParams['MESS_DESCRIPTION_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION_TAB');
$arParams['MESS_PROPERTIES_TAB'] = $arParams['MESS_PROPERTIES_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_PROPERTIES_TAB');
$arParams['MESS_COMMENTS_TAB'] = $arParams['MESS_COMMENTS_TAB'] ?: Loc::getMessage('CT_BCE_CATALOG_COMMENTS_TAB');
$arParams['MESS_SHOW_MAX_QUANTITY'] = $arParams['MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCE_CATALOG_SHOW_MAX_QUANTITY');
$arParams['MESS_RELATIVE_QUANTITY_MANY'] = $arParams['MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['MESS_RELATIVE_QUANTITY_FEW'] = $arParams['MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCE_CATALOG_RELATIVE_QUANTITY_FEW');

$positionClassMap = array(
    'left' => 'product-item-label-left',
    'center' => 'product-item-label-center',
    'right' => 'product-item-label-right',
    'bottom' => 'product-item-label-bottom',
    'middle' => 'product-item-label-middle',
    'top' => 'product-item-label-top'
);

$discountPositionClass = 'product-item-label-big';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
    foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
    {
        $discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}

$labelPositionClass = 'product-item-label-big';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
    foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
    {
        $labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
    }
}
foreach ($arResult["OFFERS"]  as  $arOffer){
    $artikles[] = $arOffer['PROPERTIES']['ARTICLE']['VALUE'];
    $material[] = $arOffer['PROPERTIES']['Material']['VALUE'];
    $gamma = $arOffer['PROPERTIES']['Gamma']['VALUE'];
    $colors[] = $arOffer['PROPERTIES']['Tsvet'];
    $ploshad[] = $arOffer['PROPERTIES']['Ploshchad']['VALUE'];
    $method = $arOffer['PROPERTIES']['Method']['VALUE'];
    $width = $arOffer['PROPERTIES']['ATT_WIDTH']['VALUE'];
    $height = $arOffer['PROPERTIES']['ATT_HEIGHT']['VALUE'];
}

if($width && $height){
    $sqw = $width*$height/10000;
}

if(Loader::IncludeModule('ldo.develop')){

    if(is_array($colors[0]['VALUE'])){
        $colorsName = Hlblock::getNameByIds($colors[0]['VALUE']);
    }

    if(is_array($colors[0]['VALUE'])){
        $colorsImage = Hlblock::getImageByIds($colors[0]['VALUE']);
    }

}
$isMobile=\Bitrix\Main\Loader::includeModule('conversion') && ($md=new \Bitrix\Conversion\Internals\MobileDetect) && $md->isMobile();


$i = 1;
foreach ($actualItem['MORE_PHOTO'] as $photo){

    $photoGallery[] = CFile::ResizeImageGet($photo['ID'], array('width'=>1280, 'height'=>1280), BX_RESIZE_IMAGE_PROPORTIONAL, true,[],false,70);

    $resizeMiniMob = CFile::ResizeImageGet($photo['ID'], array('width'=>200, 'height'=>200), BX_RESIZE_IMAGE_PROPORTIONAL, true,[],false,70);

    if($i == 1){
        $resizeImg = CFile::ResizeImageGet($photo['ID'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true,[],false,80);
    }
    else{
        $resizeImg = CFile::ResizeImageGet($photo['ID'], array('width'=>500, 'height'=>500), BX_RESIZE_IMAGE_PROPORTIONAL, true,[],false,80);
    }
    $mobilePhotos[] = $resizeMiniMob['src'];
    $pkPhotos[] = $resizeImg['src'];
    unset($resizeImg);
    $i++;
}

?>

<?if($USER->IsAdmin()):?>

    <?php

    //$id = 9747;
    //$newFileName = "kover-blank-2968-1.jpg";

    //echo "<pre>";
    //print_r($actualItem['MORE_PHOTO']);

    //echo "</pre>";
    //$connection = \Bitrix\Main\Application::getConnection();
    //$connection->query('UPDATE b_file SET FILE_NAME = "'.$newFileName.'" WHERE ID = '.$id);
    //print_r($connection);

    ?>
<?endif;?>


<div class="bx-catalog-element bx-<?=$arParams['TEMPLATE_THEME']?>" id="<?=$itemIds['ID']?>"
     itemscope itemtype="http://schema.org/Product">
    <div class="row">
        <a href="javascript:(print());" class="print d-none d-md-block">Печать PDF</a>

        <script>
            window.sliderImages = <?= json_encode($actualItem['MORE_PHOTO'])?>;
        </script>
        <div class="col-md-6 col-sm-12">
            <?if($isMobile):?>
                <div class="mobile-top  d-md-none" style="margin-bottom:20px">
                    <div class="artikul">Артикул: <span data-entity="artikul"><?=$artikles[0];?></span></div>
                    <div class="product-title">
                        <h1 class="bx-title"><?if($artikles[0] != 1341 ):?>Ковер <?endif;?><?=$name?></h1>
                    </div>

                    <div class="product-after-name">
                        <?if($method == 'Ручная работа'):?>
                            <p>Ручная работа, <span class="material"><?=$material[0]?></span>.</p>
                        <?else:?>
                            <p><span class="material"><?=$material[0]?></span>.</p>
                        <?endif;?>

                        <?if($colorsName):?>
                            <p class="colors">
                                <?=implode(',&nbsp ', $colorsName); ?>
                            </p>
                        <?endif;?>
                    </div>
                    <?if($arResult['DETAIL_TEXT'] != ''):?>
                        <div class="button-more-desc">Полное описание</div>
                    <?endif;?>
                </div>
            <?endif;?>
            <?
            $isMobile=\Bitrix\Main\Loader::includeModule('conversion') && ($md=new \Bitrix\Conversion\Internals\MobileDetect) && $md->isMobile();
            $imageModal = $pkPhotos[0];
            ?>
            <?if($isMobile):?>
                <div class="first-element-slider">
                    <?foreach ($pkPhotos as $key=> $image):?>
                        <div class="first-image">
                            <a data-fancybox="mobile-gallery" href="<?=$photoGallery[$key]['src']?>">
                                <img src="<?=$image?>" alt="<?=$name?>">
                            </a>
                        </div>
                    <?endforeach?>
                </div>
            <?else:?>
                <div class="first-image">
                    <a data-fancybox="pk-gallery" href="<?=$photoGallery[0]['src']?>">
                        <img src="<?=$pkPhotos[0]?>" alt="<?=$name?>">
                    </a>

                </div>
                <?
                unset($pkPhotos[0],$photoGallery[0]);
                ?>
            <?endif;?>



            <?if($isMobile):?>
                <div class="slider-element-mobile">
                    <?foreach ($mobilePhotos as $key => $image):?>
                        <div class="slider-element-mobile__item">
                            <img src="<?=$image?>" alt="<?=$name?>">
                        </div>
                    <?endforeach?>
                </div>
            <?else:?>
                <div class="other-images">
                    <?foreach ($pkPhotos as $key=>$image):?>
                        <div class="other-images__item">
                            <a data-fancybox="pk-gallery" href="<?=$photoGallery[$key]['src']?>">
                                <img src="<?=$image?>" alt="<?=$name?>">
                            </a>
                        </div>
                    <?endforeach?>
                </div>
            <?endif?>

        </div>
        <?if(!$isMobile):?>
        <div class="col-md-6 col-sm-12">
            <div class="card-product">
                <div class="pk-top d-none d-md-block">
                    <div class="artikul">Артикул: <span data-entity="artikul"><?=$artikles[0];?></span></div>
                    <div class="product-title">
                        <h1 class="bx-title"><?if($artikles[0] != 1341 ):?>Ковер <?endif;?><?=$name?></h1>
                    </div>
                    <div class="product-after-name">

                        <?if($method == 'Ручная работа'):?>
                            <p>Ручная работа, <span class="material"><?=$material[0]?></span>.</p>
                        <?else:?>
                            <p><span class="material"><?=$material[0]?></span>.</p>
                        <?endif;?>

                        <?if($colorsName):?>
                            <p class="colors">
                                <?=implode(',&nbsp ', $colorsName); ?>
                            </p>
                        <?endif;?>
                    </div>
                    <?if($arResult['DETAIL_TEXT'] != ''):?>
                        <div class="button-more-desc">Полное описание</div>
                    <?endif;?>
                </div>
                <?endif?>

                <div class="properties-top">

                    <div class="line">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="properties-top__size">
                                    <?php

                                    foreach ($arParams['PRODUCT_INFO_BLOCK_ORDER'] as $blockName)
                                    {
                                        $arrProps = [];
                                        $arrProps  = $arResult['DISPLAY_PROPERTIES'];
                                        switch ($blockName)
                                        {
                                            case 'sku':
                                                if ($haveOffers && !empty($arResult['OFFERS_PROP']))
                                                {
                                                    ?>
                                                    <div id="<?=$itemIds['TREE_ID']?>">
                                                        <?php
                                                        foreach ($arResult['SKU_PROPS'] as $skuProperty)
                                                        {
                                                            if (!isset($arResult['OFFERS_PROP'][$skuProperty['CODE']]))
                                                                continue;

                                                            $propertyId = $skuProperty['ID'];
                                                            $skuProps[] = array(
                                                                'ID' => $propertyId,
                                                                'SHOW_MODE' => $skuProperty['SHOW_MODE'],
                                                                'VALUES' => $skuProperty['VALUES'],
                                                                'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
                                                            );
                                                            ?>
                                                            <div  data-entity="sku-line-block">
                                                                <div class="product-title-prop"><?=htmlspecialcharsEx($skuProperty['NAME'])?>, см</div>
                                                                <ul class="product-item-scu-item-list">
                                                                    <?php
                                                                    foreach ($skuProperty['VALUES'] as &$value)
                                                                    {
                                                                        $value['NAME'] = htmlspecialcharsbx($value['NAME']);?>

                                                                        <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                                                            data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                                            data-onevalue="<?=$value['ID']?>">

                                                                            <?=$value['NAME']?>

                                                                        </li>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <?php
                                                }

                                                break;


                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6"><div class="properties-top__sq">
                                    <span class="product-title-prop">Площадь</span>
                                    <span class="ploshad"><?=$ploshad[0]?></span>

                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="line">
                        <div class="row">
                            <div class="col-md-6">

                                <?if($colorsImage):?>
                                    <div class="properties-top__colors">
                                        <span class="product-title-prop">Цвет</span>
                                        <div class="color-images">
                                            <?php foreach ($colorsImage as $key => $image):?>
                                                <img alt="<?=$key?>" src="<?=$image?>" >
                                            <?php endforeach?>

                                        </div>
                                    </div>
                                <?endif;?>
                            </div>
                            <div class="col-md-6">
                                <div class="properties-top__gamma">
                                    <span class="product-title-prop">Гамма</span>
                                    <span class="gamma"><?=$gamma[0]?></span>
                                </div>
                            </div>
                        </div>


                    </div>

                    <?
                    function removeArticleFromName($productName) {
                        // Удаляем артикул в конце названия (последнее слово, состоящее из букв и цифр)
                        $pattern = '/\s*[A-Za-z0-9]+\s*$/';
                        $result = preg_replace($pattern, '', $productName);

                        // Убираем возможные двойные пробелы и пробелы в начале/конце
                        $result = trim(preg_replace('/\s+/', ' ', $result));

                        return $result;
                    }
                    $nameModal = removeArticleFromName($name);


                    function customRound($number) {
                        if ($number > 100000) {
                            return round($number / 1000) * 1000;
                        } else {
                            return floor($number / 10000) * 10000;
                        }
                    }
                    ?>

                </div>
                <?
                $visiblePrice = true;

                if($price['UNROUND_BASE_PRICE'] == 0){
                    $visiblePrice = false;
                };



                if($price['BASE_PRICE'] > 900000 && isset($sqw)){
                    $newPrice = $price['BASE_PRICE'] / $sqw;
                    $roundPr = customRound($newPrice );

                    if($USER->isAdmin()){
                       // print_r($newPrice);
                       // print_r($roundPr);
                    }





                    $priceNew = number_format($roundPr,0,'', ' ');


                    $price['PRINT_RATIO_PRICE'] = 'от '.$priceNew;
                }

                ?>
                <div class="price-block">
                    <?if($sqw):?>
                        <input class="sqw" type="hidden" name="SQW" value="<?=$sqw?>">
                    <?endif?>

                    <div class="row">
                        <div class="col-lg-5 col-xl-6 col-sm-12 order-sm-1 order-2">

                            <div class="price-block__price" id="<?=$itemIds['PRICE_ID']?>">
                                <?if($visiblePrice):?>
                                    <?= $price['PRINT_RATIO_PRICE'];?>
                                <?endif;?>
                            </div>

                        </div>
                        <div class="col-lg-7 col-xl-6 col-sm-12 order-sm-2 order-1">
                            <div class="price-block__info">
                                <div class="avaliable">В наличии</div>
                                <div class="vivoz ">Самовывоз: <span>Сегодня</span> (Кутузовский пр-т, 22)</div>
                                <div class="delivery">Доставка: <span>1-5 дней</span> <span  class="more_delivery">Подробнее</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="button-block detail-cart">

                    <div id="<?=$itemIds['BASKET_ACTIONS_ID']?>" style="display: <?=($actualItem['CAN_BUY'] ? '' : 'none')?>;">
                        <?
                        foreach ($arResult["OFFERS"] as $arOffer) {
                            $allItemOffersIds[] = $arOffer['ID'];
                        }

                        if($allItemOffersIds && $arResult['IS_CART']){
                            $IsSkusInBasket = array_intersect($arResult['IS_CART'],$allItemOffersIds);
                        }

                        ?>

                        <?if($IsSkusInBasket):?>
                            <a href="/personal/cart/" class="inCartCard">В примерке</a>
                        <?else:?>



                            <?if($price['BASE_PRICE'] > 900000):?>
                                <span data-counter="form_praice" img="<?=$imageModal?>" artikle="<?=$artikles[0]?>" title="<?=$nameModal?>" class="inCardNotPrice" href="javascript:void(0)" rel="nofollow">Узнать цену</span>


                            <?else:?>
                                <?if($visiblePrice):?>
                                    <a onclick="ym(100102212,'reachGoal','webit_add_to_fitting');"  class="addCart" id="<?=$itemIds['ADD_BASKET_LINK']?>" href="javascript:void(0);">
                                        <svg width="17" height="19" viewBox="0 0 17 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.79919 6.13679V5.36079C4.79919 3.56079 6.24719 1.79279 8.04719 1.62479C10.1912 1.41679 11.9992 3.10479 11.9992 5.20879V6.31279M5.99908 17.6008H10.7991C14.0151 17.6008 14.5911 16.3128 14.7591 14.7448L15.3591 9.94476C15.5751 7.99276 15.0151 6.40076 11.5991 6.40076H5.19908C1.78308 6.40076 1.22308 7.99276 1.43908 9.94476L2.03908 14.7448C2.20708 16.3128 2.78308 17.6008 5.99908 17.6008Z" stroke="#3F2429" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M11.1946 9.60156H11.2018M5.59375 9.60156H5.60094" stroke="#3F2429" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Добавить в примерку
                                    </a>
                                    <a class="inCartCard" style="display: none" href="/personal/cart/">В примерке</a>
                                <?else:?>
                                    <span data-counter="form_praice" img="<?=$imageModal?>" artikle="<?=$artikles[0]?>" title="<?=$nameModal?>"  class="inCardNotPrice" data-call="getPrice">Узнать цену</span>
                                <?endif;?>

                            <?endif;?>



                        <?endif;?>


                    </div>
                    <div id="<?=$itemIds['NOT_AVAILABLE_MESS']?>" style="display: <?=(!$actualItem['CAN_BUY'] ? '' : 'none')?>;">
                        <span data-counter="form_praice" img="<?=$imageModal?>" artikle="<?=$artikles[0]?>" title="<?=$nameModal?>" class="inCardNotPrice" href="javascript:void(0)" rel="nofollow">Узнать цену</span>
                    </div>
                </div>
                <div class="primerka-description">
                    <div class="primerka-description__top">
                        <p>Заказ примерки</p>

                    </div>
                    <div class="primerka-description__bottom">
                        <p>Мы подберём к этому ковру ещё несколько подходящих моделей и доставим на примерку. Вы сможете сравнить их в интерьере и выбрать лучший вариант.</p>

                    </div>
                </div>
                <div class="manager-block">
                    <div class="manager-block__photo"></div>
                    <div class="manager-block__description">
                        <div class="manager-block__description-title">Ваш личный эксперт</div>
                        <div class="manager-block__description--after-title">Персональная помощь в удобном для вас формате</div>
                        <div class="manager-block__description-info">
                            <a href="tel:+74953203241">+7 (495) 320-32-41</a>

                        </div>
                        <div class="manager-block__description-buttons">
                            <span data-call="" artikle="<?=$artikles[0]?>" title="<?=$nameModal?>" data-counter="form_5">Перезвоните мне</span>
                            <a class="tg-chat" href="https://t.me/KULTURAKOVROV_bot" target="_blank">Чат в телеграм</a>
                            <a class="wh-chat" href="https://api.whatsapp.com/send/?phone=79167195666" target="_blank">Чат в WhatsApp</a>

                        </div>

                    </div>
                </div>
                <?if($arResult['DETAIL_TEXT'] != ''):?>
                    <div class="description-block">
                        <div class="description-block__title">
                            описание
                        </div>
                        <div class="description-block__info">
                            <?php
                            if (
                                $arResult['PREVIEW_TEXT'] != ''
                                && (
                                    $arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
                                    || ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
                                )
                            )
                            {
                                echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : '<p>'.$arResult['PREVIEW_TEXT'].'</p>';
                            }

                            if ($arResult['DETAIL_TEXT'] != '')
                            {
                                echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : '<p>'.$arResult['DETAIL_TEXT'].'</p>';
                            }
                            ?>
                        </div>

                    </div>
                <?endif;?>

                <div class="options-block">
                    <div class="options-block__title">характеристики</div>
                    <div class="options-block__info">
                        <div  data-entity="tab-container" data-value="properties">
                            <?php

                            ?>
                            <dl>
                                <?php

                                foreach ($arResult['DISPLAY_PROPERTIES'] as $property)
                                {
                                    ?>
                                    <dt><?=$property['NAME']?></dt>
                                    <dd><?=(
                                        is_array($property['DISPLAY_VALUE'])
                                            ? implode(' / ', $property['DISPLAY_VALUE'])
                                            : $property['DISPLAY_VALUE']
                                        )?>
                                    </dd>
                                    <?php
                                }
                                unset($property);
                                ?>
                            </dl>
                            <?php


                            if ($arResult['SHOW_OFFERS_PROPS'])
                            {
                                ?>
                                <dl class="" id="<?=$itemIds['DISPLAY_PROP_DIV']?>"></dl>
                                <?php
                            }
                            ?>
                        </div>


                    </div>
                </div>

                <div class="block-tags-product">
                    <p class="block-tags-product__title">Другие ковры с похожими параметрами</p>
                    <?

                    $productId = $arResult['ID'];
                    // Получаем все разделы товара с иерархией
                    $dbSections = CIBlockElement::GetElementGroups(
                        $productId,
                        false, // включая неактивные разделы
                        array('ID', 'IBLOCK_SECTION_ID', 'NAME', 'CODE')
                    );

                    $sectionIds = array();
                    while ($arSection = $dbSections->Fetch()) {
                        $sectionIds[] = $arSection['ID'];

                    }

                    if (!empty($sectionIds)) {


                        // Получаем полную информацию о разделах с родителями
                        $dbRes = CIBlockSection::GetList(
                            array(),
                            array(
                                'ID' => $sectionIds,
                                'CHECK_PERMISSIONS' => 'N'
                            ),
                            true, // включая полную иерархию
                            array('ID', 'NAME', 'SECTION_ID', 'CODE', 'IBLOCK_SECTION_ID','IBLOCK_SECTION_NAME')
                        );

                        $allowedParents = [4, 13,15];
                        $foundSubsections = array();

                        while ($arSubSection = $dbRes->GetNext()) {
                            if (in_array($arSubSection['IBLOCK_SECTION_ID'], $allowedParents)) {
                                $foundSubsections[] = $arSubSection;
                            }
                        }
                    }

                    ?>
                    <ul>

                        <?foreach ($foundSubsections as $tags):?>
                            <?if($tags['IBLOCK_SECTION_ID'] == 4):?>
                                <li><a target="_blank" href="/catalog/style/<?=$tags['CODE']?>/"><?=$tags['NAME']?></a></li>
                            <?endif;?>
                            <?if($tags['IBLOCK_SECTION_ID'] == 13):?>
                                <li><a target="_blank" href="/catalog/square/<?=$tags['CODE']?>/"><?=$tags['NAME']?></a></li>
                            <?endif;?>
                            <?if($tags['IBLOCK_SECTION_ID'] == 15):?>
                                <li><a target="_blank" href="/catalog/color/<?=$tags['CODE']?>/"><?=$tags['NAME']?></a></li>
                            <?endif;?>
                        <?endforeach?>
                    </ul>
                </div>

            </div>

        </div>
    </div>
</div>
<?php

if($USER->IsAdmin()):?>


<?php
endif;
?>
<div class="row">
    <div class="col-lg-12">
        <p class="title-recomendation">рекомендации для вас</p>
    </div>
    <div class="col-lg-12">
        <div class="block-recomendation">
            <?


            $arFilter = [
                'IBLOCK_ID' => $arParams['ID'], // ID инфоблока предложений
                'PROPERTY_Tsvet' => $arResult['OFFERS'][0]['PROPERTIES']['Tsvet']['VALUE'],
                'CATALOG_AVAILABLE' => 'Y'
            ];

            $rsOffers = CIBlockElement::GetList(
                [],
                $arFilter,
                false,
                false,
                ['ID', 'PROPERTY_CML2_LINK']
            );

            $productIds = [];

            while ($arOffer = $rsOffers->Fetch()) {
                if ($arOffer['PROPERTY_CML2_LINK_VALUE']) {
                    $productIds[] = $arOffer['PROPERTY_CML2_LINK_VALUE'];
                }
            }

            // 2. Удаляем дубликаты и текущий товар
            $productIds = array_unique($productIds);

            if ($arResult['ID']) {
                $productIds = array_diff($productIds, [$arResult['ID']]);
            }

            if($price['BASE_PRICE'] > 0){
                $prevPrice = $price['BASE_PRICE'] - 100000;
                $nextPrice = $price['BASE_PRICE'] + 100000;

                if($prevPrice > 0 && $nextPrice > 0) {
                    $GLOBALS['colorFilter'][] = [
                        "LOGIC" => "AND",
                        ['>PRICE' => $prevPrice],
                        ['<PRICE' => $nextPrice ],
                    ];
                }
            }
            // 3. Устанавливаем фильтр для catalog.top
            $GLOBALS['colorFilter'][] = [
                'ID' => $productIds ? $productIds : [0],
                'CATALOG_AVAILABLE' => 'Y'
            ];

            if($productIds){
                $APPLICATION->IncludeComponent(
                    "bitrix:catalog.top",
                    "slider-recomendation",
                    array(
                        "ACTION_VARIABLE" => "action",
                        "ADD_PICT_PROP" => "MORE_PHOTO",
                        "ADD_PROPERTIES_TO_BASKET" => "Y",
                        "ADD_TO_BASKET_ACTION" => "ADD",
                        "BASKET_URL" => "/personal/basket.php",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
                        "COMPATIBLE_MODE" => "N",
                        "CONVERT_CURRENCY" => "N",
                        "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                        "DETAIL_URL" => "",
                        "DISPLAY_COMPARE" => "N",
                        "ELEMENT_COUNT" => "12",
                        "ELEMENT_SORT_FIELD" => "sort",
                        "ELEMENT_SORT_FIELD2" => "id",
                        "ELEMENT_SORT_ORDER" => "asc",
                        "ELEMENT_SORT_ORDER2" => "desc",
                        "ENLARGE_PRODUCT" => "STRICT",
                        "PROPERTY_CODE" => array("Tsvet"), // Указываем свойство Tsvet
                        "OFFERS_PROPERTY_CODE" => array("Tsvet"), // Свойство в предложениях
                        "FILTER_NAME" => "colorFilter",
                        "HIDE_NOT_AVAILABLE" => "L",
                        "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                        "IBLOCK_ID" => "1",
                        "IBLOCK_TYPE" => "main",
                        "LABEL_PROP" => array(
                        ),
                        "LINE_ELEMENT_COUNT" => "4",
                        "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                        "MESS_BTN_BUY" => "Купить",
                        "MESS_BTN_COMPARE" => "Сравнить",
                        "MESS_BTN_DETAIL" => "Подробнее",
                        "MESS_NOT_AVAILABLE" => "Нет в наличии",
                        "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                        "OFFERS_FIELD_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "OFFERS_LIMIT" => "5",
                        "OFFERS_SORT_FIELD" => "sort",
                        "OFFERS_SORT_FIELD2" => "id",
                        "OFFERS_SORT_ORDER" => "asc",
                        "OFFERS_SORT_ORDER2" => "desc",
                        "PARTIAL_PRODUCT_PROPERTIES" => "N",
                        "PRICE_CODE" => array(
                            0 => "BASE",
                        ),
                        "PRICE_VAT_INCLUDE" => "Y",
                        "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                        "PRODUCT_DISPLAY_MODE" => "Y",
                        "PRODUCT_ID_VARIABLE" => "id",
                        "PRODUCT_PROPS_VARIABLE" => "prop",
                        "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                        "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                        "PRODUCT_SUBSCRIPTION" => "Y",
                        "PROPERTY_CODE_MOBILE" => array(
                            0 => "MORE_PHOTO",
                        ),
                        "ROTATE_TIMER" => "30",
                        "SECTION_URL" => "",
                        "SEF_MODE" => "Y",
                        "SHOW_CLOSE_POPUP" => "N",
                        "SHOW_DISCOUNT_PERCENT" => "N",
                        "SHOW_MAX_QUANTITY" => "N",
                        "SHOW_OLD_PRICE" => "N",
                        "SHOW_PAGINATION" => "Y",
                        "SHOW_PRICE_COUNT" => "1",
                        "SHOW_SLIDER" => "Y",
                        "SLIDER_INTERVAL" => "3000",
                        "SLIDER_PROGRESS" => "N",
                        "TEMPLATE_THEME" => "blue",
                        "USE_ENHANCED_ECOMMERCE" => "Y",
                        "USE_FILTER" => "Y",
                        "USE_PRICE_COUNT" => "N",
                        "USE_PRODUCT_QUANTITY" => "N",
                        "VIEW_MODE" => "SLIDER",
                        "COMPONENT_TEMPLATE" => "wish-products",
                        "DATA_LAYER_NAME" => "dataLayer",
                        "BRAND_PROPERTY" => "-",
                        "SEF_RULE" => "",
                        "OFFER_ADD_PICT_PROP" => "-"
                    ),
                    false
                );
            }


            ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php
        if ($haveOffers)
        {
            if ($arResult['OFFER_GROUP'])
            {
                foreach ($arResult['OFFER_GROUP_VALUES'] as $offerId)
                {
                    ?>
                    <span id="<?=$itemIds['OFFER_GROUP'].$offerId?>" style="display: none;">
								<?php
                                $APPLICATION->IncludeComponent(
                                    'bitrix:catalog.set.constructor',
                                    '.default',
                                    array(
                                        'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                                        'IBLOCK_ID' => $arResult['OFFERS_IBLOCK'],
                                        'ELEMENT_ID' => $offerId,
                                        'PRICE_CODE' => $arParams['PRICE_CODE'],
                                        'BASKET_URL' => $arParams['BASKET_URL'],
                                        'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
                                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                                        'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
                                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                                        'CURRENCY_ID' => $arParams['CURRENCY_ID']
                                    ),
                                    $component,
                                    array('HIDE_ICONS' => 'Y')
                                );
                                ?>
							</span>
                    <?php
                }
            }
        }
        else
        {
            if ($arResult['MODULES']['catalog'] && $arResult['OFFER_GROUP'])
            {
                $APPLICATION->IncludeComponent(
                    'bitrix:catalog.set.constructor',
                    '.default',
                    array(
                        'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                        'ELEMENT_ID' => $arResult['ID'],
                        'PRICE_CODE' => $arParams['PRICE_CODE'],
                        'BASKET_URL' => $arParams['BASKET_URL'],
                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                        'TEMPLATE_THEME' => $arParams['~TEMPLATE_THEME'],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID']
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
            }
        }
        ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php
        if ($arResult['CATALOG'] && $actualItem['CAN_BUY'] && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
        {
            $APPLICATION->IncludeComponent(
                'bitrix:sale.prediction.product.detail',
                '.default',
                array(
                    'BUTTON_ID' => $showBuyBtn ? $itemIds['BUY_LINK'] : $itemIds['ADD_BASKET_LINK'],
                    'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                    'POTENTIAL_PRODUCT_TO_BUY' => array(
                        'ID' => $arResult['ID'] ?? null,
                        'MODULE' => $arResult['MODULE'] ?? 'catalog',
                        'PRODUCT_PROVIDER_CLASS' => $arResult['~PRODUCT_PROVIDER_CLASS'] ?? \Bitrix\Catalog\Product\Basket::getDefaultProviderName(),
                        'QUANTITY' => $arResult['QUANTITY'] ?? null,
                        'IBLOCK_ID' => $arResult['IBLOCK_ID'] ?? null,

                        'PRIMARY_OFFER_ID' => $arResult['OFFERS'][0]['ID'] ?? null,
                        'SECTION' => array(
                            'ID' => $arResult['SECTION']['ID'] ?? null,
                            'IBLOCK_ID' => $arResult['SECTION']['IBLOCK_ID'] ?? null,
                            'LEFT_MARGIN' => $arResult['SECTION']['LEFT_MARGIN'] ?? null,
                            'RIGHT_MARGIN' => $arResult['SECTION']['RIGHT_MARGIN'] ?? null,
                        ),
                    )
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );
        }

        if ($arResult['CATALOG'] && $arParams['USE_GIFTS_DETAIL'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
        {
            ?>
            <div data-entity="parent-container">
                <?php
                if (!isset($arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
                {
                    ?>
                    <div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
                        <?=($arParams['GIFTS_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFT_BLOCK_TITLE_DEFAULT'))?>
                    </div>
                    <?php
                }

                CBitrixComponent::includeComponentClass('bitrix:sale.products.gift');
                $APPLICATION->IncludeComponent(
                    'bitrix:sale.products.gift',
                    '.default',
                    array(
                        'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                        'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                        'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],

                        'PRODUCT_ROW_VARIANTS' => "",
                        'PAGE_ELEMENT_COUNT' => 0,
                        'DEFERRED_PRODUCT_ROW_VARIANTS' => \Bitrix\Main\Web\Json::encode(
                            SaleProductsGiftComponent::predictRowVariants(
                                $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
                                $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT']
                            )
                        ),
                        'DEFERRED_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],

                        'SHOW_DISCOUNT_PERCENT' => $arParams['GIFTS_SHOW_DISCOUNT_PERCENT'],
                        'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
                        'SHOW_OLD_PRICE' => $arParams['GIFTS_SHOW_OLD_PRICE'],
                        'PRODUCT_DISPLAY_MODE' => 'Y',
                        'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],
                        'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
                        'SLIDER_INTERVAL' => $arParams['GIFTS_SLIDER_INTERVAL'] ?? '',
                        'SLIDER_PROGRESS' => $arParams['GIFTS_SLIDER_PROGRESS'] ?? '',

                        'TEXT_LABEL_GIFT' => $arParams['GIFTS_DETAIL_TEXT_LABEL_GIFT'],

                        'LABEL_PROP_'.$arParams['IBLOCK_ID'] => array(),
                        'LABEL_PROP_MOBILE_'.$arParams['IBLOCK_ID'] => array(),
                        'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],

                        'ADD_TO_BASKET_ACTION' => ($arParams['ADD_TO_BASKET_ACTION'] ?? ''),
                        'MESS_BTN_BUY' => $arParams['~GIFTS_MESS_BTN_BUY'],
                        'MESS_BTN_ADD_TO_BASKET' => $arParams['~GIFTS_MESS_BTN_BUY'],
                        'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
                        'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
                        'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
                        'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'],
                        'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
                        'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
                        'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],

                        'SHOW_PRODUCTS_'.$arParams['IBLOCK_ID'] => 'Y',
                        'PROPERTY_CODE_'.$arParams['IBLOCK_ID'] => [],
                        'PROPERTY_CODE_MOBILE'.$arParams['IBLOCK_ID'] => [],
                        'PROPERTY_CODE_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
                        'OFFER_TREE_PROPS_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFER_TREE_PROPS'],
                        'CART_PROPERTIES_'.$arResult['OFFERS_IBLOCK'] => $arParams['OFFERS_CART_PROPERTIES'],
                        'ADDITIONAL_PICT_PROP_'.$arParams['IBLOCK_ID'] => ($arParams['ADD_PICT_PROP'] ?? ''),
                        'ADDITIONAL_PICT_PROP_'.$arResult['OFFERS_IBLOCK'] => ($arParams['OFFER_ADD_PICT_PROP'] ?? ''),

                        'HIDE_NOT_AVAILABLE' => 'Y',
                        'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
                        'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
                        'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
                        'PRICE_CODE' => $arParams['PRICE_CODE'],
                        'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
                        'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'BASKET_URL' => $arParams['BASKET_URL'],
                        'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
                        'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
                        'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
                        'USE_PRODUCT_QUANTITY' => 'N',
                        'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                        'POTENTIAL_PRODUCT_TO_BUY' => array(
                            'ID' => $arResult['ID'] ?? null,
                            'MODULE' => $arResult['MODULE'] ?? 'catalog',
                            'PRODUCT_PROVIDER_CLASS' => $arResult['~PRODUCT_PROVIDER_CLASS'] ?? \Bitrix\Catalog\Product\Basket::getDefaultProviderName(),
                            'QUANTITY' => $arResult['QUANTITY'] ?? null,
                            'IBLOCK_ID' => $arResult['IBLOCK_ID'] ?? null,

                            'PRIMARY_OFFER_ID' => $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'] ?? null,
                            'SECTION' => array(
                                'ID' => $arResult['SECTION']['ID'] ?? null,
                                'IBLOCK_ID' => $arResult['SECTION']['IBLOCK_ID'] ?? null,
                                'LEFT_MARGIN' => $arResult['SECTION']['LEFT_MARGIN'] ?? null,
                                'RIGHT_MARGIN' => $arResult['SECTION']['RIGHT_MARGIN'] ?? null,
                            ),
                        ),

                        'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                        'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                        'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
                ?>
            </div>
            <?php
        }

        if ($arResult['CATALOG'] && $arParams['USE_GIFTS_MAIN_PR_SECTION_LIST'] == 'Y' && \Bitrix\Main\ModuleManager::isModuleInstalled('sale'))
        {
            ?>
            <div data-entity="parent-container">
                <?php
                if (!isset($arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE'] !== 'Y')
                {
                    ?>
                    <div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
                        <?=($arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'] ?: Loc::getMessage('CT_BCE_CATALOG_GIFTS_MAIN_BLOCK_TITLE_DEFAULT'))?>
                    </div>
                    <?php
                }

                $APPLICATION->IncludeComponent(
                    'bitrix:sale.gift.main.products',
                    '.default',
                    array(
                        'CUSTOM_SITE_ID' => $arParams['CUSTOM_SITE_ID'] ?? null,
                        'PAGE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
                        'LINE_ELEMENT_COUNT' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT'],
                        'HIDE_BLOCK_TITLE' => 'Y',
                        'BLOCK_TITLE' => $arParams['GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE'],

                        'OFFERS_FIELD_CODE' => $arParams['OFFERS_FIELD_CODE'],
                        'OFFERS_PROPERTY_CODE' => $arParams['OFFERS_PROPERTY_CODE'],

                        'AJAX_MODE' => $arParams['AJAX_MODE'] ?? '',
                        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],

                        'ELEMENT_SORT_FIELD' => 'ID',
                        'ELEMENT_SORT_ORDER' => 'DESC',
                        'FILTER_NAME' => 'searchFilter',
                        'SECTION_URL' => $arParams['SECTION_URL'],
                        'DETAIL_URL' => $arParams['DETAIL_URL'],
                        'BASKET_URL' => $arParams['BASKET_URL'],
                        'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
                        'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
                        'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],

                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                        'CACHE_TIME' => $arParams['CACHE_TIME'],

                        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                        'SET_TITLE' => $arParams['SET_TITLE'],
                        'PROPERTY_CODE' => $arParams['PROPERTY_CODE'],
                        'PRICE_CODE' => $arParams['PRICE_CODE'],
                        'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
                        'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],

                        'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
                        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
                        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
                        'HIDE_NOT_AVAILABLE' => 'Y',
                        'HIDE_NOT_AVAILABLE_OFFERS' => 'Y',
                        'TEMPLATE_THEME' => ($arParams['TEMPLATE_THEME'] ?? ''),
                        'PRODUCT_BLOCKS_ORDER' => $arParams['GIFTS_PRODUCT_BLOCKS_ORDER'],

                        'SHOW_SLIDER' => $arParams['GIFTS_SHOW_SLIDER'],
                        'SLIDER_INTERVAL' => $arParams['GIFTS_SLIDER_INTERVAL'] ?? '',
                        'SLIDER_PROGRESS' => $arParams['GIFTS_SLIDER_PROGRESS'] ?? '',

                        'ADD_PICT_PROP' => ($arParams['ADD_PICT_PROP'] ?? ''),
                        'LABEL_PROP' => ($arParams['LABEL_PROP'] ?? ''),
                        'LABEL_PROP_MOBILE' => ($arParams['LABEL_PROP_MOBILE'] ?? ''),
                        'LABEL_PROP_POSITION' => ($arParams['LABEL_PROP_POSITION'] ?? ''),
                        'OFFER_ADD_PICT_PROP' => ($arParams['OFFER_ADD_PICT_PROP'] ?? ''),
                        'OFFER_TREE_PROPS' => ($arParams['OFFER_TREE_PROPS'] ?? ''),
                        'SHOW_DISCOUNT_PERCENT' => ($arParams['SHOW_DISCOUNT_PERCENT'] ?? ''),
                        'DISCOUNT_PERCENT_POSITION' => ($arParams['DISCOUNT_PERCENT_POSITION'] ?? ''),
                        'SHOW_OLD_PRICE' => ($arParams['SHOW_OLD_PRICE'] ?? ''),
                        'MESS_BTN_BUY' => ($arParams['~MESS_BTN_BUY'] ?? ''),
                        'MESS_BTN_ADD_TO_BASKET' => ($arParams['~MESS_BTN_ADD_TO_BASKET'] ?? ''),
                        'MESS_BTN_DETAIL' => ($arParams['~MESS_BTN_DETAIL'] ?? ''),
                        'MESS_NOT_AVAILABLE' => ($arParams['~MESS_NOT_AVAILABLE'] ?? ''),
                        'ADD_TO_BASKET_ACTION' => ($arParams['ADD_TO_BASKET_ACTION'] ?? ''),
                        'SHOW_CLOSE_POPUP' => ($arParams['SHOW_CLOSE_POPUP'] ?? ''),
                        'DISPLAY_COMPARE' => ($arParams['DISPLAY_COMPARE'] ?? ''),
                        'COMPARE_PATH' => ($arParams['COMPARE_PATH'] ?? ''),
                    )
                    + array(
                        'OFFER_ID' => empty($arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'])
                            ? $arResult['ID']
                            : $arResult['OFFERS'][$arResult['OFFERS_SELECTED']]['ID'],
                        'SECTION_ID' => $arResult['SECTION']['ID'],
                        'ELEMENT_ID' => $arResult['ID'],

                        'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
                        'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
                        'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY']
                    ),
                    $component,
                    array('HIDE_ICONS' => 'Y')
                );
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<meta itemprop="name" content="<?=$name?>" />
<meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
<?php
if ($haveOffers)
{
    foreach ($arResult['JS_OFFERS'] as $offer)
    {
        $currentOffersList = array();

        if (!empty($offer['TREE']) && is_array($offer['TREE']))
        {
            foreach ($offer['TREE'] as $propName => $skuId)
            {
                $propId = (int)mb_substr($propName, 5);

                foreach ($skuProps as $prop)
                {
                    if ($prop['ID'] == $propId)
                    {
                        foreach ($prop['VALUES'] as $propId => $propValue)
                        {
                            if ($propId == $skuId)
                            {
                                $currentOffersList[] = $propValue['NAME'];
                                break;
                            }
                        }
                    }
                }
            }
        }

        $offerPrice = $offer['ITEM_PRICES'][$offer['ITEM_PRICE_SELECTED']];
        ?>
        <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="sku" content="<?=htmlspecialcharsbx(implode('/', $currentOffersList))?>" />
				<meta itemprop="price" content="<?=$offerPrice['RATIO_PRICE']?>" />
				<meta itemprop="priceCurrency" content="<?=$offerPrice['CURRENCY']?>" />
				<link itemprop="availability" href="http://schema.org/<?=($offer['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
			</span>
        <?php
    }

    unset($offerPrice, $currentOffersList);
}
else
{
    ?>
    <span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
			<meta itemprop="price" content="<?=$price['RATIO_PRICE']?>" />
			<meta itemprop="priceCurrency" content="<?=$price['CURRENCY']?>" />
			<link itemprop="availability" href="http://schema.org/<?=($actualItem['CAN_BUY'] ? 'InStock' : 'OutOfStock')?>" />
		</span>
    <?php
}
?>
</div>
<?php
if ($haveOffers)
{
    $offerIds = array();
    $offerCodes = array();

    $useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

    foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
    {
        $offerIds[] = (int)$jsOffer['ID'];
        $offerCodes[] = $jsOffer['CODE'];

        $fullOffer = $arResult['OFFERS'][$ind];
        $measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

        $strAllProps = '';
        $strMainProps = '';
        $strPriceRangesRatio = '';
        $strPriceRanges = '';

        if ($arResult['SHOW_OFFERS_PROPS'])
        {
            if (!empty($jsOffer['DISPLAY_PROPERTIES']))
            {
                /*Собираем массив свойств для удобной работы в js*/
                $jsOffer['PROPS_ARRAY'] = [];

                foreach ($jsOffer['DISPLAY_PROPERTIES'] as $key => $property)
                {

                    if($property['CODE'] == 'Tsvet'){
                        if(Loader::IncludeModule('ldo.develop')){
                            $newResult = Hlblock::getImageAndNameByNames($property['VALUE']);

                        }

                        $propDataDop = [
                            'NAME' => "BG_COLOR",
                            'CODE' => "BG_COLOR",
                            'VALUE' => $newResult,
                        ];
                        unset($newResult);
                        $jsOffer['PROPS_ARRAY'][] = $propDataDop;

                        unset($propDataDop);
                    }

                    $propData = [
                        'NAME' => $property['NAME'],
                        'CODE' => $property['CODE'],
                        'VALUE' => is_array($property['VALUE']) ? $property['VALUE'] : [$property['VALUE']],
                    ];

                    $jsOffer['PROPS_ARRAY'][] = $propData;



                    if($property['CODE'] == 'ARTICLE' || $property['CODE'] == 'Ploshchad' || $property['CODE'] =='Gamma'){
                        unset($property);
                        continue;
                    }

                    $current = '<div class="prop-line"><span>'.$property['NAME'].'</span><span>'.(
                        is_array($property['VALUE'])
                            ? implode(' , ', $property['VALUE'])
                            : $property['VALUE']
                        ).'</span></div>';

                    $strAllProps .= $current;

                    if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
                    {
                        $strMainProps .= $current;
                    }

                }
                if($actualItem['PROPERTIES']['Method']['VALUE'] == 'Ручная работа'){
                    $strAllProps.= '<div class="prop-line"><span>Метод производства</span> <span>Ручная работа</span></div>';
                }


                unset($current,$propData);
            }
        }


        if ($arParams['USE_PRICE_COUNT'] && count($jsOffer['ITEM_QUANTITY_RANGES']) > 1)
        {
            $strPriceRangesRatio = '('.Loc::getMessage(
                    'CT_BCE_CATALOG_RATIO_PRICE',
                    array('#RATIO#' => ($useRatio
                            ? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
                            : '1'
                        ).' '.$measureName)
                ).')';

            foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
            {
                if ($range['HASH'] !== 'ZERO-INF')
                {
                    $itemPrice = false;

                    foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
                    {
                        if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
                        {
                            break;
                        }
                    }

                    if ($itemPrice)
                    {
                        $strPriceRanges .= '<dt>'.Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_FROM',
                                array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
                            ).' ';

                        if (is_infinite($range['SORT_TO']))
                        {
                            $strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
                        }
                        else
                        {
                            $strPriceRanges .= Loc::getMessage(
                                'CT_BCE_CATALOG_RANGE_TO',
                                array('#TO#' => $range['SORT_TO'].' '.$measureName)
                            );
                        }

                        $strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
                    }
                }
            }

            unset($range, $itemPrice);
        }

        $jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
        $jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
        $jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
        $jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
    }

    $templateData['OFFER_IDS'] = $offerIds;
    $templateData['OFFER_CODES'] = $offerCodes;
    unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => true,
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
            'OFFER_GROUP' => $arResult['OFFER_GROUP'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null,
            'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
            'DISPLAY_PREVIEW_TEXT_MODE' => $arParams['DISPLAY_PREVIEW_TEXT_MODE']
        ),
        'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
        'VISUAL' => $itemIds,
        'DEFAULT_PICTURE' => array(
            'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
            'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
        ),
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'NAME' => $arResult['~NAME'],
            'CATEGORY' => $arResult['CATEGORY_PATH'],
            'DETAIL_TEXT' => $arResult['DETAIL_TEXT'],
            'DETAIL_TEXT_TYPE' => $arResult['DETAIL_TEXT_TYPE'],
            'PREVIEW_TEXT' => $arResult['PREVIEW_TEXT'],
            'PREVIEW_TEXT_TYPE' => $arResult['PREVIEW_TEXT_TYPE']
        ),
        'BASKET' => array(
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'BASKET_URL' => $arParams['BASKET_URL'],
            'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        ),
        'OFFERS' => $arResult['JS_OFFERS'],
        'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
        'TREE_PROPS' => $skuProps,

    );

    //print_r($arResult['JS_OFFERS']);
}
else
{
    $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
    if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !$emptyProductProperties)
    {
        ?>
        <div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
            <?php
            if (!empty($arResult['PRODUCT_PROPERTIES_FILL']))
            {
                foreach ($arResult['PRODUCT_PROPERTIES_FILL'] as $propId => $propInfo)
                {
                    ?>
                    <input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]" value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
                    <?php
                    unset($arResult['PRODUCT_PROPERTIES'][$propId]);
                }
            }

            $emptyProductProperties = empty($arResult['PRODUCT_PROPERTIES']);
            if (!$emptyProductProperties)
            {
                ?>
                <table>
                    <?php
                    foreach ($arResult['PRODUCT_PROPERTIES'] as $propId => $propInfo)
                    {
                        ?>
                        <tr>
                            <td><?=$arResult['PROPERTIES'][$propId]['NAME']?></td>
                            <td>
                                <?php
                                if (
                                    $arResult['PROPERTIES'][$propId]['PROPERTY_TYPE'] === 'L'
                                    && $arResult['PROPERTIES'][$propId]['LIST_TYPE'] === 'C'
                                )
                                {
                                    foreach ($propInfo['VALUES'] as $valueId => $value)
                                    {
                                        ?>
                                        <label>
                                            <input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]"
                                                   value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? 'checked' : '')?>>
                                            <?=$value?>
                                        </label>
                                        <br>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propId?>]">
                                        <?php
                                        foreach ($propInfo['VALUES'] as $valueId => $value)
                                        {
                                            ?>
                                            <option value="<?=$valueId?>" <?=($valueId == $propInfo['SELECTED'] ? 'selected' : '')?>>
                                                <?=$value?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
            }
            ?>
        </div>
        <?php
    }

    $jsParams = array(
        'CONFIG' => array(
            'USE_CATALOG' => $arResult['CATALOG'],
            'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
            'SHOW_PRICE' => !empty($arResult['ITEM_PRICES']),
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
            'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
            'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
            'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
            'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
            'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
            'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
            'USE_STICKERS' => true,
            'USE_SUBSCRIBE' => $showSubscribe,
            'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
            'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
            'ALT' => $alt,
            'TITLE' => $title,
            'MAGNIFIER_ZOOM_PERCENT' => 200,
            'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
            'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
            'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
                ? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
                : null
        ),
        'VISUAL' => $itemIds,
        'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
        'PRODUCT' => array(
            'ID' => $arResult['ID'],
            'ACTIVE' => $arResult['ACTIVE'],
            'PICT' => reset($arResult['MORE_PHOTO']),
            'NAME' => $arResult['~NAME'],
            'SUBSCRIPTION' => true,
            'ITEM_PRICE_MODE' => $arResult['ITEM_PRICE_MODE'],
            'ITEM_PRICES' => $arResult['ITEM_PRICES'],
            'ITEM_PRICE_SELECTED' => $arResult['ITEM_PRICE_SELECTED'],
            'ITEM_QUANTITY_RANGES' => $arResult['ITEM_QUANTITY_RANGES'],
            'ITEM_QUANTITY_RANGE_SELECTED' => $arResult['ITEM_QUANTITY_RANGE_SELECTED'],
            'ITEM_MEASURE_RATIOS' => $arResult['ITEM_MEASURE_RATIOS'],
            'ITEM_MEASURE_RATIO_SELECTED' => $arResult['ITEM_MEASURE_RATIO_SELECTED'],
            'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
            'SLIDER' => $arResult['MORE_PHOTO'],
            'CAN_BUY' => $arResult['CAN_BUY'],
            'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
            'QUANTITY_FLOAT' => is_float($arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']),
            'MAX_QUANTITY' => $arResult['PRODUCT']['QUANTITY'],
            'STEP_QUANTITY' => $arResult['ITEM_MEASURE_RATIOS'][$arResult['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'],
            'CATEGORY' => $arResult['CATEGORY_PATH']
        ),
        'BASKET' => array(
            'ADD_PROPS' => $arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y',
            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
            'EMPTY_PROPS' => $emptyProductProperties,
            'BASKET_URL' => $arParams['BASKET_URL'],
            'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
            'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
        )
    );
    unset($emptyProductProperties);
}

if ($arParams['DISPLAY_COMPARE'])
{
    $jsParams['COMPARE'] = array(
        'COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
        'COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
        'COMPARE_PATH' => $arParams['COMPARE_PATH']
    );
}

$jsParams["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"] =
    $arResult["IS_FACEBOOK_CONVERSION_CUSTOMIZE_PRODUCT_EVENT_ENABLED"]
;

?>



<script>
    BX.message({
        ECONOMY_INFO_MESSAGE: '<?=GetMessageJS('CT_BCE_CATALOG_ECONOMY_INFO2')?>',
        TITLE_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_ERROR')?>',
        TITLE_BASKET_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_TITLE_BASKET_PROPS')?>',
        BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_BASKET_UNKNOWN_ERROR')?>',
        BTN_SEND_PROPS: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_SEND_PROPS')?>',
        BTN_MESSAGE_DETAIL_BASKET_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_BASKET_REDIRECT')?>',
        BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE')?>',
        BTN_MESSAGE_DETAIL_CLOSE_POPUP: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_CLOSE_POPUP')?>',
        TITLE_SUCCESSFUL: '<?=GetMessageJS('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?>',
        COMPARE_MESSAGE_OK: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_OK')?>',
        COMPARE_UNKNOWN_ERROR: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_UNKNOWN_ERROR')?>',
        COMPARE_TITLE: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_COMPARE_TITLE')?>',
        BTN_MESSAGE_COMPARE_REDIRECT: '<?=GetMessageJS('CT_BCE_CATALOG_BTN_MESSAGE_COMPARE_REDIRECT')?>',
        PRODUCT_GIFT_LABEL: '<?=GetMessageJS('CT_BCE_CATALOG_PRODUCT_GIFT_LABEL')?>',
        PRICE_TOTAL_PREFIX: '<?=GetMessageJS('CT_BCE_CATALOG_MESS_PRICE_TOTAL_PREFIX')?>',
        RELATIVE_QUANTITY_MANY: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_MANY'])?>',
        RELATIVE_QUANTITY_FEW: '<?=CUtil::JSEscape($arParams['MESS_RELATIVE_QUANTITY_FEW'])?>',
        SITE_ID: '<?=CUtil::JSEscape($component->getSiteId())?>'
    });

    var <?=$obName?> = new JCCatalogElement(<?=CUtil::PhpToJSObject($jsParams, false, true)?>);
</script>
<?php

//echo "<pre>";
//print_r($jsParams['OFFERS']);
unset($actualItem, $itemIds, $jsParams);






