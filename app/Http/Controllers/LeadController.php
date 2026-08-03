<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(): View
    {
        $leads = Lead::latest()->paginate(10);

        return view('leads.index', compact('leads'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_orang_tua' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:30'],
            'nama_anak' => ['nullable', 'string', 'max:255'],
            'sumber_informasi' => ['nullable', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ]);

        Lead::create($data);

        return back()->with('lead_success', 'Terima kasih. Tim PPDB akan menghubungi Anda.');
    }

    public function update(Request $request, Lead $lead): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:baru,dihubungi,berminat,daftar,tidak_berminat'],
            'catatan' => ['nullable', 'string'],
        ]);

        $lead->update($data);

        return back()->with('success', 'Lead berhasil diperbarui.');
    }

    public function export(): StreamedResponse
    {
        $fileName = 'leads-ppdb-'.now()->format('Ymd-His').'.csv';
        $leads = Lead::latest()->get();

        return response()->streamDownload(function () use ($leads) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama Orang Tua', 'No HP', 'Nama Anak', 'Sumber Informasi', 'Status', 'Catatan']);

            foreach ($leads as $lead) {
                fputcsv($handle, [
                    $lead->nama_orang_tua,
                    $lead->no_hp,
                    $lead->nama_anak,
                    $lead->sumber_informasi,
                    $lead->status,
                    $lead->catatan,
                ]);
            }

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }
}
