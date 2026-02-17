<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Event;
/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();


$arUF = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields($arParams['IBLOCK_ID'],$arResult['SECTION']['ID'],"UF_CHAIN");

if($arUF["UF_CHAIN"]["VALUE"] != ""){

	$arResult["SECTIONS"]['UF_CHAIN'] = $arUF["UF_CHAIN"];

}




// В result_modifier.php компонента
if(isset($arResult['NAV_RESULT']) && is_object($arResult['NAV_RESULT'])) {
    // Общее количество элементов с учетом фильтра
    $filteredCount = $arResult['NAV_RESULT']->NavRecordCount;
    $arResult['FILTER_COUNT'] = $filteredCount;
}


