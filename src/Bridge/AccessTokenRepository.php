<?php

namespace StevePorter92\Mongodb\Bridge;

use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Passport\Bridge\AccessTokenRepository as BridgeAccessTokenRepository;
use StevePorter92\Mongodb\Passport\TokenRepository;

class AccessTokenRepository extends BridgeAccessTokenRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  \StevePorter92\Mongodb\Passport\TokenRepository  $tokenRepository
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     */
    public function __construct(TokenRepository $tokenRepository, Dispatcher $events)
    {
        $this->events = $events;
        $this->tokenRepository = $tokenRepository;
    }
}
