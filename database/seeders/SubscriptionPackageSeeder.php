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
                'description_ar' => 'خطة مناسبة للشركات الصغيرة.',
                'description_en' => 'خطة مناسبة للشركات الصغيرة.',
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
                'description_ar' => 'خطة مناسبة للشركات المتوسطة.',
                'description_en' => 'خطة مناسبة للشركات المتوسطة.',
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
                'description_ar' => 'خطة مخصصة للشركات الكبيرة.',
                'description_en' => 'خطة مخصصة للشركات الكبيرة.',
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