<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApprovalController extends Controller
{
    /**
     * Daftar permohonan izin yang masuk.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'Pending');

        $query = LeaveRequest::with('student.user')->latest();

        if (in_array($status, ['Pending', 'Approved', 'Rejected'], true)) {
            $query->where('status', $status);
        }

        return view('guru.persetujuan.index', [
            'requests' => $query->paginate(10)->withQueryString(),
            'status' => $status,
        ]);
    }

    /**
     * Detail satu permohonan izin.
     */
    public function show(LeaveRequest $leaveRequest): View
    {
        $leaveRequest->load('student.user', 'approver');

        return view('guru.persetujuan.show', [
            'izin' => $leaveRequest,
        ]);
    }

    /**
     * Setujui / tolak permohonan izin.
     */
    public function update(Request $request, LeaveRequest $leaveRequest): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'in:approve,reject'],
            'catatan_guru' => ['nullable', 'string', 'max:1000'],
        ]);

        $leaveRequest->update([
            'status' => $validated['action'] === 'approve' ? 'Approved' : 'Rejected',
            'catatan_guru' => $validated['catatan_guru'] ?? null,
            'approved_by' => auth()->id(),
        ]);

        $message = $validated['action'] === 'approve'
            ? 'Permohonan izin telah disetujui.'
            : 'Permohonan izin telah ditolak.';

        return redirect()
            ->route('guru.persetujuan.index')
            ->with('status', $message);
    }
}
