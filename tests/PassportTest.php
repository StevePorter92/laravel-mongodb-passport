<?php

namespace StevePorter92\Mongodb\Tests;

use Laravel\Passport\Passport;
use PHPUnit\Framework\TestCase;
use StevePorter92\Mongodb\Passport\AuthCode;
use StevePorter92\Mongodb\Passport\Client;
use StevePorter92\Mongodb\Passport\PersonalAccessClient;
use StevePorter92\Mongodb\Passport\RefreshToken;
use StevePorter92\Mongodb\Passport\Token;

class PassportTest extends TestCase
{
    public function test_auth_code_instance_can_be_created()
    {
        Passport::useAuthCodeModel(AuthCode::class);
        $authCode = Passport::authCode();

        $this->assertInstanceOf(AuthCode::class, $authCode);
        $this->assertInstanceOf(Passport::authCodeModel(), $authCode);
    }

    public function test_client_instance_can_be_created()
    {
        Passport::useClientModel(Client::class);
        $client = Passport::client();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertInstanceOf(Passport::clientModel(), $client);
    }

    public function test_personal_access_client_instance_can_be_created()
    {
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
        $client = Passport::personalAccessClient();

        $this->assertInstanceOf(PersonalAccessClient::class, $client);
        $this->assertInstanceOf(Passport::personalAccessClientModel(), $client);
    }


    public function test_token_instance_can_be_created()
    {
        Passport::useTokenModel(Token::class);
        $token = Passport::token();

        $this->assertInstanceOf(Token::class, $token);
        $this->assertInstanceOf(Passport::tokenModel(), $token);
    }

    public function test_refresh_token_instance_can_be_created()
    {
        Passport::useRefreshTokenModel(RefreshToken::class);
        $refreshToken = Passport::refreshToken();

        $this->assertInstanceOf(RefreshToken::class, $refreshToken);
        $this->assertInstanceOf(Passport::refreshTokenModel(), $refreshToken);
    }
}
