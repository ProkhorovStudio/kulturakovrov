<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
include_once(__DIR__.'/crest.php');
use Bitrix\Main\Loader;
use Prokhorov\b24\Iblockdata;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Type\Date;

if(in_array($_REQUEST['event'], ['0' => 'ONVOXIMPLANTCALLEND'])){

    $phone =  $_REQUEST['data']['PHONE_NUMBER'];

    addMessage2Log($phone);

    if($phone){
        $result = CRest::call(
            'crm.contact.list',
            [
                'FILTER' => [
                    'PHONE' => $phone,
                ],
                'SELECT' => [
                    'ID'
                ]
            ]
        );

        addMessage2Log($result);

        $idPeople = $result['result'][0]['ID'];

    }

    if($idPeople){
        $result = CRest::call('voximplant.statistic.get',
            [
                "SORT" => 'ID',
                "ORDER" => "DESC",
                "FILTER" => [
                    'CRM_ENTITY_ID' => $idPeople,
                    'REST_APP_ID' => '5', //Только из АТС МТС
                    'CRM_ENTITY_TYPE' => 'CONTACT', //те, что прикреплены к контакту
                    'CALL_TYPE' => '1' // Исходящие
                ]
            ]
        );

        addMessage2Log($result);

        /*Исключаем контакты без звонков*/

        if($result['total'] > 0){

            $dataCall = $result['result'][0]; // Получаем данные по последнему исходящему звонку

            addMessage2Log($dataCall);


            if($dataCall['CALL_DURATION'] > 25){ //Проверка длительности звонка, звонок должен быть более 25 секунд
                $dateCreateCall = $dataCall['CALL_START_DATE']; //Дата и время звонка с текущей датой

                $inputDate = Date::createFromPhp(\DateTime::createFromFormat('Y-m-d\TH:i:sP', $dateCreateCall));

                // Текущая дата (без времени)
                $thisDate = new Date();

                if($inputDate == $thisDate){//Если дата сегодняшняя
                   
                    /*Получаем список активных лидов*/
                    $result = CRest::call(
                        'crm.lead.list',
                        [
                            'select' => ['TITLE','ID','CONTACT_ID','STATUS_SEMANTIC_ID','DATE_CLOSED','HAS_IMOL'],
                            'start' => 50,
                            'filter' => [
                                'CONTACT_ID' => $idPeople,
                                'STATUS_SEMANTIC_ID' => 'P'
                            ]
                        ]
                    );

                    addMessage2Log($result);


                    /*Проверяем отсутствие активных лидов*/
                    if(empty($result['result'])){
                        
                        /*Получаем ID ответственного за контакт*/
                        $dataContact = CRest::call(
                            'crm.contact.get',
                            [
                                'ID' => $idPeople
                            ]
                        );

                        
                        $asignedId = $dataContact['result']['ASSIGNED_BY_ID'];
                        $phoneContact = $dataCall['PHONE_NUMBER'];

                        /*Создаем лид*/
                        $resultLead = CRest::call(
                            'crm.lead.add',
                            [
                                'fields' => [
                                    'TITLE' => 'Создан лид по исходящему звонку, исходящий на '.$dataCall['PHONE_NUMBER'],
                                    'STATUS_ID' => 'IN_PROCESS',
                                    'OPENED' => 'Y',
                                    'ASSIGNED_BY_ID' => $asignedId,
                                    'CONTACT_ID' => $idPeople
                                ]
                            ]
                        );
                    }
                }
            }
        }
    }

}


if(in_array($_REQUEST['event'], ['0' => 'ONCRMLEADUPDATE', '1' => 'ONCRMLEADADD']))
{

	$leadId = $_REQUEST['data']['FIELDS']['ID'];

	
	$datalead = CRest::call(
        'crm.lead.get',
        [
            'ID' => $leadId
        ]
    );
    
    if($datalead['result']['STATUS_ID'] == 'IN_PROCESS'){
        
        
        /*Смотрим историю звонков по ID лида*/
        $result = CRest::call('voximplant.statistic.get',
            [
                "SORT" => 'ID',
                "ORDER" => "DESC",
                "FILTER" => ['CRM_ENTITY_ID' => $leadId]
            ]
        );


        addMessage2Log('voximplant.statistic.get');
        addMessage2Log($result);
    
    

    $countCalls = $result['total'];
    
    /*Битрикс может привязывать звонок к лиду и к контакту, если не получили информацию из лида, пробуем получить их контакта*/
    /*if($countCalls == 0){
        $contactId = $datalead['result']['CONTACT_ID'];
        
        $result = CRest::call('voximplant.statistic.get',
            [
                "SORT" => 'ID',
                "ORDER" => "DESC",
                "FILTER" => ['CRM_ENTITY_ID' => $contactId]
            ]
        );
    }
    
    $countCalls = $result['total'];
    
    
    addMessage2Log($result);*/
    
    
    
    if($countCalls == 1 && $result['result'][0]['REST_APP_NAME'] == 'Автосекретарь 2.0'){
        
        $call_duration = $result['result'][0]['CALL_DURATION'];
        
        if($call_duration < 25){
            
            $fields = [
                'STATUS_ID' => '2',
                "OPENED" => 'N'
            ];
            
            $resultUpdate = CRest::call(
                'crm.lead.update',
                [
                    'id' => $leadId,
                    'fields' => $fields,
                ]    
            );
            
        }
        else{
            if(Loader::IncludeModule('prokhorov.b24')){
                $result = Iblockdata::add($leadId);
            }
        }
    }
    }

}


?>