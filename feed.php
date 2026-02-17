<?
ob_start();
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
$GLOBALS['APPLICATION']->RestartBuffer();
use Bitrix\Main\Loader;
use Ldo\Develop\Hlblock;

$date = date('Y-d-m H:i');

$site_url = 'https://kulturakovrov.ru/';
$iblock_id = 2;


CModule::IncludeModule('sale');
Loader::IncludeModule('ldo.develop');

if (CModule::IncludeModule('iblock')) {
    $arSelect_1 = array('ID', 'IBLOCK_SECTION_ID', 'NAME','PROPERTY_Kollektsiya','PROPERTY_Razmer_teh','PROPERTY_ARTICLE','PROPERTY_Style','PROPERTY_Proizvoditel','PROPERTY_Kollektsiya','PROPERTY_Method','PROPERTY_Material','PROPERTY_Tsvet');
    $arFilter_1 = array('IBLOCK_ID' => $iblock_id, 'ACTIVE' => 'Y', 'SECTION_ID' => [], "INCLUDE_SUBSECTIONS" => "Y");
    $row1 = CIBlockElement::GetList(array("ACTIVE_FROM" => "ASC"), $arFilter_1, false, array("nPageSize" => 1000), $arSelect_1);
    $offers = '';

    while ($mass_row1 = $row1->GetNextElement()) {
        $arFields = $mass_row1->GetFields();
        $arProps = $mass_row1->GetProperties();
        $mxResult = CCatalogSku::GetProductInfo(
            $arFields['ID']
        );

        $idProduct = $mxResult['ID'];


        $db_props = CIBlockElement::GetProperty(1, $idProduct, array("sort" => "asc"), Array("CODE"=>"MORE_PHOTO"));

        while($ar_props = $db_props->Fetch()){
            $images[] = CFile::GetPath($ar_props["VALUE"]);
        }


       if(!empty($arFields["PROPERTY_TSVET_VALUE"])){
          $colorsName = Hlblock::getNameByIds($arFields["PROPERTY_TSVET_VALUE"]);
           $colorsCorrectName =  implode("||",$colorsName);
       }

        $pattern = '/\s+[a-zA-Zа-яА-Я0-9]+$/u';
        $resultTitle = preg_replace($pattern, '', $arFields["NAME"]);

        // Убираем возможные двойные пробелы и пробелы в начале/конце
        $resultName = trim(preg_replace('/\s+/', ' ', $resultTitle));



        $price = Cprice::GetBasePrice($arFields["ID"]);
        $offers .= '<product id="' . $arFields["ID"] . '">
            <article>'.$arFields["PROPERTY_ARTICLE_VALUE"].'</article>
            <name>Ковер из коллекции ' . $resultName . '</name>
            <collection>'.$arFields["PROPERTY_STYLE_VALUE"].' ковры, серия '.$arFields["PROPERTY_KOLLEKTSIYA_VALUE"].'</collection>
            <material>'.$arFields["PROPERTY_MATERIAL_VALUE"].'</material>
            <colors>'.$colorsCorrectName.'</colors>
            <country>'.$arFields["PROPERTY_PROIZVODITEL_VALUE"].'</country>
            <production>'.$arFields["PROPERTY_METHOD_VALUE"].'</production>
            <price>'.$price['PRICE'].'</price>
            <size>'.$arFields["PROPERTY_RAZMER_TEH_VALUE"].'</size>
            '. implode("\n            ", array_map(function($img) {
                    return '<picture>https://kulturakovrov.ru'.$img.'</picture>';
                }, $images)) . '
    </product>'
        ;

        unset($images,$price,$colors,$colorsCorrectName,$imagesProduct,$resultName);
    }


    $tmp = "<?xml version='1.0' encoding='utf-8'?>
<yml_catalog date='" . $date . "'>
	<shop>
		<name>KULTURAKOVROV</name>
		<url>" . $site_url . "</url>
		<offers>
			" . $offers . "
		</offers>
	</shop>
</yml_catalog>";
}


file_put_contents('feed.xml', $tmp);

