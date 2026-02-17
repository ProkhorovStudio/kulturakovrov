<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
$arSort = [
    "name"=> "Алфавиту",
    "show_counter" => "Популярности",
    "catalog_PRICE_1" => "Цене"
];
?>

<?

?>
<div class="line-button">
    <button class="mobile_filter_button"><span></span><span>Фильтры</span><?=$arParams['COUNT'] ? '<span class="count">'.$arParams['COUNT'].'</span>' : '';?></button>
    <div class="mobile-sort"></div>
</div>

<div class="sort-line mobile d-md-none">
    <div class="sortline">
        <div class="select-block mobile">
            <div class="<?=$_COOKIE['sortten'] == 'show_counter' ? 'active' : ' '; ?>" name="show_counter" type="desc">По популярности</div>
            <div name="name" class="<?=$_COOKIE['sortten'] == 'name' ? 'active' : ' '; ?>" type="asc">По алфавиту</div>
            <div name="catalog_PRICE_1" class="<?if($_COOKIE['sorttype'] == 'asc' && $_COOKIE['sortten'] == 'catalog_PRICE_1'){ echo 'active';}?>" type="asc">По возрастанию цены</div>
            <div class="<?if($_COOKIE['sorttype'] == 'desc' && $_COOKIE['sortten'] == 'catalog_PRICE_1'){ echo 'active';}?>" name="catalog_PRICE_1" class="active" type="desc">По убыванию цены</div>
        </div>
    </div>
</div>

