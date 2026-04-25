<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StudentSeeder extends Seeder
{
    /**
     * Seed demo students for public and admin pages.
     */
    public function run(): void
    {
        $classroom = config('classroom');

        foreach ($classroom['students'] as $index => $student) {
            Student::query()->updateOrCreate(
                ['nim' => sprintf('PTE2024%03d', $index + 1)],
                [
                    'name' => $student['name'],
                    'prodi' => 'Pendidikan Teknik Elektro',
                    'angkatan' => 2024,
                    'email' => Str::slug($student['name'], '.').'@kelas-elektro.test',
                    'study_focus' => 'Pendidikan Teknik Elektro',
                    'bio' => $student['bio'],
                    'sort_order' => $index + 1,
                ]
            );
        }

        $minimumDemoStudents = 15;
        $additionalStudentsNeeded = max(0, $minimumDemoStudents - Student::query()->count());

        if ($additionalStudentsNeeded > 0) {
            $startingSortOrder = (int) Student::query()->max('sort_order');

            Student::factory()
                ->count($additionalStudentsNeeded)
                ->sequence(fn (Sequence $sequence) => [
                    'sort_order' => $startingSortOrder + $sequence->index + 1,
                ])
                ->create();
        }
    }
}
