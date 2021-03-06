<?php

namespace beardedandnotmuch\user\controllers;

use yii\filters\auth\HttpBearerAuth;
use beardedandnotmuch\user\filters\UpdateToken;
use yii\rest\Controller as BaseController;

class TokenController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        // we don't needs any predefined behaviors of this controller.
        return array_merge(parent::behaviors(), [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ],
            'updatetoken' => [
                'class' => UpdateToken::class,
            ],
        ]);
    }

    /**
     * Validate user's token.
     *
     * @return array
     * @throw \yii\web\ForbiddenHttpException
     */
    public function actionUpdate()
    {
        /*
         * @var yii\web\IdentityInterface
         */
        $identity = \Yii::$app->getUser()->getIdentity();

        // NOTE: at this point we already validate user's token
        // and authenticate them
        // all that's left to do is send correct response
        if (!$identity) {
            throw new \yii\web\ForbiddenHttpException('Access denied');
        }

        return ['result' => true];
    }
}
