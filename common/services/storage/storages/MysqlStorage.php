<?php

namespace app\common\services\storage\storages;

use app\common\ar\User;
use app\common\services\storage\UserStorage;
use app\common\dto\UserDTO;

/**
 * Class MysqlStorage
 * @package app\common\services\storage\storages
 */
class MysqlStorage extends UserStorage
{
    /**
     * @param UserDTO $userDto
     * @return bool
     */
    public function store(UserDTO $userDto): bool
    {
        $user = new User();
        $user->user_id = $this->userId;
        $user->name = $userDto->getName();
        $user->email = $userDto->getEmail();
        $user->phone = $userDto->getPhone();
        return $user->save();
    }

    /**
     * @return UserDTO[]|null
     */
    public function list(): ?array
    {
        /** @var User[] $users */
        $users = User::find()->andWhere(['user_id' => $this->userId])->all();
        $userDtos = [];
        foreach ($users as $user) {
            $userDtos[] = new UserDTO(
                $user->name,
                $user->email,
                $user->phone
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
        return User::find()->andWhere(['user_id' => $this->userId, 'name' => $name])->exists();
    }
}