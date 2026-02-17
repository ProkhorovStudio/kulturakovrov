<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "текстовая, карта, сайта");
$APPLICATION->SetPageProperty("description", "Текстовая карта сайта");
$APPLICATION->SetPageProperty("title", "Карта сайта");
$APPLICATION->SetTitle("Карта сайта");
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="title-catalog">Карта сайта</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="before-title-sitemap">
                <a href="/catalog/">Каталог</a>
            </div>
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section.list",
                "sitemap",
                [
                    "ADDITIONAL_COUNT_ELEMENTS_FILTER" => "additionalCountFilter",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COUNT_ELEMENTS" => "N",
                    "COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
                    "FILTER_NAME" => "sectionsFilter",
                    "HIDE_SECTIONS_WITH_ZERO_COUNT_ELEMENTS" => "N",
                    "IBLOCK_ID" => "1",
                    "IBLOCK_TYPE" => "main",
                    "SECTION_CODE" => "",
                    "SECTION_FIELDS" => [
                        0 => "NAME",
                        1 => "",
                    ],
                    "SECTION_ID" => $_REQUEST["SECTION_ID"],
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => [
                        0 => "",
                        1 => "",
                    ],
                    "SHOW_PARENT_NAME" => "Y",
                    "TOP_DEPTH" => "5",
                    "VIEW_MODE" => "LIST",
                    "COMPONENT_TEMPLATE" => ".default",
                    "OFFSET_MODE" => "N",
                    "SHOW_ANGLE" => "Y"
                ],
                false
            );?>
        </div>
        <div class="col-lg-3">
            <div class="before-title-sitemap">
                <a href="/catalog/">Партнерам</a>
                <div class="bx_sitemap">
                    <ul class="other-map">
                        <li><a href="/partneram/">Дизайнерам</a></li>
                        <li><a target="_blank" href="http://partners.kulturakovrov.ru/">Корпоративным партнерам</a></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-lg-3">
            <div class="before-title-sitemap">
                <a href="/o-kompanii/">О компании</a>
                <div class="bx_sitemap">
                    <ul class="other-map">
                        <li><a href="/o-kompanii/pressa-o-nas/">Пресса о нас</a></li>
                        <li><a href="/o-kompanii/kollaboracii/">Коллаборации</a></li>
                        <li><a href="/o-kompanii/faq/">Помощь</a></li>
                        <li><a href="/o-kompanii/uslugi/">Услуги</a></li>
                        <li><a href="/o-kompanii/privilegii/">Привилегии</a></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-lg-2">
            <div class="before-title-sitemap">
                <a href="/kontakty/">Контакты</a>
            </div>
        </div>

    </div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>