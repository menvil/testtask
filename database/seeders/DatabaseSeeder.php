<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Rinvex\Subscriptions\Models\PlanFeature;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Schema::disableForeignKeyConstraints();
        $tableNames = [
            'plan_subscription_usage',
            'plan_subscriptions',
            'plan_features',
            'plans',
            'webhook_calls',
            'users',
        ];
        foreach ($tableNames as $name) {
            if ($name == 'migrations') {
                continue;
            }
            \DB::table($name)->truncate();
        }

        \Schema::enableForeignKeyConstraints();

        $plan = app('rinvex.subscriptions.plan')->create([
            'name' => 'Pro',
            'description' => 'Pro plan',
            'price' => 9.99,
            'signup_fee' => 1.99,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'sort_order' => 1,
            'currency' => 'USD',
        ]);

        // Create multiple plan features at once
        $plan->features()->saveMany([
            new PlanFeature(['name' => 'listings', 'value' => 50, 'sort_order' => 1, 'plan_id'  => $plan->id]),
            new PlanFeature(['name' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]),
            new PlanFeature(['name' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            new PlanFeature(['name' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
        ]);


        $plan = app('rinvex.subscriptions.plan')->create([
            'name' => 'Mini',
            'description' => 'Min plan',
            'price' => 1.99,
            'signup_fee' => 0.99,
            'invoice_period' => 1,
            'invoice_interval' => 'month',
            'trial_period' => 15,
            'trial_interval' => 'day',
            'sort_order' => 1,
            'currency' => 'USD',
        ]);

        // Create multiple plan features at once
        $plan->features()->saveMany([
            new PlanFeature(['name' => 'listings', 'value' => 50, 'sort_order' => 1, 'plan_id'  => $plan->id]),
            new PlanFeature(['name' => 'pictures_per_listing', 'value' => 10, 'sort_order' => 5]),
            new PlanFeature(['name' => 'listing_duration_days', 'value' => 30, 'sort_order' => 10, 'resettable_period' => 1, 'resettable_interval' => 'month']),
            new PlanFeature(['name' => 'listing_title_bold', 'value' => 'Y', 'sort_order' => 15])
        ]);

        \App\Models\User::factory(2)->create();

    }
}
