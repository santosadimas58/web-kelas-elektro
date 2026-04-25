<?php

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function fakeStudentPhoto(string $name = 'student.png'): UploadedFile
{
    return UploadedFile::fake()->createWithContent(
        $name,
        base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAukB9VE1K5sAAAAASUVORK5CYII=')
    );
}

test('student management index is paginated for admins', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    Student::factory()->count(12)->create();

    $response = $this->actingAs($admin)->get(route('admin.students.index'));

    $response->assertOk();
    expect($response->viewData('students')->total())->toBe(12);
    expect($response->viewData('students')->count())->toBe(10);
});

test('regular users cannot access student management', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $response = $this->actingAs($user)->get(route('admin.students.index'));

    $response->assertForbidden();
});

test('admin can create a student with photo', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $photo = fakeStudentPhoto();

    $response = $this->actingAs($admin)->post(route('admin.students.store'), [
        'name' => 'Dina Lestari',
        'nim' => 'PTE2024001',
        'prodi' => 'Pendidikan Teknik Elektro',
        'angkatan' => 2024,
        'email' => 'dina@example.com',
        'sort_order' => 1,
        'photo' => $photo,
    ]);

    $response->assertRedirect(route('admin.students.index'));

    $student = Student::query()->where('nim', 'PTE2024001')->firstOrFail();

    expect($student->name)->toBe('Dina Lestari');
    expect($student->photo_path)->not->toBeNull();
    Storage::disk('public')->assertExists($student->photo_path);
});

test('admin can view student details', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $student = Student::factory()->create([
        'name' => 'Raka Prasetyo',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.students.show', $student));

    $response->assertOk();
    $response->assertSee('Raka Prasetyo');
    $response->assertSee($student->nim);
});

test('admin can update a student and replace the photo', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $oldPhotoPath = fakeStudentPhoto('old.png')->store('student-photos', 'public');

    $student = Student::factory()->create([
        'photo_path' => $oldPhotoPath,
    ]);

    $newPhoto = fakeStudentPhoto('new.png');

    $response = $this->actingAs($admin)->put(route('admin.students.update', $student), [
        'name' => 'Raka Update',
        'nim' => $student->nim,
        'prodi' => 'Pendidikan Teknik Elektro',
        'angkatan' => 2025,
        'email' => $student->email,
        'sort_order' => 9,
        'photo' => $newPhoto,
    ]);

    $response->assertRedirect(route('admin.students.index'));

    $student->refresh();

    expect($student->name)->toBe('Raka Update');
    expect($student->angkatan)->toBe(2025);
    expect($student->sort_order)->toBe(9);
    Storage::disk('public')->assertMissing($oldPhotoPath);
    Storage::disk('public')->assertExists($student->photo_path);
});

test('admin can delete a student and remove the photo file', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $photoPath = fakeStudentPhoto()->store('student-photos', 'public');

    $student = Student::factory()->create([
        'photo_path' => $photoPath,
    ]);

    $response = $this->actingAs($admin)->delete(route('admin.students.destroy', $student));

    $response->assertRedirect(route('admin.students.index'));
    $this->assertDatabaseMissing('students', ['id' => $student->id]);
    Storage::disk('public')->assertMissing($photoPath);
});

test('student model exposes legacy profile fields when the new columns are empty', function () {
    $student = Student::factory()->create([
        'study_focus' => 'Pendidikan Teknik Elektro',
        'bio' => 'Pendidikan Teknik Elektro angkatan 2024 dengan NIM 12345. Kontak: dimsan@example.com.',
        'nim' => null,
        'prodi' => null,
        'angkatan' => null,
        'email' => null,
    ]);

    expect($student->nim)->toBe('12345');
    expect($student->prodi)->toBe('Pendidikan Teknik Elektro');
    expect($student->angkatan)->toBe(2024);
    expect($student->email)->toBe('dimsan@example.com');
});
