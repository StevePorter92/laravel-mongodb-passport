<?php

namespace StevePorter92\Mongodb\Passport;

use Laravel\Passport\Passport;

class RefreshTokenModelRepository
{
    /**
     * Creates a new refresh token.
     *
     * @param  array  $attributes
     * @return \StevePorter92\Mongodb\Passport\RefreshToken
     */
    public function create($attributes)
    {
        return Passport::refreshToken()->create($attributes);
    }

    /**
     * Gets a refresh token by the given ID.
     *
     * @param  string  $id
     * @return \StevePorter92\Mongodb\Passport\RefreshToken
     */
    public function find($id)
    {
        return Passport::refreshToken()->where('id', $id)->first();
    }

    /**
     * Stores the given token instance.
     *
     * @param  \StevePorter92\Mongodb\Passport\RefreshToken  $token
     * @return void
     */
    public function save(RefreshToken $token)
    {
        $token->save();
    }

    /**
     * Revokes the refresh token.
     *
     * @param  string  $id
     * @return mixed
     */
    public function revokeRefreshToken($id)
    {
        return Passport::refreshToken()->where('id', $id)->update(['revoked' => true]);
    }

    /**
     * Checks if the refresh token has been revoked.
     *
     * @param  string  $id
     * @return bool
     */
    public function isRefreshTokenRevoked($id)
    {
        if ($token = $this->find($id)) {
            return $token->revoked;
        }

        return true;
    }
}
