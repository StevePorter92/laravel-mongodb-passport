<?php

namespace StevePorter92\Mongodb\Bridge;

use Laravel\Passport\Bridge\ClientRepository as BridgeClientRepository;
use StevePorter92\Mongodb\Passport\ClientModelRepository;

class ClientRepository extends BridgeClientRepository
{
    /**
     * Create a new repository instance.
     *
     * @param  \StevePorter92\Mongodb\Passport\ClientModelRepository  $clients
     * @return void
     */
    public function __construct(ClientModelRepository $clients)
    {
        $this->clients = $clients;
    }
}
