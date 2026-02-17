<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Результаты поиска");
$APPLICATION->SetTitle("Результаты поиска");
?>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="title-catalog"><?$APPLICATION->ShowTitle(false);?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?$APPLICATION->IncludeComponent(
	"bitrix:search.page", 
	"search-page-result", 
	[
		"COMPONENT_TEMPLATE" => "search-page-result",
		"RESTART" => "Y",
		"NO_WORD_LOGIC" => "N",
		"CHECK_DATES" => "N",
		"USE_TITLE_RANK" => "N",
		"DEFAULT_SORT" => "rank",
		"FILTER_NAME" => "",
		"arrFILTER" => [
			0 => "iblock_main",
		],
		"arrFILTER_iblock_main" => [
			0 => "1",
		],
		"SHOW_WHERE" => "N",
		"SHOW_WHEN" => "N",
		"PAGE_RESULT_COUNT" => "50",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"USE_LANGUAGE_GUESS" => "Y",
		"USE_SUGGEST" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Результаты поиска",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "default"
	],
	false
);?>
        </div>
    </div>
</div>
