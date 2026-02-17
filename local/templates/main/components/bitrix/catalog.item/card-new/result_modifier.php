<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


$arBasketItems = array();
$dbBasketItems = CSaleBasket::GetList(
    array(
    "NAME" => "ASC",
    "ID" => "ASC"
    ),
    array(
    "FUSER_ID" => CSaleBasket::GetBasketUserID(),
    "LID" => SITE_ID,
    "ORDER_ID" => "NULL"
    ),
    false,
    false,
    array("PRODUCT_ID")
    );
    while ($arItems = $dbBasketItems->Fetch())
    {
    $allBasketItems[] = $arItems['PRODUCT_ID'];
    }

    if($allBasketItems){
    $arResult['IS_CART'] = $allBasketItems;
    }

unset($allBasketItems);