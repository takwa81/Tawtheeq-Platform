<?php

namespace App\Console\Commands;

use App\Enums\AppointmentStatusEnum;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateVetAppointmentStatus extends Command
{
    protected $signature = 'vet-appointments:update-status';
    protected $description = 'Update vet appointment statuses based on start time and date';

    public function handle()
    {
        $now = Carbon::now();
        $currentDate = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');

        // Get pending appointments that should be cancelled
        $pendingAppointments = Appointment::where('status', AppointmentStatusEnum::PENDING->value)
            ->where(function ($query) use ($currentDate, $currentTime) {
                $query->where('date', '<', $currentDate)
                    ->orWhere(function ($q) use ($currentDate, $currentTime) {
                        $q->where('date', $currentDate)
                            ->where('start_time', '<', $currentTime);
                    });
            })
            ->get();

        // Process each appointment
        foreach ($pendingAppointments as $appointment) {
            try {
                // Update status
                $appointment->update(['status' => AppointmentStatusEnum::CANCELLED->value]);

                // Get user and their token
                $user = User::find($appointment->user_id);
                if ($user && $user->currentAccessToken()) {
                    // Make API request
                    $response = Http::withToken($user->currentAccessToken()->token)
                        ->post(route('api.vet.appointments.cancel', ['appointment' => $appointment->id]));

                    if (!$response->successful()) {
                        Log::error("Failed to cancel appointment {$appointment->id} via API: " . $response->body());
                    }
                }
            } catch (\Exception $e) {
                Log::error("Error processing appointment {$appointment->id}: " . $e->getMessage());
            }
        }

        // Update CONFIRMED appointments that should be FINISHED
        $thirtyMinutesAgo = $now->copy()->subMinutes(30)->format('H:i:s');

        Appointment::where('status', AppointmentStatusEnum::CONFIRMED->value)
            ->where(function ($query) use ($currentDate, $thirtyMinutesAgo) {
                $query->where('date', '<', $currentDate)
                    ->orWhere(function ($q) use ($currentDate, $thirtyMinutesAgo) {
                        $q->where('date', $currentDate)
                            ->where('start_time', '<=', $thirtyMinutesAgo);
                    });
            })
            ->update(['status' => AppointmentStatusEnum::FINISHED->value]);

        $this->info('Vet appointment statuses updated successfully.');
    }
}
