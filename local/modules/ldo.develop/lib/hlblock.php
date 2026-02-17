<?php
namespace Ldo\Develop;

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;


class Hlblock
{
    private static $hlblockTableName = 'b_hlbd_colors';

    // Убираем статический кэш для разных сущностей
    private static $entities = [];

    public static function getImageByIds($arrCodes)
    {
        if (!Loader::includeModule('highloadblock')) {
            return [];
        }

        $entity = self::getHLEntity();
        if (!$entity) {
            return [];
        }

        // Получаем все записи + файлы за 1 запрос
        $records = $entity::getList([
            'select' => ['UF_XML_ID', 'UF_FILE'],
            'filter' => ['UF_XML_ID' => $arrCodes]
        ])->fetchAll();

        // Собираем ID файлов
        $fileIds = array_column($records, 'UF_FILE', 'UF_XML_ID');

        // Получаем все файлы за 1 запрос
        $fileUrls = [];
        if (!empty($fileIds)) {
            $files = \CFile::GetList([], ['@ID' => array_values($fileIds)]);
            while ($file = $files->Fetch()) {
                $fileUrls[$file['ID']] = \CFile::GetFileSRC($file);
            }
        }

        // Сопоставляем CODE с URL
        $result = [];
        foreach ($fileIds as $code => $fileId) {
            $result[$code] = $fileUrls[$fileId] ?? '';
        }

        return $result;
    }

    public static function getDeclensionByName($name)
    {
        if (!Loader::includeModule('highloadblock')) {
            return [];
        }

        $entity = self::getHLEntity('sklonenie_material');
        if (!$entity) {
            return [];
        }

        $materialName = $entity::getList([
            'select' => ['UF_MATERIAL', 'UF_SKLONENIE'],
            'filter' => ['UF_MATERIAL' => $name]
        ])->Fetch();

        if ($materialName['UF_SKLONENIE']) {
            return $materialName['UF_SKLONENIE'];
        }

        return null;
    }

    public static function getDeclensionByStyle($name)
    {
        if (!Loader::includeModule('highloadblock')) {
            return [];
        }

        $entity = self::getHLEntity('sklonenie_style');
        if (!$entity) {
            return [];
        }

        $materialName = $entity::getList([
            'select' => ['UF_STYLE', 'UF_SKLONENIE'],
            'filter' => ['UF_STYLE' => $name]
        ])->Fetch();

        if ($materialName['UF_SKLONENIE']) {
            return $materialName['UF_SKLONENIE'];
        }

        return null;
    }

    public static function getImageByNames($arrNames)
    {
        if (!Loader::includeModule('highloadblock')) {
            return [];
        }

        $entity = self::getHLEntity();
        if (!$entity) {
            return [];
        }

        // Получаем все записи + файлы за 1 запрос
        $records = $entity::getList([
            'select' => ['UF_NAME', 'UF_FILE'],
            'filter' => ['UF_NAME' => $arrNames]
        ])->fetchAll();

        // Собираем ID файлов
        $fileIds = array_column($records, 'UF_FILE', 'UF_NAME');

        // Получаем все файлы за 1 запрос
        $fileUrls = [];
        if (!empty($fileIds)) {
            $files = \CFile::GetList([], ['@ID' => array_values($fileIds)]);
            while ($file = $files->Fetch()) {
                $fileUrls[$file['ID']] = \CFile::GetFileSRC($file);
            }
        }

        // Сопоставляем CODE с URL
        $result = $fileUrls;

        return $result;
    }

    public static function getImageAndNameByNames($arrNames)
    {
        if (!Loader::includeModule('highloadblock')) {
            return [];
        }

        $entity = self::getHLEntity();
        if (!$entity) {
            return [];
        }

        // Получаем все записи + файлы за 1 запрос
        $records = $entity::getList([
            'select' => ['UF_NAME', 'UF_FILE'],
            'filter' => ['UF_NAME' => $arrNames]
        ])->fetchAll();

        // Собираем ID файлов
        $fileIds = array_column($records, 'UF_FILE', 'UF_NAME');

        // Получаем все файлы за 1 запрос
        $fileData = [];
        if (!empty($fileIds)) {
            $files = \CFile::GetList([], ['@ID' => array_values($fileIds)]);
            while ($file = $files->Fetch()) {
                $fileData[$file['ID']] = [
                    'url' => \CFile::GetFileSRC($file),
                    'name' => $file['ORIGINAL_NAME'] // или 'FILE_NAME' в зависимости от того, что вам нужно
                ];
            }
        }

        // Сопоставляем NAME с данными файла
        $result = [];
        foreach ($fileIds as $name => $fileId) {
            if (isset($fileData[$fileId])) {
                $result[$name] = [
                    'url' => $fileData[$fileId]['url'],
                    'name' => $name // название из highloadblock
                ];
            }
        }

        return $result;
    }

    public static function getNameByIds(array $arrCodes): array
    {
        if (!Loader::includeModule('highloadblock')) {
            return [];
        }

        $entity = self::getHLEntity();

        if (!$entity) {
            return [];
        }

        $records = $entity::getList([
            'select' => ['UF_XML_ID', 'UF_NAME'],
            'filter' => ['UF_XML_ID' => $arrCodes]
        ])->fetchAll();

        return array_column($records, 'UF_NAME');
    }

    private static function getHLEntity($tableName = null)
    {
        if ($tableName === null) {
            $tableName = self::$hlblockTableName;
        }

        // Используем массив для кэширования разных сущностей
        if (!isset(self::$entities[$tableName])) {
            if (!Loader::includeModule('highloadblock')) {
                return null;
            }

            $hlblock = HL\HighloadBlockTable::getRow([
                'filter' => ['=TABLE_NAME' => $tableName]
            ]);

            if ($hlblock) {
                self::$entities[$tableName] = HL\HighloadBlockTable::compileEntity($hlblock)->getDataClass();
            } else {
                self::$entities[$tableName] = null;
            }
        }

        return self::$entities[$tableName];
    }
}

