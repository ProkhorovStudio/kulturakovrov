<?
ob_start();
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
$GLOBALS['APPLICATION']->RestartBuffer();
use Bitrix\Main\Loader;
use Ldo\Develop\Hlblock;
use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\SectionTable;
$date = (new DateTime())->format(DateTime::RFC3339);

$site_url = 'https://kulturakovrov.ru';
$iblock_id = 2;


CModule::IncludeModule('sale');
Loader::IncludeModule('ldo.develop');

/*Категории*/

if (CModule::IncludeModule('iblock')) {
    $itemsSection = GetIBlockSectionList(1, 19, Array("SORT"=>"DESC"));
    while($arItem = $itemsSection->GetNext()) {
        $categories .= '<category id="'.$arItem["ID"].'">'.$arItem["NAME"].'</category>'."\n";
    }
}

/*Оферы*/
if (CModule::IncludeModule('iblock')) {

    $arSelect_1 = array('ID','DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID', 'NAME','PROPERTY_Kollektsiya','PROPERTY_Razmer_teh','PROPERTY_ARTICLE','PROPERTY_Style','PROPERTY_Proizvoditel','PROPERTY_Kollektsiya','PROPERTY_Method','PROPERTY_Material','PROPERTY_Tsvet');
    $arFilter_1 = array('IBLOCK_ID' => $iblock_id, 'ACTIVE' => 'Y', "INCLUDE_SUBSECTIONS" => "Y", 'PROPERTY_METHOD_VALUE' => 'Ручная работа');
    $row1 = CIBlockElement::GetList(array("ACTIVE_FROM" => "ASC"), $arFilter_1, false, array("nPageSize" => 3000), $arSelect_1);
    $offers = '';

    while ($mass_row1 = $row1->GetNextElement()) {
        $arFields = $mass_row1->GetFields();
        $arProps = $mass_row1->GetProperties();
        $mxResult = CCatalogSku::GetProductInfo(
            $arFields['ID']
        );

        $idProduct = $mxResult['ID'];

        $images = [];


        $db_props = CIBlockElement::GetProperty(1, $idProduct, array("sort" => "asc"), Array("CODE"=>"MORE_PHOTO"));

        while($ar_props = $db_props->Fetch()){
            $images[] = CFile::GetPath($ar_props["VALUE"]);
        }


        /*Получаем ID подраздела Коллекции*/
        $db_groups = CIBlockElement::GetElementGroups($idProduct, true);
        while($ar_group = $db_groups->Fetch()) {
            if($ar_group['IBLOCK_SECTION_ID'] == 19){
                $categoryId = $ar_group['ID'];
            }
        }

        /*if(!empty($arFields["PROPERTY_TSVET_VALUE"])){
            $colorsName = Hlblock::getNameByIds($arFields["PROPERTY_TSVET_VALUE"]);
            $colorsCorrectName =  implode("||",$colorsName);
        }*/

        $pattern = '/\s+[a-zA-Zа-яА-Я0-9]+$/u';
        $resultTitle = preg_replace($pattern, '', $arFields["NAME"]);

        // Убираем возможные двойные пробелы и пробелы в начале/конце
        $resultName = trim(preg_replace('/\s+/', ' ', $resultTitle));

        $i++;

        $material_product = $arFields["PROPERTY_MATERIAL_VALUE"];

        $materialDeclension = Hlblock::getDeclensionByName($material_product);

        $styleProduct = $arFields["PROPERTY_STYLE_VALUE"];

        $styleDeclension = Hlblock::getDeclensionByStyle($styleProduct);

        if($materialDeclension){
            $materialFeed = $materialDeclension;
        }
        else{
            continue;
        }

        $countable[] = $resultName;

        $price = Cprice::GetBasePrice($arFields["ID"]);

        if($price['PRICE'] == '0'){
            continue;
        }

        $offers .= '<offer id="' . $arFields["ID"] . '">
            <name>Ковер ручной работы '.$materialFeed.'</name>
            <vendor>'.$arFields["PROPERTY_PROIZVODITEL_VALUE"].'</vendor>
            <categoryId>'.$categoryId.'</categoryId>
            <url>'.$site_url.$arFields["DETAIL_PAGE_URL"].'</url>
            <description>'.$styleDeclension.' ковер ручной работы '.$materialFeed.' ('.$arFields["PROPERTY_PROIZVODITEL_VALUE"].')</description>
            <param name="Материал">'.$materialFeed.'</param>
            <param name="Cпособ производства">'.$arFields["PROPERTY_METHOD_VALUE"].'</param>
            <param name="Cтрана производства">'.$arFields["PROPERTY_PROIZVODITEL_VALUE"].'</param>
            <price>'.$price['PRICE'].'</price>
            <currencyId>RUB</currencyId>
            <delivery>true</delivery>
            '. implode("\n            ", array_map(function($img) {
                return '<picture>https://kulturakovrov.ru'.preg_replace("/\s+/", "%20", $img).'</picture>';
            }, $images)) . '
    </offer>'
        ;
        unset($images,$price,$colors,$colorsCorrectName,$imagesProduct,$resultName,$materialFeed,$categoryId);
    }


    $tmp = "<?xml version='1.0' encoding='utf-8'?>
<yml_catalog date='" . $date . "'>
	<shop>
		<name>KULTURAKOVROV</name>
		<url>" . $site_url . "</url>
		<platform>1C-Bitrix</platform>
		<version>".SM_VERSION."</version>
		<currencies><currency id='RUB' rate='1'/></currencies>
		<categories>
		    " . $categories . "
        </categories>
		<offers>
			" . $offers . "
		</offers>
	</shop>
</yml_catalog>";
}



file_put_contents('feed-yandex-new.xml', $tmp);