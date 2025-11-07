<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BranchManager;
use App\Models\Branch;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BranchManagerSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Realistic Managers ----
        $managers = [
            [
                'name' => 'Ahmed Al-Qahtani',
                'email' => 'ahmed.qahtani@example.com',
                'phone' => '0501000001',
            ],
            [
                'name' => 'Fatimah Al-Zahrani',
                'email' => 'fatimah.zahrani@example.com',
                'phone' => '0501000002',
            ],
            [
                'name' => 'Mohammed Al-Harbi',
                'email' => 'mohammed.harbi@example.com',
                'phone' => '0501000003',
            ],
        ];

        $branchNames = [
            'Riyadh Branch',
            'Jeddah Branch',
            'Dammam Branch',
            'Madinah Branch',
            'Abha Branch',
            'Tabuk Branch',
            'Taif Branch',
            'Qassim Branch',
            'Najran Branch',
        ];

        $customers = [
            ['Ali Hassan', '0559000001'],
            ['Sara Khalid', '0559000002'],
            ['Omar Saleh', '0559000003'],
            ['Reem Abdullah', '0559000004'],
            ['Hassan Nasser', '0559000005'],
            ['Layla Faisal', '0559000006'],
        ];

        $drivers = [
            'Yousef Ahmed',
            'Majed Ali',
            'Tariq Hassan',
            'Saleh Omar',
            'Badr Nasser',
        ];

        $branchIndex = 0;

        // --- Create Each Branch Manager ---
        foreach ($managers as $managerIndex => $m) {
            $managerUser = User::firstOrCreate([
                'email' => $m['email']
            ], [
                'full_name' => $m['name'],
                'phone' => $m['phone'],
                'password' => Hash::make('password'),
                'role' => 'branch_manager',
                'status' => 'active',
            ]);

            $branchManager = BranchManager::firstOrCreate([
                'user_id' => $managerUser->id,
            ]);

            // --- Each manager gets 2-3 unique branches ---
            $numBranches = rand(2, 3);

            for ($b = 1; $b <= $numBranches; $b++) {
                if (!isset($branchNames[$branchIndex])) break;

                $branchName = $branchNames[$branchIndex];
                $branchPhone = '05' . str_pad(($managerIndex + 1) * 1000 + $b, 7, '0', STR_PAD_LEFT);

                $branchUser = User::firstOrCreate([
                    'email' => Str::slug($branchName . $managerUser->id) . '@example.com',
                ], [
                    'full_name' => $branchName . ' User',
                    'phone' => $branchPhone,
                    'password' => Hash::make('password'),
                    'role' => 'branch',
                    'status' => 'active',
                ]);

                $branch = Branch::firstOrCreate([
                    'user_id' => $branchUser->id,
                ], [
                    'manager_id' => $branchManager->id,
                    'creator_user_id' => $managerUser->id,
                    'branch_number' => $b,
                ]);

                // --- Create 5 Realistic Orders for Each Branch ---
                for ($i = 1; $i <= 5; $i++) {
                    $customer = $customers[array_rand($customers)];
                    $driver = $drivers[array_rand($drivers)];
                    $date = Carbon::now()->subDays(rand(0, 10));
                    $time = $date->copy()->addHours(rand(8, 20));

                    Order::create([
                        'branch_id' => $branch->id,
                        'company_id' => rand(1, 5), // assuming company with ID 1 exists
                        'created_by' => $branchUser->id,
                        'order_number' => 'ORD-' . strtoupper(Str::random(6)),
                        'customer_name' => $customer[0],
                        'customer_phone' => $customer[1],
                        'driver_name' => $driver,
                        'total_order' => rand(100, 1500),
                        'date' => $date->format('Y-m-d'),
                        'time' => $time->format('H:i:s'),
                        'notes' => 'Delivery to ' . $customer[0] . ' - ' . $branchName,
                        'status' => 'completed',
                        'order_image' => null,
                    ]);
                }

                $branchIndex++;
            }
        }

        $this->command->info('✅ Real Branch Managers, Branches & Orders seeded successfully without duplicates!');
    }
}