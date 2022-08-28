<?php

namespace app\common\services\storage;

use app\common\dto\UserDTO;

/**
 * Class UserStorage
 * @package app\common\services\storage
 * @param $userId
 */
abstract class UserStorage
{
    /**
     * @var int
     */
    protected int $userId;

    /**
     * UserStorage constructor.
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param UserDTO $userDto
     * @return bool
     */
    abstract public function store(UserDTO $userDto) : bool;

    /**
     * @return UserDTO[]|null
     */
    abstract public function list() : ?array;

    /**
     * @param string $name
     * @return bool
     */
    abstract public function isNameExist(string $name) : bool;
}