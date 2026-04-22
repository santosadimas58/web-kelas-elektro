<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(): View
    {
        return view('admin.students.index', [
            'title' => 'Kelola Mahasiswa',
            'students' => Student::query()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a student.
     */
    public function create(): View
    {
        return view('admin.students.create', [
            'title' => 'Tambah Mahasiswa',
            'student' => new Student(),
        ]);
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateStudent($request);
        Student::query()->create($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('status', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a student.
     */
    public function edit(Student $student): View
    {
        return view('admin.students.edit', [
            'title' => 'Edit Mahasiswa',
            'student' => $student,
        ]);
    }

    /**
     * Update the specified student.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $student->update($this->validateStudent($request));

        return redirect()
            ->route('admin.students.index')
            ->with('status', 'Mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('status', 'Mahasiswa berhasil dihapus.');
    }

    /**
     * Validate student form data.
     *
     * @return array<string, mixed>
     */
    protected function validateStudent(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'study_focus' => ['nullable', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:1000'],
            'photo_url' => ['nullable', 'url', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ]);
    }
}
