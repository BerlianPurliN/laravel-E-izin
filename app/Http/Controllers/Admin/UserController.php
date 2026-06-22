<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Daftar pengguna (guru & siswa).
     */
    public function index(Request $request): View
    {
        $role = $request->query('role');

        $query = User::with('student')
            ->where('role', '!=', 'admin')
            ->latest();

        if (in_array($role, ['guru', 'siswa'], true)) {
            $query->where('role', $role);
        }

        return view('admin.pengguna.index', [
            'users' => $query->paginate(10)->withQueryString(),
            'role' => $role,
        ]);
    }

    /**
     * Form tambah pengguna.
     */
    public function create(): View
    {
        return view('admin.pengguna.create');
    }

    /**
     * Simpan pengguna baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateUser($request, isCreate: true);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($user->role === 'siswa') {
            Student::create([
                'user_id' => $user->id,
                'nisn' => $validated['nisn'],
                'kelas' => $validated['kelas'],
            ]);
        }

        return redirect()
            ->route('admin.pengguna.index')
            ->with('status', "Pengguna {$user->name} berhasil ditambahkan.");
    }

    /**
     * Form ubah pengguna.
     */
    public function edit(User $pengguna): View
    {
        $pengguna->load('student');

        return view('admin.pengguna.edit', [
            'user' => $pengguna,
        ]);
    }

    /**
     * Perbarui data pengguna.
     */
    public function update(Request $request, User $pengguna): RedirectResponse
    {
        $validated = $this->validateUser($request, isCreate: false, user: $pengguna);

        $pengguna->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ]);

        if ($pengguna->role === 'siswa') {
            $pengguna->student()->updateOrCreate(
                ['user_id' => $pengguna->id],
                ['nisn' => $validated['nisn'], 'kelas' => $validated['kelas']]
            );
        } elseif ($pengguna->student) {
            // User switched away from "siswa": remove the orphaned student record.
            $pengguna->student->delete();
        }

        return redirect()
            ->route('admin.pengguna.index')
            ->with('status', "Data {$pengguna->name} berhasil diperbarui.");
    }

    /**
     * Hapus pengguna (beserta data siswa & izin terkait).
     */
    public function destroy(User $pengguna): RedirectResponse
    {
        $name = $pengguna->name;
        $pengguna->delete();

        return redirect()
            ->route('admin.pengguna.index')
            ->with('status', "Pengguna {$name} berhasil dihapus.");
    }

    /**
     * Reset password pengguna.
     */
    public function resetPassword(Request $request, User $pengguna): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $newPassword = $validated['password'] ?? 'password';
        $pengguna->update(['password' => Hash::make($newPassword)]);

        return redirect()
            ->route('admin.pengguna.index')
            ->with('status', "Password {$pengguna->name} direset menjadi: {$newPassword}");
    }

    /**
     * Aturan validasi bersama untuk store & update.
     *
     * @return array<string, mixed>
     */
    protected function validateUser(Request $request, bool $isCreate, ?User $user = null): array
    {
        $studentId = $user?->student?->id;

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => ['required', 'in:guru,siswa'],
        ];

        if ($isCreate) {
            $rules['password'] = ['required', 'string', 'min:6'];
        }

        if ($request->input('role') === 'siswa') {
            $rules['nisn'] = ['required', 'string', 'max:30', Rule::unique('students', 'nisn')->ignore($studentId)];
            $rules['kelas'] = ['required', 'string', 'max:10'];
        }

        return $request->validate($rules, [], [
            'nisn' => 'NISN',
            'kelas' => 'kelas',
        ]);
    }
}
