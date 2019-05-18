<?php
/**
 * Created by PhpStorm.
 * User: reactor123
 * Date: 5/18/2019
 * Time: 1:29 PM
 */

namespace Reactor\JWT;

use Firebase\JWT\JWT as FirebaseJWT;


class JWT
{

    public static function generateToken ($user, $claims = []) {

        $tokenId    = base64_encode('secret');
        $issuedAt   = time();
        $notBefore  = $issuedAt + 10;             //Adding 10 seconds
        $expire     = $notBefore + 60;            // Adding 60 seconds
        $serverName = 'example.com'; // Retrieve the server name from config file

        $userData = is_object($user) ?
            [
                'id' => $user->id,
                'email' => $user->email
            ] :
            $user;

        $token = [
            'jti' => $tokenId,
            'iss' => $serverName,
            'iat' => $issuedAt,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => $user
        ];

        if (count($claims)) {
            array_merge($token, $claims);
        }

        $generated = FirebaseJWT::encode(
            $token,
            'secret'
        );

        return $generated;

    }

    public static function refreshToken ($user) {

        return self::generateToken($user);

    }

}
