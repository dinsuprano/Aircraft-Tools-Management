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
        User::create([
            'name' => 'Nuruddin Naim',
            'email' => 'naim@gmail.com',
            'password' => bcrypt('naim123'),
            'role' => 'Admin'
        ]);

        // Departments
        $departments = ['Mechanic', 'Inspection'];
        foreach ($departments as $dept) {
            \App\Models\Department::create(['name' => $dept]);
        }

        // Job Titles
        $jobs = ['Head Engineer', 'Head Technician', 'Engineer', 'Technician', 'Junior Engineer', 'Junior Technician'];
        foreach ($jobs as $job) {
            \App\Models\JobTitle::create(['title' => $job]);
        }

        // Tool Statuses
        $statuses = ['Available', 'Maintenance'];
        foreach ($statuses as $status) {
            \App\Models\ToolStatus::create(['status' => $status]);
        }

        // Employees
        \App\Models\Employee::create(['id' => 101, 'name' => 'Muhammad Husin Bin Ramli', 'email' => 'husin_ramli@gmail.com', 'department' => 'Inspection', 'role' => 'Head Engineer']);
        \App\Models\Employee::create(['id' => 102, 'name' => 'John Doe', 'email' => 'johndoe@gmail.com', 'department' => 'Mechanic', 'role' => 'Head Engineer']);
        \App\Models\Employee::create(['id' => 103, 'name' => 'Karim Benzema', 'email' => 'karim_benzema11@gmail.com', 'department' => 'Mechanic', 'role' => 'Junior Technician']);

        // Tools
        \App\Models\Tool::create([
            'barcode' => '1243213012321',
            'name' => 'Screw Driver',
            'description' => 'Screw Driver',
            'location' => 'A2',
            'price' => 300,
            'quantity' => 1,
            'image' => '64353256213e6.jpg',
            'available_quantity' => 1,
            'status' => 'Available'
        ]);
        
        \App\Models\Tool::create([
            'barcode' => '8285337507167',
            'name' => 'Spanner',
            'description' => 'Spanner to repair bolt',
            'location' => 'B2',
            'price' => 100,
            'quantity' => 1,
            'image' => '64353f67e5550.jpg',
            'available_quantity' => 1,
            'status' => 'Available'
        ]);
    }
}
