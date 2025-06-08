<?php
// app/Repositories/SubscriptionRepository.php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{
    public function create(array $data): Subscription
    {
        return Subscription::create($data);
    }

    public function update(Subscription $subscription, array $data): Subscription
    {
        $subscription->update($data);
        return $subscription;
    }

    public function delete(Subscription $subscription): void
    {
        $subscription->delete();
    }

    public function find(int $id): ?Subscription
    {
        return Subscription::findOrFail($id);
    }
}
