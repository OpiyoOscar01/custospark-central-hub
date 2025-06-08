<?php

namespace App\Repositories;

use App\Models\User;
use Laravel\Socialite\Contracts\User as SocialUser;
use Illuminate\Support\Str;

class SocialAuthRepository
{
    /**
     * Attempt to find a user by the social provider ID or by email.
     * Useful to match returning users even if provider ID is not stored.
     *
     * @param string $provider The social provider name (e.g., google, facebook).
     * @param string $providerId The unique ID from the provider.
     * @param string|null $email The email address provided by the provider.
     * @return User|null
     */
    public function findByProviderOrEmail(string $provider, string $providerId, ?string $email): ?User
    {
        return User::where("{$provider}_id", $providerId)
                    ->orWhere('email', $email)
                    ->first();
    }

    /**
     * Create a new user from the social provider’s user details.
     * Useful for registering users via Google or Facebook login.
     *
     * @param SocialUser $socialUser The user object returned from Socialite.
     * @param string $provider The provider name (used to store provider-specific ID).
     * @return User
     */
    public function createFromSocialProvider(SocialUser $socialUser, string $provider): User
    {
        // Attempt to split full name into first and last names
        $nameParts = explode(' ', $socialUser->getName());
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        // Create and return the user
        return User::create([
            'first_name'    => $firstName,
            'last_name'     => $lastName,
            'email'         => $socialUser->getEmail(),
            "{$provider}_id"=> $socialUser->getId(),
            'avatar_url'    => $socialUser->getAvatar(),
            'password'      => bcrypt(Str::random(16)), // random secure password (not used for login)
            'status'        => 'active',
        ]);
    }
}
