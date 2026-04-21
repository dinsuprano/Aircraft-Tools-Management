<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User
        \App\Models\User::updateOrCreate(
            ['email' => 'naim@gmail.com'],
            [
                'name' => 'Nuruddin Naim',
                'password' => bcrypt('naim123'),
                'role' => 'Admin'
            ]
        );

        // Departments
        $departments = ['Mechanic', 'Inspection'];
        foreach ($departments as $dept) {
            \App\Models\Department::updateOrCreate(['name' => $dept]);
        }

        // Job Titles
        $jobs = ['Head Engineer', 'Head Technician', 'Engineer', 'Technician', 'Junior Engineer', 'Junior Technician'];
        foreach ($jobs as $job) {
            \App\Models\JobTitle::updateOrCreate(['title' => $job]);
        }

        // Tool Statuses
        $statuses = ['Available', 'Maintenance'];
        foreach ($statuses as $status) {
            \App\Models\ToolStatus::updateOrCreate(['status' => $status]);
        }

        // Static Employees (Keep IDs unique)
        $staticEmployees = [
            ['id' => 101, 'name' => 'Muhammad Husin Bin Ramli', 'email' => 'husin_ramli@gmail.com', 'department' => 'Inspection', 'role' => 'Head Engineer'],
            ['id' => 102, 'name' => 'John Doe', 'email' => 'johndoe@gmail.com', 'department' => 'Mechanic', 'role' => 'Head Engineer'],
            ['id' => 103, 'name' => 'Karim Benzema', 'email' => 'karim_benzema11@gmail.com', 'department' => 'Mechanic', 'role' => 'Junior Technician'],
        ];

        foreach ($staticEmployees as $emp) {
            \App\Models\Employee::updateOrCreate(['id' => $emp['id']], $emp);
        }

        // Seed 20 additional employees using factory
        \App\Models\Employee::factory()->count(20)->create();

        // Seed 100 tools using factory
        \App\Models\Tool::factory()->count(100)->create();
    }
}
