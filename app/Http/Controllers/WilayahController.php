<?php

namespace App\Http\Controllers;

use App\Models\RT;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WilayahController extends Controller
{
    /**
     * Display wilayah management page.
     */
    public function index(Request $request): Response
    {
        $statusFilter = $request->input('status');
        $kecamatanFilter = $request->input('kecamatan');
        $kelurahanFilter = $request->input('kelurahan');
        $rwFilter = $request->input('rw');

        $query = RT::with(['rw.kelurahan.kecamatan'])
            ->when($statusFilter, function ($query, $status) {
                $query->where('status_terdaftar', $status);
            })
            ->when($kecamatanFilter, function ($query) use ($kecamatanFilter) {
                $query->whereHas('rw.kelurahan', function ($q) use ($kecamatanFilter) {
                    $q->where('kecamatan_id', $kecamatanFilter);
                });
            })
            ->when($kelurahanFilter, function ($query) use ($kelurahanFilter) {
                $query->whereHas('rw', function ($q) use ($kelurahanFilter) {
                    $q->where('kelurahan_id', $kelurahanFilter);
                });
            })
            ->when($rwFilter, function ($query) use ($rwFilter) {
                $query->where('rw_id', $rwFilter);
            })
            ->orderBy('created_at', 'desc');

        $rts = $query->paginate(20)->withQueryString();

        // Get filter options
        $kecamatans = Kecamatan::where('kota', 'Padang')->orderBy('nama')->get();

        return Inertia::render('Wilayah/Index', [
            'rts' => $rts,
            'filters' => [
                'status' => $statusFilter,
                'kecamatan' => $kecamatanFilter,
                'kelurahan' => $kelurahanFilter,
                'rw' => $rwFilter,
            ],
            'filterOptions' => [
                'kecamatans' => $kecamatans,
            ],
        ]);
    }

    /**
     * Get kelurahans for AJAX request.
     */
    public function getKelurahans(Request $request)
    {
        $kelurahans = \App\Models\Kelurahan::where('kecamatan_id', $request->kecamatan_id)
            ->orderBy('nama')
            ->get(['id', 'nama', 'kode']);

        return response()->json($kelurahans);
    }

    /**
     * Get RWs for AJAX request.
     */
    public function getRWs(Request $request)
    {
        $rws = \App\Models\RW::where('kelurahan_id', $request->kelurahan_id)
            ->orderBy('nomor_rw')
            ->get(['id', 'nama', 'nomor_rw']);

        return response()->json($rws);
    }

    /**
     * Update RT status.
     */
    public function updateStatus(Request $request, RT $rt)
    {
        $request->validate([
            'status_terdaftar' => 'required|boolean',
        ]);

        $rt->update([
            'status_terdaftar' => $request->status_terdaftar ? 'sudah' : 'belum',
        ]);

        return back()->with('success', 'Status RT berhasil diupdate.');
    }
}
