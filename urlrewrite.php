<?php
$arUrlRewrite=array (
  9 => 
  array (
    'CONDITION' => '#^/partneram/dlya-dizaynerov/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/partneram/dlya-dizaynerov/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/catalog/([a-z0-9_\\-\\/]+)/#',
    'RULE' => 'SMART_FILTER_PATH=$1&',
    'ID' => '',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/o-kompanii/kollaboracii/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/o-kompanii/kollaboracii/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal/index.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
);
