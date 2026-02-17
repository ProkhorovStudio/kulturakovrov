<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Личный кабинет");?>

<div  class="container">
<?$APPLICATION->SetTitle("Личный кабинет");?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.personal.section", 
	"personal", 
	[
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHECK_RIGHTS_PRIVATE" => "N",
		"CUSTOM_PAGES" => "",
		"CUSTOM_SELECT_PROPS" => [
		],
		"MAIN_CHAIN_NAME" => "",
		"NAV_TEMPLATE" => "",
		"ORDERS_PER_PAGE" => "20",
		"ORDER_DEFAULT_SORT" => "STATUS",
		"ORDER_DISALLOW_CANCEL" => "Y",
		"ORDER_HIDE_USER_INFO" => [
			0 => "0",
		],
		"ORDER_HISTORIC_STATUSES" => [
			0 => "F",
		],
		"ORDER_REFRESH_PRICES" => "N",
		"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => [
			0 => "0",
		],
		"PATH_TO_BASKET" => "/personal/cart/",
		"PATH_TO_CATALOG" => "/catalog/",
		"PATH_TO_CONTACT" => "/contacts/",
		"PATH_TO_PAYMENT" => "/personal/order/payment/",
		"SAVE_IN_SESSION" => "Y",
		"SEF_FOLDER" => "/personal/",
		"SEF_MODE" => "Y",
		"SEND_INFO_PRIVATE" => "N",
		"SET_TITLE" => "N",
		"SHOW_ACCOUNT_PAGE" => "Y",
		"SHOW_BASKET_PAGE" => "Y",
		"SHOW_CONTACT_PAGE" => "Y",
		"SHOW_ORDER_PAGE" => "Y",
		"SHOW_PRIVATE_PAGE" => "Y",
		"SHOW_PROFILE_PAGE" => "Y",
		"SHOW_SUBSCRIBE_PAGE" => "N",
		"COMPONENT_TEMPLATE" => "personal",
		"PROP_1" => [
		],
		"SEF_URL_TEMPLATES" => [
			"index" => "index.php",
			"orders" => "orders/",
			"account" => "account/",
			"subscribe" => "subscribe/",
			"profile" => "profiles/",
			"profile_detail" => "profiles/#ID#",
			"private" => "private/",
			"order_detail" => "orders/#ID#",
			"order_cancel" => "cancel/#ID#",
		]
	],
	false
);?>
</div>
<?php
if($USER->IsAuthorized()):
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3  col-md-4 col-12">
            <a href="/?logout=yes&<?=bitrix_sessid_get()?>" class="exit">Выйти</a>
        </div>
    </div>
</div>
<?php endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>