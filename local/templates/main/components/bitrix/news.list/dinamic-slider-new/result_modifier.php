<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$iblock_id = 1;





foreach ($arResult["ITEMS"] as &$arItem){
    if(!empty($arItem['PROPERTIES']['ATT_PRODUCTS']['VALUE'])){
        foreach ($arItem['PROPERTIES']['ATT_PRODUCTS']['VALUE'] as $coverId){
           // $arItem['COVERS'][]  = CFile::GetPath($imageId);
            $obServ = CIBlockElement::GetList (
                ["ID" => "ASC"],
                ["IBLOCK_ID" => $iblock_id, "ACTIVE" => "Y", "ID" => $coverId],
                false,
                ["nTopCount"=>1],
                ['DETAIL_PAGE_URL','PROPERTY_MORE_PHOTO']
            );

            while($arServ = $obServ->GetNext())
            {
                if($arServ['PROPERTY_MORE_PHOTO_VALUE']){
                    $file = CFile::ResizeImageGet($arServ['PROPERTY_MORE_PHOTO_VALUE'], array('width'=>450, 'height'=>600), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                }

                $arItem['COVERS'][]= [
                    'LINK' => $arServ['DETAIL_PAGE_URL'],
                    'IMAGE' => $file['src']
                ];
            }
        }

        $arResult['DOTS-SLIDER'][] = [
            "ID" =>$arItem['ID'],
            "NAME" => $arItem['PROPERTIES']['ATT_TYPE_COVER']['VALUE']
        ];
    }

    unset($arServ);
}


