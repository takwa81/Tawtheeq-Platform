<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BranchManager;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class BranchManagerSeeder extends Seeder
{
    public function run(): void
    {
        $managerUser = User::create([
            'full_name' => 'Main Branch Manager',
            'phone' => '0500000001',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'branch_manager',
            'status' => 'active',
        ]);

        $branchManager = BranchManager::create([
            'user_id' => $managerUser->id,
        ]);

        for ($i = 1; $i <= 3; $i++) {
            $branchUser = User::create([
                'full_name' => "Branch User {$i}",
                'phone' => '05000000' . ($i + 10),
                'email' => "branch{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'branch',
                'status' => 'active',
            ]);

            Branch::create([
                'user_id' => $branchUser->id,
                'manager_id' => $branchManager->id,
                'creator_user_id' => $managerUser->id,
                'branch_number' => $i,
            ]);
        }

        $this->command->info('✅ BranchManager with 3 branch users created successfully!');
    }
}