<div class="mobile_filter_panel mobile ">
    <div class="top-mobile-filter d-md-none">
        <div class="top-mobile-filter__title">ФИЛЬТРЫ</div>
        <div class="top-mobile-filter__close">Отмена</div>
    </div>
    <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>" method="get">

        <? foreach ($arResult["HIDDEN"] as $arItem): ?>
            <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
                   value="<? echo $arItem["HTML_VALUE"] ?>"/>
        <? endforeach; ?>

        <div class="smart-filter">
            <?/* foreach ($arResult["ITEMS"] as $key => $arItem)//prices
            {
                $key = $arItem["ENCODED_ID"];
                if (!isset($arItem["PRICE"])):
                    if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                        continue;
                    ?>
                    <div class="smart-filter-parameters-box bx-active">
                        <span class="smart-filter-container-modef">

                        </span>
                        <div class="smart-filter_title" onclick="smartFilter.hideFilterProps(this)">
                            <?=$arItem["NAME"]?>
                        </div>
                        <div data-role="bx_filter_block">
                            <div class="smart-filter-digits">
                                <input
                                        type="number"
                                        name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                        id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                        value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                        size="5"
                                        placeholder="<?= GetMessage("CT_BCSF_FILTER_FROM") ?>"
                                        onkeyup="smartFilter.keyup(this)"
                                />
                                <input
                                        type="number"
                                        name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                        id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                        value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                        size="5"
                                        placeholder="<?= GetMessage("CT_BCSF_FILTER_TO") ?>"
                                        onkeyup="smartFilter.keyup(this)"
                                />
                            </div>
                            <div class="smart-filter-slider-track-container">
                                <div class="smart-filter-slider-track" id="drag_track_<?= $key ?>">
                                    <div class="smart-filter-slider-price-bar-vd" style="left: 0;right: 0;"
                                         id="colorUnavailableActive_<?= $key ?>"></div>
                                    <div class="smart-filter-slider-price-bar-vn" style="left: 0;right: 0;"
                                         id="colorAvailableInactive_<?= $key ?>"></div>
                                    <div class="smart-filter-slider-price-bar-v" style="left: 0;right: 0;"
                                         id="colorAvailableActive_<?= $key ?>"></div>
                                    <div class="smart-filter-slider-range" id="drag_tracker_<?= $key ?>"
                                         style="left: 0; right: 0;">
                                        <a class="smart-filter-slider-handle left" style="left:0;"
                                           href="javascript:void(0)"
                                           id="left_slider_<?= $key ?>"></a>
                                        <a class="smart-filter-slider-handle right" style="right:0;"
                                           href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?
                $arJsParams = array(
                    "leftSlider" => 'left_slider_' . $key,
                    "rightSlider" => 'right_slider_' . $key,
                    "tracker" => "drag_tracker_" . $key,
                    "trackerWrap" => "drag_track_" . $key,
                    "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                    "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                    "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                    "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                    "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                    "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                    "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
                    "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                    "precision" => $precision,
                    "colorUnavailableActive" => 'colorUnavailableActive_' . $key,
                    "colorAvailableActive" => 'colorAvailableActive_' . $key,
                    "colorAvailableInactive" => 'colorAvailableInactive_' . $key,
                );
                ?>
                    <script type="text/javascript">
                        BX.ready(function () {
                            window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                        });
                    </script>
                <?endif;
            }*/?>




            <?
            $i = 1;

            foreach ($arResult["ITEMS"] as $key => $arItem) {
                if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
                    continue;

                if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))

                ?>
                <?

                ?>
                <?
                if($arItem["DISPLAY_TYPE"] == 'A' && $i == 1) :?>
                <div class="size-block-filter" >
                    <div class="smart-filter_title-razmer  open">
                        Указать свой размер
                    </div>
                    <div class="size-block-filter__element">
                <?endif;?>
                <div class="smart-filter-parameters-box <? if ($arItem["DISPLAY_EXPANDED"] == "Y"): ?>bx-active<? endif ?>">
                <div class="block-result-filter">
                    <span class="smart-filter-container-modef">
                       <?/* Сюда втыкается счетчик найденного - не удалять */?>
                    </span>
                </div>
                    <div class="smart-filter_title" onclick="smartFilter.hideFilterProps(this)">
                        <?= $arItem["NAME"] ?>
                    </div>

                    <div class="bx_filter_block_expanded" data-role="bx_filter_block">
                        <?
                        $arCur = current($arItem["VALUES"]);
                        switch ($arItem["DISPLAY_TYPE"]) {

                        case "A": //NUMBERS_WITH_SLIDER
                        $i++;
                            ?>
                            <div class="smart-filter-digits">
                                <input class="min-price form-control form-control-sm"
                                       type="number"
                                       name="<? echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"] ?>"
                                       id="<? echo $arItem["VALUES"]["MIN"]["CONTROL_ID"] ?>"
                                       value="<? echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ?>"
                                       size="5"
                                       placeholder="<?= GetMessage("CT_BCSF_FILTER_FROM") ?>"
                                       onkeyup="smartFilter.keyup(this)"
                                />
                                <input
                                        class="max-price form-control form-control-sm"
                                        type="number"
                                        name="<? echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"] ?>"
                                        id="<? echo $arItem["VALUES"]["MAX"]["CONTROL_ID"] ?>"
                                        value="<? echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ?>"
                                        size="5"
                                        placeholder="<?= GetMessage("CT_BCSF_FILTER_TO") ?>"
                                        onkeyup="smartFilter.keyup(this)"
                                />
                            </div>
                            <div class="smart-filter-slider-track-container">
                                <div class="smart-filter-slider-track" id="drag_track_<?= $key ?>">
                                    <div class="smart-filter-slider-price-bar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?= $key ?>"></div>
                                    <div class="smart-filter-slider-price-bar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?= $key ?>"></div>
                                    <div class="smart-filter-slider-price-bar-v" style="left: 0;right: 0;" id="colorAvailableActive_<?= $key ?>"></div>
                                    <div class="smart-filter-slider-range" id="drag_tracker_<?= $key ?>" style="left: 0;right: 0;">
                                        <a class="smart-filter-slider-handle left" style="left:0;" href="javascript:void(0)" id="left_slider_<?= $key ?>"></a>
                                        <a class="smart-filter-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?= $key ?>"></a>
                                    </div>
                                </div>
                            </div>

                        <?
                        $arJsParams = array(
                            "leftSlider" => 'left_slider_' . $key,
                            "rightSlider" => 'right_slider_' . $key,
                            "tracker" => "drag_tracker_" . $key,
                            "trackerWrap" => "drag_track_" . $key,
                            "minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
                            "maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
                            "minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
                            "maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
                            "curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
                            "curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
                            "fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"],
                            "fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
                            "precision" => $arItem["DECIMALS"] ? $arItem["DECIMALS"] : 0,
                            "colorUnavailableActive" => 'colorUnavailableActive_' . $key,
                            "colorAvailableActive" => 'colorAvailableActive_' . $key,
                            "colorAvailableInactive" => 'colorAvailableInactive_' . $key,
                        );
                        ?>
                            <script type="text/javascript">
                                BX.ready(function () {
                                    window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
                                });

                            </script>

                        <?
                        if($i == 3) :?>
                        </div>
                </div>
                        <?endif;?>


                        <?
                        break;

                        case "K": //RADIO
                        ?>
                            <div class="smart-filter_radio">
                                <input type="radio" value="" name="<? echo $arCur["CONTROL_NAME_ALT"] ?>" id="<? echo "all_" . $arCur["CONTROL_ID"] ?>" onclick="smartFilter.click(this)"/>
                                <label for="<? echo "all_" . $arCur["CONTROL_ID"] ?>"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></label>
                                <? foreach ($arItem["VALUES"] as $val => $ar):
                                    if ($ar['DISABLED']) { // HIDE IF RESULTS 0 ?>
                                        <input type="radio" value="<? echo $ar["HTML_VALUE_ALT"] ?>" name="<? echo $ar["CONTROL_NAME_ALT"] ?>" id="<? echo $ar["CONTROL_ID"] ?>"<? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>onclick="smartFilter.click(this)"/>
                                        <label data-role="label_<?= $ar["CONTROL_ID"] ?>" for="<? echo $ar["CONTROL_ID"] ?>"><?= $ar["VALUE"]; ?></label>
                                        <?
                                    }
                                endforeach; ?>
                            </div>
                        <?
                        break;

                        default: // CHECKBOXES
                        ?>
                            <div class="smart-filter_checkbox">
                            <?
                            $count = 0;
                            $totalVisible = 0;
                            // Сначала посчитаем общее количество видимых элементов
                            foreach ($arItem["VALUES"] as $val => $ar) {
                                if (!$ar['DISABLED']) $totalVisible++;
                            }
                            
                            foreach ($arItem["VALUES"] as $val => $ar):
                                if (!$ar['DISABLED']) { 
                                    $count++;
                                    // Скрываем элементы, начиная с 11-го (если видимых элементов больше 2)
                                    $class = ($count > 10 && $totalVisible > 10) ? "hide" : "";
                                    ?>
                                    <input class="<?=$class?>" type="checkbox" value="<?=$ar["HTML_VALUE"]?>" name="<?=$ar["CONTROL_NAME"]?>" id="<?=$ar["CONTROL_ID"]?>"
                                        <?=$ar["CHECKED"] ? 'checked="checked"' : ''?>
                                        <?=$ar["DISABLED"] ? 'disabled' : ''?>
                                        onclick="smartFilter.click(this)"
                                    />
                                    <label class="<?=$class?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<?=$ar["CONTROL_ID"]?>">
                                        <i></i> 
                                        <?if($ar['FILE']['SRC']):?>
                                            <span class="img-color"><img src="<?=$ar['FILE']['SRC']?>"></span>
                                        <?endif?>
                                        <span>
                                            <?=$ar["VALUE"]?>
                                            <span class="counts"><?=$ar['ELEMENT_COUNT']?></span>
                                        </span> 
                                    </label>
                                    <?
                                }
                            endforeach; 
                            ?>
                            <? if ($totalVisible > 10): ?>
                                <span class="show-all">Раскрыть</span>
                            <? endif; ?>
                        </div>
                        <?
                        }
                        ?>

                    </div>
                </div>
                <?

            }
            ?>
        </div><!--//smart-filter-->

        <div class="smart-filter_bottons bottom_btn_filter">
            <input type="submit" id="set_filter" name="set_filter" value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"/>
            <?



            $visibleCount = strpos($arResult['HIDDEN'][0]['HTML_VALUE'],'apply');

            $ws = mb_strpos($arResult["FORM_ACTION"], 'att_width');
            $hs = mb_strpos($arResult["FORM_ACTION"], 'att_height');

            if($ws || $hs){
                $visibleCount = false;
            }



            if($visibleCount == 500):?>
                <div class="count-block">
                    <?if($arParams['COUNT']):?>
                        Найдено вариантов: <?=$arParams['COUNT']?>
                    <?else:?>
                        Ничего не найдено
                    <?endif;?>

                </div>
            <?endif;?>
            <?if($visibleCount ):

                $clearLink = '/catalog/';

                $sectionId = $arParams['SECTION_ID'];
                if($sectionId != 0){
                    $arrSection = CIBlockSection::GetByID($sectionId);
                    if($sectionParams = $arrSection->GetNext()){
                        $clearLink = $sectionParams['SECTION_PAGE_URL'];
                    }

                }

                ?>
            <input type="submit" id="del_filter" name="del_filter" value="Очистить все" style="display:none;">
            <a href="<?=$clearLink?>" id="del_filter">Очистить все</a>
            <?endif;?>
            <div class="smart-filter-popup-result <? if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"] ?>" id="modef" <? if (!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; ?>style="display: inline-block;">
                <? echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => ' <span id="modef_num">' . intval($arResult["ELEMENT_COUNT"]) . '</span>')); ?>
                <a href="<? echo $arResult["FILTER_URL"] ?>" target=""><? echo GetMessage("CT_BCSF_FILTER_SHOW") ?></a>
            </div>
        </div>
    </form>
</div>
<div class="mobile_filter_panel_over"></div>
<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);

    // MOBILE WORKER BEFORE
    $('.mobile_filter_button').click(function () {
        $('.mobile_filter_panel').toggleClass('mobile_filter_panel_show');
        $('.mobile_filter_panel_over').toggleClass('mobile_filter_panel_over_show');
    });
    // MOBILE WORKER AFTER
    $('.mobile_filter_panel_over').click(function () {
        $('.mobile_filter_panel_over').removeClass('mobile_filter_panel_over_show');
        $('.mobile_filter_panel').removeClass('mobile_filter_panel_show');
    });
</script>

<?if($USER->IsAdmin()):?>
    <?

    /*echo "<pre>";
    print_r($GLOBALS);
    echo "</pre>";*/
    ?>
<?endif?>
