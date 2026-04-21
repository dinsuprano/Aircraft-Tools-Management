<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'department' => $this->faker->randomElement(['Maintenance', 'Engineering', 'Logistics', 'Operations', 'Quality']),
            'role' => $this->faker->randomElement(['Technician', 'Engineer', 'Supervisor', 'Manager', 'Assistant']),
        ];
    }
}
