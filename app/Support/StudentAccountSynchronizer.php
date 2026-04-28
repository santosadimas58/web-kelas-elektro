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
            ->orderBy('id')
            ->get(['id', 'name', 'email', 'role'])
            ->each(function (User $user): void {
                $student = Student::query()
                    ->where('email', $user->email)
                    ->orWhere('nim', self::studentNim($user))
                    ->firstOrNew();

                $student->fill(self::studentData($user))->save();
            });
    }

    /**
     * Build a student query limited to registered accounts.
     *
     * @return Builder<Student>
     */
    public static function syncedStudentQuery(): Builder
    {
        self::sync();

        $registeredEmails = User::query()
            ->where('role', 'user')
            ->pluck('email');

        return Student::query()
            ->whereIn('email', $registeredEmails)
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
            'prodi' => $user->role === 'admin' ? 'Admin' : 'Mahasiswa Kelas',
            'angkatan' => $year,
            'email' => $user->email,
            'study_focus' => $user->role === 'admin' ? 'Admin' : 'Mahasiswa Kelas',
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
