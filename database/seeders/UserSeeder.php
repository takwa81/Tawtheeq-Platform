<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['phone' => '0981413522'],
            [
                'full_name' => 'Takwa',
                'email' => 'takwasyr81@gmail.com',
                'password' => Hash::make('Takwa123@#$'),
                'role' => 'super_admin',
                'status' => 'active',
            ]
        );

        User::updateOrCreate(
            ['email' => 'baraa@gmail.com'],
            [
                'full_name' => 'Baraa Mohammad',
                'phone' => '598518801',
                'password' => Hash::make('Baraa123@#$'),
                'role' => 'super_admin',
                'status' => 'active',
            ]
        );

        $this->command->info('✅ Super Admin users seeded successfully!');
    }
}