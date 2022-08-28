<?php

namespace app\controllers\api\v1;

use app\common\services\storage\StorageType;
use app\common\services\user\exceptions\UserTypeException;
use app\common\services\user\UserService;
use app\common\validators\UserValidator;
use app\common\dto\UserDTO;
use yii\base\DynamicModel;
use yii\base\Model;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class UserController extends BaseApiController
{
    public function behaviors()
    {
        $behaviors = [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'store'  => ['POST'],
                    'list'   => ['GET'],
                ],
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];

        return array_merge($behaviors, parent::behaviors());
    }

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * UserController constructor.
     * @param $id
     * @param $module
     * @param UserService $userService
     * @param array $config
     */
    public function __construct($id, $module, UserService $userService, $config = [])
    {
        $this->userService = $userService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @return Model|void
     * @throws \yii\base\InvalidConfigException
     */
    public function actionStore()
    {
        try {
            $userStorage = $this->userService->getUserStorage(
                new StorageType(\Yii::$app->request->get('type')),
                \Yii::$app->user->identity->getId()
            );
        } catch (UserTypeException $e) {
            $dynamicModel = new DynamicModel();
            $dynamicModel->addError('type', $e->getMessage());
            return $dynamicModel;
        }

        $validator = new UserValidator($userStorage);
        $validator->setAttributes(\Yii::$app->getRequest()->getBodyParams());
        if ($validator->validate()) {
            if ($userStorage->store(new UserDTO(
                $validator->name,
                $validator->email,
                $validator->phone
            ))) {
                return \Yii::$app->response->setStatusCode(204)->send();
            }
        }

        return $validator;
    }

    /**
     * @return UserDTO[]|Model|null
     */
    public function actionList()
    {
        try {
            $userStorage = $this->userService->getUserStorage(
                new StorageType(\Yii::$app->request->get('type')),
                \Yii::$app->user->identity->getId()
            );
        } catch (UserTypeException $e) {
            $dynamicModel = new DynamicModel();
            $dynamicModel->addError('type', $e->getMessage());
            return $dynamicModel;
        }

        return $userStorage->list();
    }
}