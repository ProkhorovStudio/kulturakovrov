<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use \Ldo\Favorites\Favorites;
use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Main\Request,
    Bitrix\Main\Loader,
    Bitrix\Main\Server;

global $APPLICATION;

$context = Context::getCurrent();
$request = Context::getCurrent()->getRequest();



$name = $request->get("NAME");
$phone = $request->get("PHONE");

$idRois = isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : 'nocookie';


$titleCover = $request->get("titleKover");
$artikleCover = $request->get("artKover");

if($name && $phone){
    sendCrm($phone,$name,$idRois,$titleCover,$artikleCover);
}





function sendCrm($phone, $name,$idRois,$titleCover,$artikleCover){
        $roistatData = array(
            'roistat' => $idRois,
            'key'     => 'ZjA2NTBlNDA2ZmNkYmVmMWM2ZWFiNmNmNDM3NWRkMGE6MjU0MTI1', // Ключ для интеграции с CRM, указывается в настройках интеграции с CRM.
            'title'   => 'Заявка с сайта('.$_COOKIE['page'].')', // Название сделки
            'comment' => '', // Комментарий к сделке
            'name'    => $name, // Имя клиента
            'email'   => '', // Email клиента
            'phone'   => $phone, // Номер телефона клиента
            'order_creation_method' => '', // Способ создания сделки (необязательный параметр). Укажите то значение, которое затем должно отображаться в аналитике в группировке "Способ создания заявки"
            'is_need_callback' => '0',  // Если указано значение '1', на номер клиента будет инициироваться обратный звонок после создания заявки в Roistat (независимо от того, включен ли обратный звонок в Ловце лидов).
            //Если указано значение '0', для данной формы обратный звонок инициироваться не будет (даже если в Ловце лидов включен обратный звонок).
            'callback_phone' => '<Номер для переопределения>', // Переопределяет номер, указанный в настройках обратного звонка.
            'sync'    => '0', //
            'is_need_check_order_in_processing' => '1', // Настройка стандартной проверки заявок на дубли.
            // Если установлено значение '1', на дубли будут проверяться заявки за последние 12 часов только в статусах группы "В работе".
            // Если установлено значение '0', будут проверяться все заявки за последние 12 часов.
            // Данный параметр не участвует в пользовательской проверке на дубли.
            'is_need_check_order_in_processing_append' => '1', // Если создана дублирующая заявка, в нее будет добавлен комментарий об этом
            'is_skip_sending' => '0', // Не отправлять заявку в CRM.
            'fields'  => array(
                "lead_UTM_SOURCE" => $_COOKIE['utm_source'],
                "lead_UTM_MEDIUM" => $_COOKIE['utm_medium'],
                "lead_UTM_CAMPAIGN" => $_COOKIE['utm_campaign'],
                "lead_UTM_CONTENT" =>  $_COOKIE['utm_content'],
                "lead_UTM_TERM" => $_COOKIE['utm_term'],
                "lead_COMMENTS" => 'Источник перехода '.$_COOKIE['referer'],
                "lead_SOURCE_DESCRIPTION" => 'Заполнена форма на сайте('.$_COOKIE['page'].')',
                "lead_UF_CRM_1765593215286" => $artikleCover, //Артикул ковра
                "lead_UF_CRM_1765593607821" => $titleCover, //Название ковра
                // Массив дополнительных полей. Если дополнительные поля не нужны, оставьте массив пустым.
                // Примеры дополнительных полей смотрите в таблице ниже.
                // Помимо массива fields, который используется для сделки, есть еще массив client_fields, который используется для установки полей контакта.
                "charset" => "UTF-8", // Сервер преобразует значения полей из указанной кодировки в UTF-8.
            ),
        );

        $resultRoistat = file_get_contents("https://cloud.roistat.com/api/proxy/1.0/leads/add?" . http_build_query($roistatData));

        $result = json_decode($resultRoistat, true);

        if($result['status'] == 'success'){
            echo "200";
        }
        else{
            echo "400";
        }
}