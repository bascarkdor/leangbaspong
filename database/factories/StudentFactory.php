<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_name' => fake()->name(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'dob' => fake()->dateTimeBetween('-25 years', '-18 years')->format('Y-m-d'),
            'enrollment' => 'STU-'.date('Y').'-'.fake()->unique()->numerify('####'),
            'enrollment_date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'description' => fake()->sentence(10),
            'dept_id' => Department::factory(),
        ];
    }
}
