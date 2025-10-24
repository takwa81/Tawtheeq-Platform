<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionPackage;

class SubscriptionPackageSeeder extends Seeder
{
    public function run(): void
    {

        SubscriptionPackage::insert([
            [
                'name_en' => 'Basic',
                'name_ar' => 'الأساسية',
                'description' => 'خطة مناسبة للشركات الصغيرة.',
                'branches_limit' => 1,
                'price' => 29.99,
                'duration_days' => 30,
                'features' => json_encode(['1 فرع', 'دعم أساسي']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Pro',
                'name_ar' => 'المتقدمة',
                'description' => 'خطة مناسبة للشركات المتوسطة.',
                'branches_limit' => 5,
                'price' => 99.99,
                'duration_days' => 90,
                'features' => json_encode(['5 فروع', 'دعم مميز']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_en' => 'Enterprise',
                'name_ar' => 'الشركات',
                'description' => 'خطة مخصصة للشركات الكبيرة.',
                'branches_limit' => 20,
                'price' => 299.99,
                'duration_days' => 365,
                'features' => json_encode(['20 فرع', 'دعم VIP']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
