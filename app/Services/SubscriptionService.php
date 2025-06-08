<?php
// app/Services/SubscriptionService.php

namespace App\Services;

use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;

class SubscriptionService
{
    public function __construct(
        protected SubscriptionRepository $repository
    ) {}

    public function create(array $data): Subscription
    {
        return $this->repository->create($data);
    }

    public function update(Subscription $subscription, array $data): Subscription
    {
        return $this->repository->update($subscription, $data);
    }

    public function delete(Subscription $subscription): void
    {
        $this->repository->delete($subscription);
    }
    // app/Services/SubscriptionService.php

public function activate(Subscription $subscription): Subscription
{
    $subscription->activate();

    // Dispatch event or perform hook logic
    event(new \App\Events\SubscriptionActivated($subscription));

    return $subscription;
}

public function cancel(Subscription $subscription): Subscription
{
    $subscription->cancel();

    // Possibly notify user or trigger webhook
    // event(new \App\Events\SubscriptionCancelled($subscription));

    return $subscription;
}

public function renew(Subscription $subscription): Subscription
{
    $subscription->update([
        'renews_at' => now()->addMonth(),
        'ends_at' => now()->addMonth(),
    ]);

    // Log payment, generate invoice
    // event(new \App\Events\SubscriptionRenewed($subscription));

    return $subscription;
}

}

