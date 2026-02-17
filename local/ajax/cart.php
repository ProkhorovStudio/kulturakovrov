<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use \Ldo\Develop\Basket;
use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Main\Request,
    Bitrix\Main\Loader,
    Bitrix\Main\Server;

/* Избранное */
global $APPLICATION;

if(Loader::IncludeModule('ldo.develop')){

    $context = Context::getCurrent();
    $request = Context::getCurrent()->getRequest();
    $idProduct = $request->get("id");

    if($idProduct){
        $userCart = new Basket();
        $result = $userCart->add($idProduct,1);

        echo json_encode($result);
    }

}