<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Send the user to the dashboard that matches their role.
     */
    public function index(): RedirectResponse
    {
        return match (auth()->user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            default => redirect()->route('siswa.dashboard'),
        };
    }

    /**
     * Dashboard for the Siswa / Orang Tua role.
     */
    public function siswa(): View
    {
        $student = auth()->user()->student;

        $requests = $student
            ? $student->leaveRequests()->latest()->get()
            : collect();

        return view('siswa.dashboard', [
            'student' => $student,
            'total' => $requests->count(),
            'pending' => $requests->where('status', 'Pending')->count(),
            'approved' => $requests->where('status', 'Approved')->count(),
            'rejected' => $requests->where('status', 'Rejected')->count(),
            'latest' => $requests->take(5),
        ]);
    }

    /**
     * Dashboard for the Guru / Wali Kelas role.
     */
    public function guru(): View
    {
        return view('guru.dashboard', [
            'pendingToday' => LeaveRequest::where('status', 'Pending')
                ->whereDate('created_at', today())
                ->count(),
            'totalPending' => LeaveRequest::where('status', 'Pending')->count(),
            'approved' => LeaveRequest::where('status', 'Approved')->count(),
            'rejected' => LeaveRequest::where('status', 'Rejected')->count(),
            'recent' => LeaveRequest::with('student.user')
                ->where('status', 'Pending')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    /**
     * Dashboard for the Admin / Tata Usaha role.
     */
    public function admin(): View
    {
        $monthly = LeaveRequest::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        return view('admin.dashboard', [
            'totalMonth' => (clone $monthly)->count(),
            'pending' => LeaveRequest::where('status', 'Pending')->count(),
            'approved' => LeaveRequest::where('status', 'Approved')->count(),
            'rejected' => LeaveRequest::where('status', 'Rejected')->count(),
            'totalStudents' => Student::count(),
            'totalGuru' => User::where('role', 'guru')->count(),
            'recent' => LeaveRequest::with('student.user', 'approver')
                ->latest()
                ->take(8)
                ->get(),
        ]);
    }
}
