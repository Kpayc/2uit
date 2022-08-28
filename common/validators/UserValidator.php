<?php

namespace app\common\validators;

use app\common\services\storage\UserStorage;
use yii\base\Model;

class UserValidator extends Model
{
    public $name;
    public $email;
    public $phone;

    private UserStorage $userStorage;

    /**
     * UserValidator constructor.
     * @param UserStorage $userStorage
     * @param array $config
     */
    public function __construct(UserStorage $userStorage, $config = [])
    {
        $this->userStorage = $userStorage;
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone'], 'required'],
            ['name', 'string'],
            ['name', function() {
                if ($this->userStorage->isNameExist($this->name)) {
                    return $this->addError('name', 'Данное ФИО уже используется');
                }
            }],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^([0-9]{11})$/'],
        ];
    }
}