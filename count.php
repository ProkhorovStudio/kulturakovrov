<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Catalog\PriceTable;
use Bitrix\Main\Loader;

Loader::includeModule('catalog');
// Получаем цены товаров через ORM
$prices = PriceTable::getList([
    'select' => [
        'ID',
        'PRODUCT_ID', // это то что нам нужно!
        'CATALOG_GROUP_ID',
        'PRICE',
        'CURRENCY'
    ],
    'order' => [
        'PRODUCT_ID' => 'ASC'
    ],
    'filter' => array('PRICE' => 0),
]);

$productIds = []; // инициализируем массив

while ($price = $prices->fetch()) {
    $productIds[] = $price['PRODUCT_ID']; // используем PRODUCT_ID вместо ID
}

echo "<pre>";
print_r($productIds);
echo "</pre>";
/*

// Убираем дубликаты (на случай если у товара несколько цен)
$productIds = array_unique($productIds);

foreach ($productIds as $productId) {
    $arFields = array('QUANTITY' => 10);
    $result = CCatalogProduct::Update($productId, $arFields);
    echo "Product ID: " . $productId . " - Result: ";
    var_dump($result); // для отладки
}*/

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_after.php');