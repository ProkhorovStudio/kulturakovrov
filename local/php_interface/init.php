<?php

AddEventHandler('main', 'onEpilog', function() {
    $requestUri = $_SERVER['REQUEST_URI'];
    $currentPage = $GLOBALS['APPLICATION']->GetCurPage(false); // URL без параметров

    // 2. Обработка фильтров (/filter/) — canonical = URL раздела без фильтра
    if (strpos($requestUri, '/filter/') !== false) {
        $canonicalUrl = preg_replace('~/filter/.*~', '', $requestUri);
        $canonicalUrl = 'https://kulturakovrov.ru' . rtrim($canonicalUrl, '/') . '/';
        $GLOBALS['APPLICATION']->SetPageProperty('canonical', $canonicalUrl);
        $GLOBALS['APPLICATION']->AddHeadString(
            '<meta name="robots" content="noindex, nofollow" />',
            true
        );
        return;
    }
    // 3. Для всех остальных страниц — текущий URL без параметров
    $GLOBALS['APPLICATION']->SetPageProperty('canonical', 'https://kulturakovrov.ru' . $currentPage);



    if (strpos($requestUri, 'PAGEN_') !== false) {
        // Удаляем стандартный тег robots (если есть)
        // Устанавливаем наш вариант
        $GLOBALS['APPLICATION']->AddHeadString(
            '<meta name="robots" content="noindex,follow" />',
            true
        );
    }
    else{
        $GLOBALS['APPLICATION']->AddHeadString(
            '<meta name="robots" content="index,follow" />',
            true
        );
    }




});

AddEventHandler("main", "OnPageStart", function() {
    // Проверяем наличие определённого GET-параметра
    if (isset($_GET['page'])) {
        CHTTP::SetStatus("404 Not Found");
        @define("ERROR_404","Y");
    }
});



AddEventHandler("main", "OnEpilog", "OnABCtoabc");
function OnABCtoabc(){
    $notBitrix = strpos($_SERVER['REQUEST_URI'], '/bitrix/');	//если это не админка
    $notBitrix1 = strpos($_SERVER['HTTP_HOST'], 'b24_link');	//если это не Б24
    $notBitrix2 = strpos($_SERVER['REQUEST_URI'], '=');	//и если нет GET параметров
    if ( $_SERVER['REQUEST_URI'] != strtolower( $_SERVER['REQUEST_URI']) && ($notBitrix || $notBitrix1 || $notBitrix2) === false) {
        header('Location: //'.$_SERVER['HTTP_HOST'] . strtolower($_SERVER['REQUEST_URI']), true, 301);
        exit();
    }
}


AddEventHandler('main', 'OnAfterCatalogFilterApply', function($count) {
    addMessage2Log('Пришло в init');
    addMessage2Log($count);
    $GLOBALS['CATALOG_FILTER_RESULT'] = array(
        'count' => $count
    );
});