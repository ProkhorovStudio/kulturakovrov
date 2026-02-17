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
<script>
    // Добавьте этот код после основного скрипта фильтра
    document.addEventListener('DOMContentLoaded', function() {
        // Ждем когда Bitrix инициализирует фильтр
        setTimeout(function() {
            // Находим оба фильтра на странице
            const mainFilter = document.querySelector('.mobile_filter_panel form'); // укажите правильный селектор
            const mobileFilter = document.querySelector('.dop-filter form');

            if (!mainFilter || !mobileFilter) return;

            // Синхронизация из мобильного в основной
            mobileFilter.addEventListener('change', function(e) {
                if (e.target.matches('input[type="checkbox"]')) {
                    const name = e.target.name;
                    const value = e.target.value;
                    const checked = e.target.checked;

                    // Находим соответствующий чекбокс в основном фильтре
                    const mainCheckbox = mainFilter.querySelector(`input[name="${name}"][value="${value}"]`);
                    if (mainCheckbox) {
                        mainCheckbox.checked = checked;
                        // Триггерим событие change
                        const event = new Event('change');
                        mainCheckbox.dispatchEvent(event);
                    }
                }
            });

            // Синхронизация из основного в мобильный
            mainFilter.addEventListener('change', function(e) {
                if (e.target.matches('input[type="checkbox"]')) {
                    const name = e.target.name;
                    const value = e.target.value;
                    const checked = e.target.checked;

                    // Находим соответствующий чекбокс в мобильном фильтре
                    const mobileCheckbox = mobileFilter.querySelector(`input[name="${name}"][value="${value}"]`);
                    if (mobileCheckbox) {
                        mobileCheckbox.checked = checked;
                    }
                }
            });
        }, 1000); // Даем время на инициализацию основного фильтра
    });
</script>

<div class="count-product d-md-none"><div class="count-models ">Найдено ковров: <span><?=$arParams['COUNT']?></span> <?=$arParams['TEXT_COUNT']?></div></div>
<div class="sort-line">
    <div class="count-models ">Найдено ковров: <span><?=$arParams['COUNT']?></span> <?=$arParams['TEXT_COUNT']?></div>
    <div class="sortline">
  <span class="">Упорядочить по:</span>
  <?if($_COOKIE['sortten']):?>
        <?if($_COOKIE['sortten'] == 'catalog_PRICE_1'):?>
            <?if($_COOKIE['sorttype'] == 'asc'):?>
              <span class="this-sort ">Возрастанию цены</span>
            <?endif?>
          <?if($_COOKIE['sorttype'] == 'desc'):?>
              <span class="this-sort ">Убыванию цены</span>
          <?endif?>
        <?else:?>
          <span class="this-sort "><?=$arSort[$_COOKIE['sortten']]?></span>
        <?endif?>

  <?else:?>
  <span class="this-sort">По алфавиту</span>
  <?endif;?>  
  <div class="select-block ">
      <div name="show_counter" type="desc">По популярности</div>
      <div name="name" type="asc">По алфавиту</div>
      <div name="catalog_PRICE_1" type="asc">По возрастанию цены</div>
      <div name="catalog_PRICE_1" type="desc">По убыванию цены</div>
  </div>
</div>
</div>

<div class="mobile_filter_panel dop-filter">

     <form name="" action="" method="get">
         <div class="smart-filter-top">
            <? foreach ($arResult["ITEMS"] as $key => $arItem)//prices
            {
                $key = $arItem["ENCODED_ID"];
                if (!isset($arItem["PRICE"])):
                    if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                        continue;
                    ?>
                    <div class="smart-filter-parameters-box bx-active">
                        <span class="smart-filter-container-modef">
                            <?/* Сюда втыкается счетчик найденного - не удалять */?>
                        </span>
                        <div class="smart-filter_title">
                            <?=$arItem["NAME"]?>
                        </div>
                        
                    </div>
                <?endif;
            }



            //not prices
            foreach ($arResult["ITEMS"] as $key => $arItem) {
                if (empty($arItem["VALUES"]) || isset($arItem["PRICE"]))
                    continue;

                if ($arItem["DISPLAY_TYPE"] == "A" && ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0))
                    continue;
                ?>

                <div class="smart-filter-parameters-box">
                <span class="smart-filter-container-modef">
                   <?/* Сюда втыкается счетчик найденного - не удалять */?>
                </span>
                    <div class="smart-filter_title">
                        <?= $arItem["NAME"] ?>
                    </div>

                    <div class="bx_filter_block_expanded" data-role="bx_filter_block">
                        <?
                        $arCur = current($arItem["VALUES"]);
                        switch ($arItem["DISPLAY_TYPE"]) {
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

                                    $class = "";
                                    ?>
                                    <input class="<?=$class?>" type="checkbox" value="<?=$ar["HTML_VALUE"]?>" name="<?=$ar["CONTROL_ID"]?>" id="<?=$ar["CONTROL_ID"]?>"
                                        <?=$ar["CHECKED"] ? 'checked="checked"' : ''?>
                                        <?=$ar["DISABLED"] ? 'disabled' : ''?>
                                        
                                    />
                                    <label class="<?=$class?>" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<?=$ar["CONTROL_ID"]?>" id="<?=$ar["CONTROL_ID"]?>">
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

                        </div>
                        <?
                        }
                        ?>

                    </div>
                </div>
                <?
            }

            ?>
             <?if(strpos($arResult['HIDDEN'][0]['HTML_VALUE'], 'apply')):?>
             <?
                 $clearLink = '/catalog/';

                 $sectionId = $arParams['SECTION_ID'];
                 if($sectionId != 0){
                     $arrSection = CIBlockSection::GetByID($sectionId);
                     if($sectionParams = $arrSection->GetNext()){
                         $clearLink = $sectionParams['SECTION_PAGE_URL'];
                     }

                 }
             ?>

                <a href="<?=$clearLink?>" class="clear-filter">Сбросить</a>
             <?endif;?>
             <a id="topresult" href="" class="top-filter-apply">Показать</a>
        </div><!--//smart-filter-->
    </form>
</div>
<div class="mobile_filter_panel_over"></div>
