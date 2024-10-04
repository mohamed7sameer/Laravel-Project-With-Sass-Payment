<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $basicPlan = Plan::create([
            'name' => 'Basic',
            'description' => 'Basic plan',
            'paddle_id' => 26163,
            'price' => 10.00,
            'interval' => 'month',
            'trial_period_days' => null,
            'sort_order' => 1,
        ]);

        $basicPlan->features()->saveMany([
            new PlanFeature(['name' => 'Invoices per day' , 'code' => 'invoices_per_day' , 'value' => 3 , 'sort_order' => 1]),
            new PlanFeature(['name' => 'Sending per day', 'code' => 'sending_per_day', 'value' => 1, 'sort_order' => 5]),
            new PlanFeature(['name' => 'Upload invoices', 'code' => 'upload_invoices', 'value' => false, 'sort_order' => 10]),
        ]);

        $basicYearlyPlan = Plan::create([
            'name' => 'Basic Year',
            'description' => 'Basic Year plan',
            'paddle_id' => 26841,
            'price' => 100.00,
            'interval' => 'year',
            'trial_period_days' => null,
            'sort_order' => 2,
        ]);

        $basicYearlyPlan->features()->saveMany([
            new PlanFeature(['name' => 'Invoices per day', 'code' => 'invoices_per_day', 'value' => 5, 'sort_order' => 1]),
            new PlanFeature(['name' => 'Sending per day', 'code' => 'sending_per_day', 'value' => 3, 'sort_order' => 5]),
            new PlanFeature(['name' => 'Upload invoices', 'code' => 'upload_invoices', 'value' => false, 'sort_order' => 10]),
        ]);

        $proPlan = Plan::create([
            'name' => 'Pro',
            'description' => 'Pro plan',
            'paddle_id' => 26162,
            'price' => 30.00,
            'interval' => 'month',
            'trial_period_days' => null,
            'sort_order' => 3,
        ]);

        $proPlan->features()->saveMany([
            new PlanFeature(['name' => 'Invoices per day', 'code' => 'invoices_per_day', 'value' => 100000, 'sort_order' => 1]),
            new PlanFeature(['name' => 'Sending per day', 'code' => 'sending_per_day', 'value' => 100000, 'sort_order' => 5]),
            new PlanFeature(['name' => 'Upload invoices', 'code' => 'upload_invoices', 'value' => 100000, 'sort_order' => 10]),
        ]);

        $proYearlyPlan = Plan::create([
            'name' => 'Pro Year',
            'description' => 'Pro Year plan',
            'paddle_id' => 26842,
            'price' => 300.00,
            'interval' => 'year',
            'trial_period_days' => null,
            'sort_order' => 4,
        ]);

        $proYearlyPlan->features()->saveMany([
            new PlanFeature(['name' => 'Invoices per day', 'code' => 'invoices_per_day', 'value' => 100000, 'sort_order' => 1]),
            new PlanFeature(['name' => 'Sending per day', 'code' => 'sending_per_day', 'value' => 100000, 'sort_order' => 5]),
            new PlanFeature(['name' => 'Upload invoices', 'code' => 'upload_invoices', 'value' => 100000, 'sort_order' => 10]),
        ]);

    }
}
