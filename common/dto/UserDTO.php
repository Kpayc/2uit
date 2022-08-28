<?php

namespace app\common\dto;

/**
 * Class UserDTO
 * @package common\dto
 */
class UserDTO implements \JsonSerializable
{
    private $name;
    private $email;
    private $phone;

    /**
     * UserDTO constructor.
     * @param $name
     * @param $email
     * @param $phone
     */
    public function __construct($name, $email, $phone)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}