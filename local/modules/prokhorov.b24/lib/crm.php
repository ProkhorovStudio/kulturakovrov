<?php
namespace Prokhorov\b24;

use \Prokhorov\b24\Iblockdata;
require_once($_SERVER['DOCUMENT_ROOT'] . '/apib24/crest.php');


class Crm
{

    public static function updateLeads($data){
       foreach($data as $lead){
           $datalead = \CRest::call(
                'crm.lead.get',
                [
                    'ID' => $lead['NAME']
                ]
        );
        
       
        
            if($datalead['result']['STATUS_ID'] == 'IN_PROCESS'){
               /*Меняем стадию*/
            }else{
                /*Удаляем из системы*/
                $result = Iblockdata::delete($lead['ID']);
            }
           unset($datalead); 
       }
   
    }

   

}


