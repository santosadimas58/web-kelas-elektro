<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Illuminate\View\View;

class StudentController extends AdminController
{
    /**
     * Display a listing of students.
     */
    public function index(): View
    {
        return view('admin.students.index', [
            'title' => 'Kelola Mahasiswa',
            'students' => Student::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->paginate(10),
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
        $validated = $this->fillLegacyColumns($validated);
        $validated['photo_path'] = $this->storePhoto($request);

        Student::query()->create($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('status', 'Mahasiswa berhasil ditambahkan.');
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student): View
    {
        return view('admin.students.show', [
            'title' => 'Detail Mahasiswa',
            'student' => $student,
        ]);
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
        $validated = $this->validateStudent($request, $student);
        $validated = $this->fillLegacyColumns($validated);

        if ($request->hasFile('photo')) {
            $this->deletePhoto($student);
            $validated['photo_path'] = $this->storePhoto($request);
        }

        $student->update($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('status', 'Mahasiswa berhasil diperbarui.');
    }

    /**
     * Remove the specified student.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $this->deletePhoto($student);
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
    protected function validateStudent(Request $request, ?Student $student = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'photo' => [
                'nullable',
                File::image()
                    ->types(['jpg', 'jpeg', 'png', 'webp'])
                    ->max(2048),
            ],
        ];

        if ($this->hasStudentColumn('nim')) {
            $rules['nim'] = [
                'required',
                'string',
                'max:50',
                Rule::unique('students', 'nim')->ignore($student),
            ];
        } else {
            $rules['nim'] = ['nullable', 'string', 'max:50'];
        }

        if ($this->hasStudentColumn('prodi')) {
            $rules['prodi'] = ['required', 'string', 'max:150'];
        } else {
            $rules['prodi'] = ['nullable', 'string', 'max:150'];
        }

        if ($this->hasStudentColumn('angkatan')) {
            $rules['angkatan'] = ['required', 'integer', 'digits:4', 'min:2000', 'max:2100'];
        } else {
            $rules['angkatan'] = ['nullable', 'integer', 'digits:4', 'min:2000', 'max:2100'];
        }

        if ($this->hasStudentColumn('email')) {
            $rules['email'] = [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student),
            ];
        } else {
            $rules['email'] = ['nullable', 'email', 'max:255'];
        }

        return $request->validate($rules);
    }

    /**
     * Persist the uploaded student photo.
     */
    protected function storePhoto(Request $request): ?string
    {
        if (! $request->hasFile('photo') || ! $this->hasStudentColumn('photo_path')) {
            return null;
        }

        return $request->file('photo')->store('student-photos', 'public');
    }

    /**
     * Remove the stored student photo when it belongs to local storage.
     */
    protected function deletePhoto(Student $student): void
    {
        if ($this->hasStudentColumn('photo_path') && $student->photo_path && ! str_starts_with($student->photo_path, 'http')) {
            Storage::disk('public')->delete($student->photo_path);
        }
    }

    /**
     * Keep legacy columns populated while the old table structure still exists.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    protected function fillLegacyColumns(array $validated): array
    {
        $persisted = [
            'name' => $validated['name'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($this->hasStudentColumn('nim') && array_key_exists('nim', $validated)) {
            $persisted['nim'] = $validated['nim'];
        }

        if ($this->hasStudentColumn('prodi') && array_key_exists('prodi', $validated)) {
            $persisted['prodi'] = $validated['prodi'];
        }

        if ($this->hasStudentColumn('angkatan') && array_key_exists('angkatan', $validated)) {
            $persisted['angkatan'] = $validated['angkatan'];
        }

        if ($this->hasStudentColumn('email') && array_key_exists('email', $validated)) {
            $persisted['email'] = $validated['email'];
        }

        if ($this->hasStudentColumn('study_focus')) {
            $persisted['study_focus'] = $validated['prodi'] ?? $validated['name'];
        }

        if ($this->hasStudentColumn('bio')) {
            $persisted['bio'] = sprintf(
                '%s%s%s%s',
                $validated['prodi'] ?? 'Profil mahasiswa',
                ! empty($validated['angkatan']) ? ' angkatan '.$validated['angkatan'] : '',
                ! empty($validated['nim']) ? ' dengan NIM '.$validated['nim'] : '',
                ! empty($validated['email']) ? '. Kontak: '.$validated['email'].'.' : '.'
            );
        }

        return $persisted;
    }

    protected function hasStudentColumn(string $column): bool
    {
        return Schema::hasColumn('students', $column);
    }
}
