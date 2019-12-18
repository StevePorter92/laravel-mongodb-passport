<?php

namespace StevePorter92\Mongodb\Bridge;

use Illuminate\Contracts\Events\Dispatcher;
use Laravel\Passport\Bridge\RefreshTokenRepository as BridgeRefreshTokenRepository;
use StevePorter92\Mongodb\Passport\RefreshTokenModelRepository;

class RefreshTokenRepository extends BridgeRefreshTokenRepository
{

    /**
     * Create a new repository instance.
     *
     * @param  \StevePorter92\Mongodb\Passport\RefreshTokenModelRepository  $refreshTokenRepository
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function __construct(RefreshTokenModelRepository $refreshTokenRepository, Dispatcher $events)
    {
        $this->events = $events;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }
}
