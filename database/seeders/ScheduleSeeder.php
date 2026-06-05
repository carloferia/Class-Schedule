<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            ['test123123', 'test@gmail.com', 'Other', 'Teacher'],
            ['Michael Maico', 'michael.maico@school.test', 'Male', 'Teacher'],
            ['Obet Satore', 'obet.satore@school.test', 'Male', 'Teacher'],
            ['Carl Cymon De Vera', 'carl.devera@school.test', 'Male', 'Teacher'],
            ['Adrian Feria', 'adrian.feria@school.test', 'Male', 'Teacher'],
        ];

        $schedule = [
            ['Rizal', 'BSIT 2-F', 'Room 104', 'Monday', '08:00', '09:30', 'Scheduled', 'Bring Rizal book'],
            ['ITEC 106', 'BSIT 2-D', 'Room 206', 'Monday', '10:00', '11:30', 'Scheduled', 'Laravel activity'],
            ['Purposive Communication', 'BSIT 1-C', 'Room 201', 'Tuesday', '09:00', '10:30', 'Rescheduled', 'Moved from 8:00 AM'],
            ['Mathematics', 'BSIT 3-A', 'Room 305', 'Wednesday', '13:00', '14:30', 'Scheduled', 'Problem set review'],
            ['Physical Education', 'BSIT 2-B', 'Room 306', 'Friday', '15:00', '16:30', 'Teacher Absent', 'Teacher marked absent'],
        ];

        foreach ($teachers as [$name, $email, $gender, $role]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'gender' => $gender,
                    'address' => $role,
                ],
            );

            $user->expenses()->delete();

            foreach ($schedule as [$subject, $section, $room, $day, $start, $end, $status, $notes]) {
                Expense::create([
                    'user_id' => $user->id,
                    'description' => $subject,
                    'category' => $day,
                    'day_of_week' => $day,
                    'room' => $room,
                    'section' => $section,
                    'status' => $status,
                    'start_time' => $start,
                    'end_time' => $end,
                    'teacher' => $user->name,
                    'amount' => 1,
                    'date' => now()->toDateString(),
                    'notes' => $notes,
                ]);
            }
        }
    }
}
