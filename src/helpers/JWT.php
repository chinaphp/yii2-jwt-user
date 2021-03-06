<?php

namespace beardedandnotmuch\user\helpers;

use Yii;
use Exception;
use Lcobucci\JWT\Builder as JWTBuilder;
use Lcobucci\JWT\Signer\Hmac\Sha256 as Signer;

class JWT
{
    /**
     * undocumented function
     *
     * @return Lcobucci\JWT\Token;
     */
    public static function token($user, $duration = 3600)
    {
        $class = Yii::$app->getUser()->identityClass;

        if (!($user instanceof $class)) {
            throw new Exception("Argument should be instance of \"$class\"");
        }

        $now = time();
        $request = Yii::$app->getRequest();

        return (new JWTBuilder())
            ->setIssuer($request->hostInfo)
            ->setAudience($request->hostInfo)
            ->setId($user->id, true)
            ->setIssuedAt($now)
            ->setNotBefore($now)
            ->setExpiration($now + $duration)
            ->sign(new Signer(), $user->getSecretKey())
            ->getToken();
    }
}
