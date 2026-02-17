<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__DIR__ . '/user_consent.php');
$config = \Bitrix\Main\Web\Json::encode($arResult['CONFIG']);

$linkClassName = 'main-user-consent-request-announce';
if ($arResult['URL'])
{
	$url = htmlspecialcharsbx(\CUtil::JSEscape($arResult['URL']));
	$label = htmlspecialcharsbx($arResult['LABEL']);
	$label = explode('%', $label);
	$label = implode('', array_merge(
		array_slice($label, 0, 1),
		['<a href="' . $url  . '" target="_blank">'],
		array_slice($label, 1, 1),
		['</a>'],
		array_slice($label, 2)
	));
}
else
{
	$label = htmlspecialcharsbx($arResult['INPUT_LABEL']);
	$linkClassName .= '-link';
}
?>



<div class="error-block-lisense"></div>
    <label data-bx-user-consent="<?=htmlspecialcharsbx($config)?>" class="main-user-consent-request" for="lisense">
        <input id="lisense" required type="checkbox" value="Y" <?=($arParams['IS_CHECKED'] ? 'checked' : '')?> name="lisense">
        <span>Нажимая на кнопку "Оформить заказ", я даю <a target="_blank" href="/soglasie-na-obrabotku-pd/">согласие на обработку моих персональных данных</a>, в соответствии с <a target="_blank" href="/politika-pd/">политикой</a> и принимаю <a target="_blank" href="/oferta/">условия оферты</a></span>
    </label>



