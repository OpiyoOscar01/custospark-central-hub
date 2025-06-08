<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use App\Models\Plan;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class ApplyScheduledDowngrades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:apply-scheduled-downgrades';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Applies scheduled subscription downgrades when their current plan expires';

    /**
     * Execute the console command.
     */
  

public function handle()
{
    $today = now()->startOfDay();

    $subscriptions = Subscription::whereNotNull('next_plan_id')
        ->whereDate('ends_at', '<=', $today)
        ->where('next_plan_payment_status', 'paid')
        ->get();

    foreach ($subscriptions as $subscription) {
        $oldPlan = $subscription->plan;
        $newPlan = Plan::find($subscription->next_plan_id);

        if ($newPlan) {
            $subscription->update([
                'plan_id' => $newPlan->id,
                'next_plan_id' => null,
                'renews_at' => now()->addMonth(),
                'ends_at' => now()->addMonth(),
            ]);

            app(NotificationService::class)->sendNotification(
                'Downgrade Applied',
                'Your plan has been downgraded to ' . $newPlan->name . ' as scheduled.',
                'user',
                'both',
                $subscription->user_id
            );

            Log::info('[Scheduler] Downgrade applied', [
                'user_id' => $subscription->user_id,
                'old_plan' => $oldPlan->name,
                'new_plan' => $newPlan->name
            ]);
        }
    }

    $this->info('Scheduled downgrades processed.');
}

}
