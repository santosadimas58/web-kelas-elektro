<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('name');
            $table->string('prodi')->nullable()->after('nim');
            $table->unsignedSmallInteger('angkatan')->nullable()->after('prodi');
            $table->string('email')->nullable()->after('angkatan');
            $table->string('photo_path')->nullable()->after('photo_url');
            $table->unique('nim');
            $table->unique('email');
        });

        DB::table('students')
            ->orderBy('id')
            ->get()
            ->each(function (object $student): void {
                DB::table('students')
                    ->where('id', $student->id)
                    ->update([
                        'nim' => $student->nim ?: sprintf('PTE2024%03d', $student->id),
                        'prodi' => $student->prodi ?: ($student->study_focus ?: 'Pendidikan Teknik Elektro'),
                        'angkatan' => $student->angkatan ?: 2024,
                        'email' => $student->email ?: Str::slug($student->name, '.').'.'.$student->id.'@kelas-elektro.test',
                    ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['nim']);
            $table->dropUnique(['email']);
            $table->dropColumn(['nim', 'prodi', 'angkatan', 'email', 'photo_path']);
        });
    }
};
