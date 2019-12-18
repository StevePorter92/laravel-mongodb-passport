<?php

namespace StevePorter92\Mongodb\Passport;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Encryption\Encrypter;
use Laravel\Passport\Guards\TokenGuard as GuardsTokenGuard;
use League\OAuth2\Server\ResourceServer;

class TokenGuard extends GuardsTokenGuard
{
    /**
     * Create a new token guard instance.
     *
     * @param  \League\OAuth2\Server\ResourceServer  $server
     * @param  \Illuminate\Contracts\Auth\UserProvider  $provider
     * @param  \StevePorter92\Mongodb\Passport\TokenRepository  $tokens
     * @param  \StevePorter92\Mongodb\Passport\ClientRepository  $clients
     * @param  \Illuminate\Contracts\Encryption\Encrypter  $encrypter
     * @return void
     */
    public function __construct(
        ResourceServer $server,
        UserProvider $provider,
        TokenRepository $tokens,
        ClientModelRepository $clients,
        Encrypter $encrypter
    ) {
        $this->server = $server;
        $this->tokens = $tokens;
        $this->clients = $clients;
        $this->provider = $provider;
        $this->encrypter = $encrypter;
    }
}
