<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use App\Models\Student;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Rekapitulasi seluruh perizinan dengan filter.
     */
    public function index(Request $request): View
    {
        $requests = $this->filteredQuery($request)
            ->latest('tanggal_mulai')
            ->paginate(15)
            ->withQueryString();

        return view('admin.rekap.index', [
            'requests' => $requests,
            'kelasList' => Student::query()->select('kelas')->distinct()->orderBy('kelas')->pluck('kelas'),
            'filters' => $request->only(['kelas', 'status', 'dari', 'sampai']),
        ]);
    }

    /**
     * Ekspor rekap (sesuai filter) ke berkas CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $rows = $this->filteredQuery($request)->orderBy('tanggal_mulai')->get();

        $filename = 'rekap-izin-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');

            // BOM agar karakter UTF-8 terbaca rapi di Excel.
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($out, [
                'Nama', 'NISN', 'Kelas', 'Jenis Izin', 'Tanggal Mulai',
                'Tanggal Selesai', 'Alasan', 'Status', 'Diproses Oleh',
                'Catatan Guru', 'Tanggal Pengajuan',
            ]);

            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->student?->user?->name,
                    $r->student?->nisn,
                    $r->student?->kelas,
                    $r->jenis_izin,
                    $r->tanggal_mulai?->format('Y-m-d'),
                    $r->tanggal_selesai?->format('Y-m-d'),
                    $r->alasan,
                    $r->status,
                    $r->approver?->name,
                    $r->catatan_guru,
                    $r->created_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Bangun query izin sesuai filter yang dikirim.
     *
     * @return Builder<LeaveRequest>
     */
    protected function filteredQuery(Request $request): Builder
    {
        return LeaveRequest::query()
            ->with(['student.user', 'approver'])
            ->when($request->filled('status'), fn (Builder $q) => $q->where('status', $request->input('status')))
            ->when($request->filled('kelas'), fn (Builder $q) => $q->whereHas('student', fn (Builder $s) => $s->where('kelas', $request->input('kelas'))))
            ->when($request->filled('dari'), fn (Builder $q) => $q->whereDate('tanggal_mulai', '>=', $request->input('dari')))
            ->when($request->filled('sampai'), fn (Builder $q) => $q->whereDate('tanggal_selesai', '<=', $request->input('sampai')));
    }
}
