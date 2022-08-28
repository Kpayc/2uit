<?php

namespace app\common\services\storage\storages;

use app\common\dto\UserDTO;
use app\common\services\storage\UserStorage;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;

class XlsxStorage extends UserStorage
{
    /**
     * @param UserDTO $userDto
     * @return bool
     */
    public function store(UserDTO $userDto): bool
    {
        $users = $this->getUsers();
        $users[] = $userDto->jsonSerialize();
        $xlsx = SimpleXLSXGen::fromArray($users);
        return $xlsx->saveAs($this->getFilePath());
    }

    /**
     * @return array|null
     */
    public function list(): ?array
    {
        $userDtos = [];
        foreach ($this->getUsers() as $row => $user) {
            $userDtos[] = new UserDTO(
                $user[0],
                $user[1],
                $user[2]
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
        foreach ($this->getUsers() as $row => $user) {
            if ($user[0] == $name) {
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
        $simpleXLSX = SimpleXLSX::parseFile($this->getFilePath(), $debug = false);
        if (!$simpleXLSX) {
            return [];
        }
        return $simpleXLSX->rows();
    }

    /**
     * @return string
     */
    private function getFilePath(): string
    {
        return \Yii::getAlias('@data/xlsx/users/users-' . $this->userId . '.xlsx');
    }
}