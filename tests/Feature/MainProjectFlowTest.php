<?php

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('admin can log in and is redirected to the admin dashboard', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'password' => 'password',
    ]);

    $response = $this->post('/login', [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));

    $dashboard = $this->get('/dashboard');

    $dashboard->assertRedirect(route('admin.dashboard', absolute: false));
    $this->assertAuthenticatedAs($admin);
});

test('regular user can log in and is redirected to the user dashboard', function () {
    $user = User::factory()->create([
        'role' => 'user',
        'password' => 'password',
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('dashboard', absolute: false));

    $dashboard = $this->get('/dashboard');

    $dashboard->assertRedirect(route('user.dashboard', absolute: false));
    $this->assertAuthenticatedAs($user);
});

test('admin can complete the main student crud flow', function () {
    Storage::fake('public');

    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $photo = UploadedFile::fake()->createWithContent(
        'student.png',
        base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAukB9VE1K5sAAAAASUVORK5CYII=')
    );

    $createResponse = $this->actingAs($admin)->post(route('admin.students.store'), [
        'name' => 'Demo Mahasiswa',
        'nim' => 'PTE2024999',
        'prodi' => 'Pendidikan Teknik Elektro',
        'angkatan' => 2024,
        'email' => 'demo.mahasiswa@example.com',
        'sort_order' => 1,
        'photo' => $photo,
    ]);

    $createResponse->assertRedirect(route('admin.students.index', absolute: false));

    $student = Student::query()->where('nim', 'PTE2024999')->firstOrFail();

    $showResponse = $this->actingAs($admin)->get(route('admin.students.show', $student));
    $showResponse->assertOk()->assertSee('Demo Mahasiswa');

    $updateResponse = $this->actingAs($admin)->put(route('admin.students.update', $student), [
        'name' => 'Demo Mahasiswa Update',
        'nim' => 'PTE2024999',
        'prodi' => 'Pendidikan Teknik Elektro',
        'angkatan' => 2025,
        'email' => 'demo.mahasiswa@example.com',
        'sort_order' => 2,
    ]);

    $updateResponse->assertRedirect(route('admin.students.index', absolute: false));
    $this->assertDatabaseHas('students', [
        'id' => $student->id,
        'name' => 'Demo Mahasiswa Update',
    ]);

    $deleteResponse = $this->actingAs($admin)->delete(route('admin.students.destroy', $student));

    $deleteResponse->assertRedirect(route('admin.students.index', absolute: false));
    $this->assertDatabaseMissing('students', [
        'id' => $student->id,
    ]);
});

test('regular users are blocked from admin-only student management actions', function () {
    $user = User::factory()->create([
        'role' => 'user',
    ]);

    $student = Student::factory()->create();

    $this->actingAs($user)->get(route('admin.students.index'))->assertForbidden();
    $this->actingAs($user)->post(route('admin.students.store'), [])->assertForbidden();
    $this->actingAs($user)->put(route('admin.students.update', $student), [])->assertForbidden();
    $this->actingAs($user)->delete(route('admin.students.destroy', $student))->assertForbidden();
});
