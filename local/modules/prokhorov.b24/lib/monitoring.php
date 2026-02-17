<?php
namespace Prokhorov\b24;
require_once($_SERVER['DOCUMENT_ROOT'] . '/apib24/crest.php');

class Monitoring
{

    protected static $idIblock = 4;
    
    public static function getList() {

        $date24HoursAgo = date('Y-m-d H:i:s', strtotime('-24 hours'));
       
        $result = \CRest::call(
            'crm.lead.list',
            [
                'select' => ['ID', 'TITLE','DATE_MODIFY','DATE_CREATE'],
                'filter' => [
                    'STATUS_ID' => 'IN_PROCESS',
                    '<DATE_MODIFY' => $date24HoursAgo,
                ],
            ]
        );

        if(!empty($result['result'])){
            self::closeLeads($result['result']);
        }

    }
    
    
    public static function getLeads(){
        
        $listElements = self::getList();
        return "\\".__METHOD__."();";
    }

    public static function closeLeads($arrLeads){

        if(!is_array($arrLeads)){
            addMessage2Log('В метод закрытия лидов пришли некорректные данные');
            return false;
        }

        addMessage2Log($arrLeads);

        foreach ($arrLeads as $lead) {

            $fields = [
                'STATUS_ID' => '2',
                "OPENED" => 'N'
            ];
            
            $resultUpdate = \CRest::call(
                'crm.lead.update',
                [
                    'id' => $lead['ID'],
                    'fields' => $fields,
                ]    
            );
        }
    }

}


