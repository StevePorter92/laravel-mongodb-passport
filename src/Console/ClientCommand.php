<?php

namespace StevePorter92\Mongodb\Console;

use Illuminate\Console\Command;
use StevePorter92\Mongodb\Passport\Client;
use StevePorter92\Mongodb\Passport\ClientModelRepository;

class ClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:client
            {--personal : Create a personal access token client}
            {--password : Create a password grant client}
            {--client : Create a client credentials grant client}
            {--name= : The name of the client}
            {--redirect_uri= : The URI to redirect to after authorization }
            {--user_id= : The user ID the client should be assigned to }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a client for issuing access tokens';

    /**
     * Execute the console command.
     *
     * @param  \StevePorter92\Mongodb\Passport\ClientModelRepository  $clients
     * @return void
     */
    public function handle(ClientModelRepository $clients)
    {
        if ($this->option('personal')) {
            $this->createPersonalClient($clients);
        } elseif ($this->option('password')) {
            $this->createPasswordClient($clients);
        } elseif ($this->option('client')) {
            $this->createClientCredentialsClient($clients);
        } else {
            $this->createAuthCodeClient($clients);
        }
    }

    /**
     * Create a new personal access client.
     *
     * @param  \StevePorter92\Mongodb\Passport\ClientModelRepository  $clients
     * @return void
     */
    protected function createPersonalClient(ClientModelRepository $clients)
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the personal access client?',
            config('app.name').' Personal Access Client'
        );

        $client = $clients->createPersonalAccessClient(
            null, $name, 'http://localhost'
        );

        $this->info('Personal access client created successfully.');

        $this->outputClientDetails($client);
    }

    /**
     * Create a new password grant client.
     *
     * @param  \StevePorter92\Mongodb\Passport\ClientModelRepository  $clients
     * @return void
     */
    protected function createPasswordClient(ClientModelRepository $clients)
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the password grant client?',
            config('app.name').' Password Grant Client'
        );

        $client = $clients->createPasswordGrantClient(
            null, $name, 'http://localhost'
        );

        $this->info('Password grant client created successfully.');

        $this->outputClientDetails($client);
    }

    /**
     * Create a client credentials grant client.
     *
     * @param  \StevePorter92\Mongodb\Passport\ClientModelRepository  $clients
     * @return void
     */
    protected function createClientCredentialsClient(ClientModelRepository $clients)
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the client?',
            config('app.name').' ClientCredentials Grant Client'
        );

        $client = $clients->create(
            null, $name, ''
        );

        $this->info('New client created successfully.');

        $this->outputClientDetails($client);
    }

    /**
     * Create a authorization code client.
     *
     * @param  \StevePorter92\Mongodb\Passport\ClientModelRepository  $clients
     * @return void
     */
    protected function createAuthCodeClient(ClientModelRepository $clients)
    {
        $userId = $this->option('user_id') ?: $this->ask(
            'Which user ID should the client be assigned to?'
        );

        $name = $this->option('name') ?: $this->ask(
            'What should we name the client?'
        );

        $redirect = $this->option('redirect_uri') ?: $this->ask(
            'Where should we redirect the request after authorization?',
            url('/auth/callback')
        );

        $client = $clients->create(
            $userId, $name, $redirect
        );

        $this->info('New client created successfully.');

        $this->outputClientDetails($client);
    }

    /**
     * Output the client's ID and secret key.
     *
     * @param  \StevePorter92\Mongodb\Passport\Client;  $client
     * @return void
     */
    protected function outputClientDetails(Client $client)
    {
        $this->line('<comment>Client ID:</comment> '.$client->id);
        $this->line('<comment>Client secret:</comment> '.$client->secret);
    }
}
