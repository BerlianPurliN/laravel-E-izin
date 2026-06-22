<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaveRequestController extends Controller
{
    /**
     * Riwayat izin milik siswa yang sedang login.
     */
    public function index(): View
    {
        $student = $this->currentStudent();

        return view('siswa.izin.index', [
            'requests' => $student->leaveRequests()->latest()->paginate(10),
        ]);
    }

    /**
     * Form pengajuan izin baru.
     */
    public function create(): View
    {
        $this->currentStudent();

        return view('siswa.izin.create');
    }

    /**
     * Simpan pengajuan izin baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $student = $this->currentStudent();

        $validated = $request->validate([
            'jenis_izin' => ['required', 'in:Sakit,Izin'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'alasan' => ['required', 'string', 'max:2000'],
            'bukti_lampiran' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ], [], [
            'jenis_izin' => 'jenis izin',
            'tanggal_mulai' => 'tanggal mulai',
            'tanggal_selesai' => 'tanggal selesai',
            'bukti_lampiran' => 'bukti lampiran',
        ]);

        if ($request->hasFile('bukti_lampiran')) {
            $validated['bukti_lampiran'] = $request->file('bukti_lampiran')->store('bukti', 'public');
        }

        $validated['student_id'] = $student->id;
        $validated['status'] = 'Pending';

        LeaveRequest::create($validated);

        return redirect()
            ->route('siswa.izin.index')
            ->with('status', 'Pengajuan izin berhasil dikirim dan menunggu verifikasi.');
    }

    /**
     * Detail izin milik siswa yang sedang login.
     */
    public function show(LeaveRequest $leaveRequest): View
    {
        $student = $this->currentStudent();

        abort_unless($leaveRequest->student_id === $student->id, 403);

        $leaveRequest->load('approver');

        return view('siswa.izin.show', [
            'izin' => $leaveRequest,
        ]);
    }

    /**
     * Ambil profil siswa milik user yang login, atau hentikan jika tidak ada.
     */
    protected function currentStudent(): \App\Models\Student
    {
        $student = auth()->user()->student;

        abort_unless($student, 403, 'Akun ini belum terhubung dengan data siswa.');

        return $student;
    }
}
