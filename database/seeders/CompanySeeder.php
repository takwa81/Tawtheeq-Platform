<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'name_ar' => 'فوديكس',
                'name_en' => 'Foodics',
                'logo' => 'foodics.png',
            ],
            [
                'name_ar' => 'جاهز',
                'name_en' => 'Jahez',
                'logo' => 'jahez.png',
            ],
            [
                'name_ar' => 'هنقرستيشن',
                'name_en' => 'HungerStation',
                'logo' => 'hungerstation.png',
            ],
            [
                'name_ar' => 'مرسول',
                'name_en' => 'Mrsool',
                'logo' => 'mrsool.png',
            ],
            [
                'name_ar' => 'ذا شيفز',
                'name_en' => 'The Chefs',
                'logo' => 'thechefs.jpg',
            ],
        ];

        foreach ($companies as $company) {
            Company::updateOrCreate(
                ['name_en' => $company['name_en']],
                $company
            );
        }
    }
}
