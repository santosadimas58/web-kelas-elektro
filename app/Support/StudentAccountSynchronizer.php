<?php

namespace App\Support;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class StudentAccountSynchronizer
{
    /**
     * Ensure every registered account has a matching student profile row.
     */
    public static function sync(): void
    {
        User::query()
            ->where('role', 'user')
            ->orderBy('id')
            ->get(['id', 'name', 'email', 'role'])
            ->each(function (User $user): void {
                $student = Student::query()
                    ->where('email', $user->email)
                    ->orWhere('nim', self::studentNim($user))
                    ->firstOrNew();

                if ($student->exists) {
                    return;
                }

                $student->fill(self::studentData($user))->save();
            });
    }

    /**
     * Build a student query for class profiles, including manually managed rows.
     *
     * @return Builder<Student>
     */
    public static function syncedStudentQuery(): Builder
    {
        self::sync();

        $adminEmails = User::query()
            ->where('role', 'admin')
            ->pluck('email');

        return Student::query()
            ->whereNotIn('email', $adminEmails)
            ->orderBy('sort_order')
            ->orderBy('name');
    }

    /**
     * @return array<string, mixed>
     */
    private static function studentData(User $user): array
    {
        $year = Carbon::now()->year;

        return [
            'name' => $user->name,
            'nim' => self::studentNim($user),
            'prodi' => 'Mahasiswa Kelas',
            'angkatan' => $year,
            'email' => $user->email,
            'study_focus' => 'Mahasiswa Kelas',
            'bio' => sprintf(
                '%s terdaftar sebagai akun %s. Kontak: %s.',
                $user->name,
                $user->role,
                $user->email,
            ),
            'sort_order' => $user->id,
        ];
    }

    private static function studentNim(User $user): string
    {
        return sprintf('USER%06d', $user->id);
    }
}
