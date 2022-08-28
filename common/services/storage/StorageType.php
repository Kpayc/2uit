<?php

namespace app\common\services\storage;

use app\common\services\user\exceptions\UserTypeException;

/**
 * Enum класс для типа хранилища
 * Class StorageType
 * @package common\services\user
 */
class StorageType
{
    const MYSQL = 0;
    const CACHE = 1;
    const JSON = 2;
    const XLSX = 3;

    /**
     * @var int
     */
    private $type;

    /**
     * @return string[]
     */
    public static function list()
    {
        return [
            self::MYSQL => 'mysql',
            self::CACHE => 'cache',
            self::JSON => 'json',
            self::XLSX => 'xlsx',
        ];
    }

    /**
     * StorageType constructor.
     * @param $type
     * @throws UserTypeException
     */
    public function __construct($type)
    {
        if (!in_array($type, self::list())) {
            throw new UserTypeException('Неверный тип хранилища');
        }

        $this->type = array_flip(self::list())[$type];
    }

    /**
     * @return int
     */
    public function getType() : int
    {
        return $this->type;
    }
}