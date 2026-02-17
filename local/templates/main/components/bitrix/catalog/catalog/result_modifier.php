<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


/*Получаем теги(категории) для основной страницы каталога*/


$iblock_id = 3;

$obIblock = CIBlockElement::GetList (
    ["ID" => "ASC"],
    ["IBLOCK_ID" => $iblock_id, "ACTIVE" => "Y"],
    false,
    false,
    ['PROPERTY_ATT_TOP','PROPERTY_ATT_BOTTOM','PROPERTY_ATT_LINK','DETAIL_TEXT','PREVIEW_PICTURE']
);

if($arrSections = $obIblock->GetNext())
{
    $tagsList = [
        "TOP" => $arrSections['PROPERTY_ATT_TOP_VALUE'],
        "BOTTOM" => $arrSections['PROPERTY_ATT_BOTTOM_VALUE'],
        "DESCRIPTION" => [
            "TEXT" => $arrSections['DETAIL_TEXT'],
            "VIDEO_BG" => CFile::GetPath($arrSections['PREVIEW_PICTURE']),
            "LINK" => $arrSections['PROPERTY_ATT_LINK_VALUE']
        ],
    ];
}

if($tagsList['DESCRIPTION']){
    $arResult['SECTION_DESCRIPTION'] = $tagsList['DESCRIPTION'];
}

if($tagsList['TOP']){
    /*Получаем названия разделов и сссылок для них, вывод сверху*/

    $res = CIBlockSection::GetList(
        [],
        [   'IBLOCK_ID'=> 1,
            'ID' => $tagsList['TOP'],
        false,
        ['ID', 'NAME','SECTION_PAGE_URL']]
    );

    while($arItemSections = $res->GetNext()) {
        $sectionsTopList[] = [
            "NAME" => $arItemSections['NAME'],
            "URL" => $arItemSections['SECTION_PAGE_URL']
        ];;
    }
    if(!empty($sectionsTopList)){
        $arResult['TAGS_TOP'] = $sectionsTopList;
    }
}

if($tagsList['BOTTOM']){
    /*Получаем названия разделов и сссылок для них, вывод сверху*/

    $res = CIBlockSection::GetList(
        [],
        [   'IBLOCK_ID'=> 1,
            'ID' => $tagsList['BOTTOM'],
            false,
            ['ID', 'NAME','SECTION_PAGE_URL']]
    );

    while($arItemSections = $res->GetNext()) {
        $sectionsBottomList[] = [
            "NAME" => $arItemSections['NAME'],
            "URL" => $arItemSections['SECTION_PAGE_URL']
        ];;
    }
    if(!empty($sectionsBottomList)){
        $arResult['TAGS_BOTTOM'] = $sectionsBottomList;
    }
}

unset($tagsList,$arrSections,$obIblock,$sectionsBottomList,$sectionsTopList);








