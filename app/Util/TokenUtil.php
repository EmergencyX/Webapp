<?php

namespace EmergencyExplorer\Util;

use Carbon\Carbon;
use EmergencyExplorer\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Encryption\Encrypter;

class TokenUtil
{
    /**
     * @var Encrypter
     */
    protected $encrypter;

    /**
     * TokenUtil constructor.
     * @param Encrypter $encrypter
     */
    public function __construct(Encrypter $encrypter)
    {
        $this->encrypter = $encrypter;
    }

    public static function getTokens()
    {
        return [
            //Image
            'access-images' => trans('token.access-images'),

            //Project
            'access-projects' => trans('token.access-projects'),

            //Release
            'access-release' => trans('token.access-release'),
        ];
    }

    public function generateTusToken(Authenticatable $user): string
    {
        return $this->encrypter->encrypt(JWT::encode([
            'sub' => $user->getAuthIdentifier(),
            'csrf' => csrf_token(),
            'expiry' => Carbon::now()->addHours(3),
        ], $this->encrypter->getKey()));
    }

    public function decodeTusToken(string $token): User
    {
        $decrypted = (array)JWT::decode(
            $this->encrypter->decrypt($token),
            $this->encrypter->getKey(), ['HS256']
        );

        return User::findOrFail($decrypted['sub'])->first();
    }
}