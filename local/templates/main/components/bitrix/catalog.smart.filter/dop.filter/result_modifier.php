<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


function declOfNum($num, $titles) {
    $cases = array(2, 0, 1, 1, 1, 2);
    return $titles[($num % 100 > 4 && $num % 100 < 20) ? 2 : $cases[min($num % 10, 5)]];//просто заголовок
}



$resultFilterItemCount = array();
foreach($arResult["ITEMS"] as $arrayParams){
    foreach($arrayParams["VALUES"] as $arrayParamsItem){
        if($arrayParamsItem["CHECKED"]){
            $resultFilterItemCount[] = $arrayParamsItem["ELEMENT_COUNT"];
        }
    }
}

$count = 0;

foreach ($resultFilterItemCount as $count){
    $countSum = $countSum + $count;
}
unset($resultFilterItemCount);


if($countSum){
	$arParams['COUNT'] = $countSum;
	unset($countSum);
}
else{
    if($arParams['SECTION_ID'] == 0){
        $arParams['COUNT'] =  CIBlock::GetElementCount($arParams['IBLOCK_ID']);
    }
    else{
        $arParams['COUNT'] =  CIBlockSection::GetSectionElementsCount($arParams['SECTION_ID']);
    }


}

$arParams['TEXT_COUNT'] = declOfNum($arParams['COUNT'], array('модель', 'модели', 'моделей'));







$sectionFilter = ['Tsvet','Material','Forma','Tsena','Size'];


foreach ($arResult["ITEMS"] as $key => $arItem) {
	if(!in_array($arItem['CODE'],$sectionFilter)){
		unset($arResult["ITEMS"][$key]);
	}
}



if (isset($arParams["TEMPLATE_THEME"]) && !empty($arParams["TEMPLATE_THEME"]))
{
	$arAvailableThemes = array();
	$dir = trim(preg_replace("'[\\\\/]+'", "/", dirname(__FILE__)."/themes/"));
	if (is_dir($dir) && $directory = opendir($dir))
	{
		while (($file = readdir($directory)) !== false)
		{
			if ($file != "." && $file != ".." && is_dir($dir.$file))
				$arAvailableThemes[] = $file;
		}
		closedir($directory);
	}

	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$solution = COption::GetOptionString("main", "wizard_solution", "", SITE_ID);
		if ($solution == "eshop")
		{
			$templateId = COption::GetOptionString("main", "wizard_template_id", "eshop_bootstrap", SITE_ID);
			$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? "eshop_adapt" : $templateId;
			$theme = COption::GetOptionString("main", "wizard_".$templateId."_theme_id", "blue", SITE_ID);
			$arParams["TEMPLATE_THEME"] = (in_array($theme, $arAvailableThemes)) ? $theme : "blue";
		}
	}
	else
	{
		$arParams["TEMPLATE_THEME"] = (in_array($arParams["TEMPLATE_THEME"], $arAvailableThemes)) ? $arParams["TEMPLATE_THEME"] : "blue";
	}
}
else
{
	$arParams["TEMPLATE_THEME"] = "blue";
}

$arParams["FILTER_VIEW_MODE"] = "HORIZONTAL";
$arParams["POPUP_POSITION"] = (isset($arParams["POPUP_POSITION"]) && in_array($arParams["POPUP_POSITION"], array("left", "right"))) ? $arParams["POPUP_POSITION"] : "left";






