<?php

namespace StevePorter92\Mongodb\Passport;

use Laravel\Passport\PersonalAccessTokenFactory as PassportPersonalAccessTokenFactory;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;

class PersonalAccessTokenFactory extends PassportPersonalAccessTokenFactory
{
    /**
     * Create a new personal access token factory instance.
     *
     * @param  \League\OAuth2\Server\AuthorizationServer  $server
     * @param  \StevePorter92\Mongodb\Passport\ClientModelRepository  $clients
     * @param  \StevePorter92\Mongodb\Passport\TokenRepository  $tokens
     * @param  \Lcobucci\JWT\Parser  $jwt
     * @return void
     */
    public function __construct(AuthorizationServer $server,
                                ClientModelRepository $clients,
                                TokenRepository $tokens,
                                JwtParser $jwt)
    {
        $this->jwt = $jwt;
        $this->tokens = $tokens;
        $this->server = $server;
        $this->clients = $clients;
    }
}
