<?php

namespace app\controllers\api\v1;

use yii\base\Controller;
use yii\filters\auth\HttpBearerAuth;

abstract class BaseApiController extends Controller
{
    /**
     * @var string|array the configuration for creating the serializer that formats the response data.
     */
    public $serializer = 'yii\rest\Serializer';
    /**
     * {@inheritdoc}
     */
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'bearerAuth' => [
                'class' => HttpBearerAuth::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        return \Yii::createObject($this->serializer)->serialize($result);
    }
}