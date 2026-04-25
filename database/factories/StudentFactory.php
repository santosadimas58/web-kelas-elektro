<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'nim' => 'PTE'.fake()->unique()->numerify('########'),
            'prodi' => 'Pendidikan Teknik Elektro',
            'angkatan' => fake()->numberBetween(2021, 2026),
            'email' => fake()->unique()->safeEmail(),
            'photo_path' => null,
            'study_focus' => 'Pendidikan Teknik Elektro',
            'bio' => 'Profil singkat mahasiswa untuk kebutuhan pengujian.',
            'sort_order' => fake()->numberBetween(0, 50),
        ];
    }
}
