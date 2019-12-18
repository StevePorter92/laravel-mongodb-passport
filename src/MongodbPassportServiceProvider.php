<?php

namespace StevePorter92\Mongodb;

use Illuminate\Auth\RequestGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\AccessTokenRepository as BridgeAccessTokenRepository;
use Laravel\Passport\Bridge\ClientRepository as BridgeClientRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository as BridgeRefreshTokenRepository;
use Laravel\Passport\ClientRepository as PassportClientRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\PersonalAccessTokenFactory as PassportPersonalAccessTokenFactory;
use Laravel\Passport\RefreshTokenRepository as PassportRefreshTokenRepository;
use Laravel\Passport\TokenRepository as PassportTokenRepository;
use League\OAuth2\Server\ResourceServer;
use StevePorter92\Mongodb\Bridge\AccessTokenRepository;
use StevePorter92\Mongodb\Bridge\ClientRepository;
use StevePorter92\Mongodb\Bridge\RefreshTokenRepository;
use StevePorter92\Mongodb\Passport\AuthCode;
use StevePorter92\Mongodb\Passport\Client;
use StevePorter92\Mongodb\Passport\ClientModelRepository;
use StevePorter92\Mongodb\Passport\PersonalAccessClient;
use StevePorter92\Mongodb\Passport\PersonalAccessTokenFactory;
use StevePorter92\Mongodb\Passport\RefreshToken;
use StevePorter92\Mongodb\Passport\RefreshTokenModelRepository;
use StevePorter92\Mongodb\Passport\Token;
use StevePorter92\Mongodb\Passport\TokenGuard;
use StevePorter92\Mongodb\Passport\TokenRepository;

class MongodbPassportServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Passport::useAuthCodeModel(AuthCode::class);
        Passport::useClientModel(Client::class);
        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);
        Passport::useRefreshTokenModel(RefreshToken::class);
        Passport::useTokenModel(Token::class);
    }

    public function register()
    {
        $this->app->bind(PassportClientRepository::class, ClientModelRepository::class);
        $this->app->bind(PassportTokenRepository::class, TokenRepository::class);
        $this->app->bind(PassportPersonalAccessTokenFactory::class, PersonalAccessTokenFactory::class);
        $this->app->bind(PassportRefreshTokenRepository::class, RefreshTokenModelRepository::class);
        $this->app->bind(BridgeClientRepository::class, ClientRepository::class);
        $this->app->bind(BridgeAccessTokenRepository::class, AccessTokenRepository::class);
        $this->app->bind(BridgeRefreshTokenRepository::class, RefreshTokenRepository::class);

        $this->registerGuard();
    }

    /**
     * Register the token guard.
     *
     * @return void
     */
    protected function registerGuard()
    {
        Auth::extend('passport', function ($app, $name, array $config) {
            return tap($this->makeGuard($config), function ($guard) {
                $this->app->refresh('request', $guard, 'setRequest');
            });
        });
    }

    /**
     * Make an instance of the token guard.
     *
     * @param  array  $config
     * @return RequestGuard
     */
    protected function makeGuard(array $config)
    {
        return new RequestGuard(function ($request) use ($config) {
            return (new TokenGuard(
                $this->app->make(ResourceServer::class),
                Auth::createUserProvider($config['provider']),
                $this->app->make(PassportTokenRepository::class),
                $this->app->make(PassportClientRepository::class),
                $this->app->make('encrypter')
            ))->user($request);
        }, $this->app['request']);
    }
}
