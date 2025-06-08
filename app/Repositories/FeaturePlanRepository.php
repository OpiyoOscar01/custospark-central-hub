<?php
// app/Repositories/FeaturePlanRepository.php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class FeaturePlanRepository
{
    public function syncFeaturesToPlan($planId, array $features)
    {
        // $features = [
        //     feature_id => ['value' => 'Unlimited'],
        //     ...
        // ];
        DB::table('feature_plan')->where('plan_id', $planId)->delete();
        $formatted = [];

        foreach ($features as $featureId => $meta) {
            $formatted[$featureId] = ['value' => $meta['value'], 'created_at' => now(), 'updated_at' => now()];
        }

        DB::table('feature_plan')->insert(array_map(function ($featureId, $data) use ($planId) {
            return [
                'feature_id' => $featureId,
                'plan_id' => $planId,
                'value' => $data['value'],
                'created_at' => $data['created_at'],
                'updated_at' => $data['updated_at'],
            ];
        }, array_keys($formatted), $formatted));
    }
}
