<?php

namespace app\common\services\storage\storages;

use app\common\dto\UserDTO;
use app\common\services\storage\UserStorage;

class JsonStorage extends UserStorage
{
    /**
     * @param UserDTO $userDto
     * @return bool
     */
    public function store(UserDTO $userDto): bool
    {
        $users = $this->getUsers();
        $users[] = $userDto->jsonSerialize();
        return file_put_contents($this->getFilePath(), json_encode($users));
    }

    /**
     * @return array|null
     */
    public function list(): ?array
    {
        $userDtos = [];
        foreach ($this->getUsers() as $user) {
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
        foreach ($this->getUsers() as $user) {
            if ($user->name == $name) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     */
    private function getUsers(): array
    {
        if (!file_exists($this->getFilePath())) {
            return [];
        }
        $users = file_get_contents($this->getFilePath());
        return json_decode($users);
    }

    /**
     * @return string
     */
    private function getFilePath(): string
    {
        return \Yii::getAlias('@data/json/users/users-' . $this->userId . '.json');
    }
}