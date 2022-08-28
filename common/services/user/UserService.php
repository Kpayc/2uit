<?php

namespace app\common\services\user;

use app\common\services\storage\storages\CacheStorage;
use app\common\services\storage\storages\JsonStorage;
use app\common\services\storage\storages\MysqlStorage;
use app\common\services\storage\storages\XlsxStorage;
use app\common\services\storage\StorageType;
use app\common\services\storage\UserStorage;
use app\common\services\user\exceptions\UserTypeException;

class UserService
{
    /**
     * @param StorageType $storageType
     * @param int $userId
     * @return UserStorage
     * @throws UserTypeException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function getUserStorage(StorageType $storageType, int $userId) : UserStorage
    {
        switch ($storageType->getType()) {
            case StorageType::MYSQL:
                return new MysqlStorage($userId);
                break;
            case StorageType::CACHE:
                return new CacheStorage($userId);
                break;
            case StorageType::JSON:
                return new JsonStorage($userId);
                break;
            case StorageType::XLSX:
                return new XlsxStorage($userId);
                break;
            default:
                throw new UserTypeException('Не инициализирован класс для данного типа хранилища');
                break;
        }
    }
}