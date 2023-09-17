<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'slug' => 'basic-plan',
                'price' => '10',
                'description' => 'Basic Plan',
                'stripe_plan' => 'price_1NmcAAIHu769Aa1yGvKiDwSb',
            ],
            [
                'name' => 'Premium Plan',
                'slug' => 'premium-plan',
                'price' => '100',
                'description' => 'Premium Plan',
                'stripe_plan' => 'price_1Nmc9YIHu769Aa1yK9Ts25S3',
            ],
        ];
        foreach ($plans as $plan){
            Plan::create($plan);
        }
    }
}
