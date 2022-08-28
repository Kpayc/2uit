<?php

namespace app\common\services\storage\storages;

use app\common\services\storage\UserStorage;
use app\common\dto\UserDTO;
use yii\caching\CacheInterface;

class CacheStorage extends UserStorage
{
    /**
     * @var CacheInterface
     */
    private CacheInterface $cache;

    public function __construct($userId)
    {
        parent::__construct($userId);
        $this->cache = \Yii::$app->getCache();
    }

    /**
     * @return string
     */
    private function getKey()
    {
        return 'users-' . $this->userId;
    }

    /**
     * @param UserDTO $userDto
     * @return bool
     */
    public function store(UserDTO $userDto): bool
    {
        $users = $this->cache->get($this->getKey());
        $users[$userDto->getName()] = $userDto->jsonSerialize();
        return $this->cache->set($this->getKey(), $users);
    }

    /**
     * @return array|null
     */
    public function list(): ?array
    {
        $users = $this->cache->get($this->getKey());
        if (!$users) {
            return [];
        }
        $userDtos = [];
        foreach ($users as $user) {
            $userDtos[] = new UserDTO(
                $user['name'],
                $user['email'],
                $user['phone']
            );
        }
        return $userDtos;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isNameExist(string $name): bool
    {
        $users = $this->cache->get($this->getKey());
        return isset($users[$name]);
    }
}