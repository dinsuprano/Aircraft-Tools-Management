<?php

namespace Database\Factories;

use App\Models\Tool;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToolFactory extends Factory
{
    protected $model = Tool::class;

    public function definition(): array
    {
        return [
            'barcode' => $this->faker->unique()->numerify('#############'), // 13 digits
            'name' => $this->faker->randomElement([
                'Torque Wrench', 'Hydraulic Jack', 'Socket Set', 'Pliers', 'Screwdriver Set',
                'Multimeter', 'Pressure Gauge', 'Flashlight', 'Caliper', 'Hammer',
                'Safety Harness', 'Oxygen Mask Tester', 'Rivet Gun', 'Drill Machine',
                'Angle Grinder', 'Heat Gun', 'Soldering Iron', 'Wire Stripper',
                'Tension Meter', 'Borescope'
            ]) . ' ' . $this->faker->bothify('??-###'),
            'description' => $this->faker->sentence(),
            'location' => $this->faker->randomElement(['Hangar A', 'Hangar B', 'Tool Room 1', 'Tool Room 2', 'Main Store']),
            'price' => $this->faker->randomFloat(2, 50, 5000),
            'status' => 'Available',
        ];
    }
}
