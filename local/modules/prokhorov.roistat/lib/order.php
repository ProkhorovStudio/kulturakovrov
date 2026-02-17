<?php

namespace Prokhorov\Roistat;
use Bitrix\Main\Application;
use Prokhorov\Roistat\RoistatServices;
use Bitrix\Main;
use Bitrix\Sale;
use Bitrix\Main\Context;
use Bitrix\Main\Loader;

Loader::includeModule("iblock");

class Order{
    public static function orderInfo($orderId, $arOrder, $arParams){

        if((int)$orderId)
        {
            $order = Sale\Order::load($orderId);

            $basket = $order->getBasket();

            $productNames = [];


            foreach ($basket->getBasketItems() as $product){
                $productNames[]  = [
                    "ART" => self::getArtikleById($product->getProductId()),
                    "NAME" => $product->getField('NAME')
                ];

            }


            $idOrder = $order->getId();

            $userId = $order->getUserId();



            if($idOrder > 1){

                $rsUser = \CUser::GetByID($userId);
                $arUser = $rsUser->Fetch();

                $siteData = $order->getSiteId();
                $rsSites = \CSite::GetByID($siteData);
                $arSite = $rsSites->Fetch();
                

                if($arSite['DOMAINS']){
                    $site = $arSite['DOMAINS'];
                }

                $userPhone = preg_replace('/[^\d]/', '', $arUser['PERSONAL_PHONE']);
                $userName = $arUser['LAST_NAME'].' '.$arUser['NAME'];
                $userEmail = $arUser['EMAIL'];
                $orderDescription = $order->getField('USER_DESCRIPTION');

                $arDataOrder = [
                    "ORDER_ID"   => $idOrder,
                    "USER_ID"    => $userId,
                    "ROISTAT_ID" => self::getRoistatId(),
                    "COMMENTS"   => $orderDescription,
                    "USER_NAME"  => $userName,
                    "USER_EMAIL" => $userEmail,
                    "USER_PHONE" => $userPhone,
                    "SITE_NAME"  => $site,
                    "TITLE_COVER" => $productNames[0]['NAME'],
                    "ART_COVER"  => $productNames[0]['ART'],
                ];
                
                $resultSend = RoistatServices::send($arDataOrder);

            }
        }
    }

    public static function getRoistatId(){


        $cookieValue = $_COOKIE['roistat_visit'];

        if($cookieValue) return $cookieValue;
    }


    public static function getArtikleById($productId){

        $db_props = \CIBlockElement::GetProperty(2, $productId, "sort", "asc", array("CODE" => "ARTICLE"));

        if ($ar_props = $db_props->Fetch())
        {
            return  $ar_props["VALUE"];
        }
    }


}