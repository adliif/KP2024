<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Pinjaman;
use App\Models\Tanggungan;
use App\Models\TransaksiPinjaman;
use App\Models\TransaksiPokok;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dahboard',
        ];
        return view('roleAnggota.dashboard', $data);
    }
    public function pengajuan(Request $request)
    {
        $pinjaman = Pinjaman::where('id_user', Auth::user()->id_user)->orderBy('id_pinjaman', 'asc')->get();
        $data = [
            'title' => 'Pengajuan',
        ];
        return view('roleAnggota.pengajuan', $data, compact('pinjaman'));
    }
    public function createPengajuan(Request $request)
    {
        // Cek apakah ada pengajuan yang masih 'Diproses'
        $pengajuanDiproses = Pinjaman::where('id_user', Auth::user()->id_user)
            ->where('keterangan', 'Diproses')
            ->exists();
    
        if ($pengajuanDiproses) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Anda memiliki pengajuan yang sedang diproses.',
            ]);
        }
    
        // Validasi data pengajuan
        $validatedData = $request->validate([
            'tgl_pengajuan' => 'required|date_format:Y-m-d H:i:s',
            'besar_pinjaman' => 'required|integer|max:100000000',
            'tenor_pinjaman' => 'required|integer|max:50',
        ]);
        $validatedData['id_user'] = Auth::user()->id_user;
        $validatedData['keterangan'] = 'Diproses';
    
        Pinjaman::create($validatedData);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Pengajuan berhasil ditambahkan.',
        ]);
    }     

    public function tanggungan()
    {
        $transaksiPokok = TransaksiPokok::with('simpananPokok.user')
            ->whereHas('simpananPokok', function ($query) {
                $query->where('keterangan', 'Belum Lunas')
                    ->where('id_user', Auth::user()->id_user);
            })->get();

        $transaksiPinjaman = TransaksiPinjaman::with('tanggungan.pinjaman.user')
            ->whereHas('tanggungan.pinjaman', function ($query) {
                $query->where('status_pinjaman', 'Belum Lunas')
                    ->where('id_user', Auth::user()->id_user);
            })->get(); 

        $data = [
            'title' => 'Tanggungan',
        ];

        return view('roleAnggota.tanggungan', $data, compact('transaksiPinjaman', 'transaksiPokok'));
    }

    public function updateSimpanan(Request $request, $id_transaksiPokok)
    {
        $transaksiPokok = TransaksiPokok::findOrFail($id_transaksiPokok);
        $tanggungan = $transaksiPokok->simpananPokok;
    
        // Periksa apakah status pembayarannya adalah "lunas" atau semacamnya
        $statusPembayaran = $request->input('status');
        if ($statusPembayaran == 'Lunas') {
            $tanggungan->total_simpanan += $tanggungan->iuran;
            $tanggungan->status_simpanan = 'Lunas';

            $tanggungan->save();
        }
    
        // Update keterangan dan tanggal pembayaran di transaksi pinjaman
        $transaksiPokok->keterangan = $statusPembayaran;
        $transaksiPokok->tanggal_pembayaran = now()->timezone('Asia/Jakarta');
        $transaksiPokok->save();
    
        return redirect()->route('tanggungan.view');
    }

    public function updatePinjaman(Request $request, $id_transaksiPinjaman)
    {
        $transaksiPinjaman = TransaksiPinjaman::findOrFail($id_transaksiPinjaman);
        $tanggungan = $transaksiPinjaman->tanggungan;
    
        // Periksa apakah status pembayarannya adalah "lunas" atau semacamnya
        $statusPembayaran = $request->input('status');
        if ($statusPembayaran == 'Lunas') {
            $tanggungan->sisa_pinjaman -= $tanggungan->iuran_perBulan;
            
            // Periksa apakah sisa pinjaman menjadi 0 atau kurang, jika iya maka set status ke "Lunas"
            if ($tanggungan->sisa_pinjaman <= 0) {
                $tanggungan->sisa_pinjaman = 0;
                $tanggungan->status_pinjaman = 'Lunas';
            }
            $tanggungan->save();
        }
    
        // Update keterangan dan tanggal pembayaran di transaksi pinjaman
        $transaksiPinjaman->keterangan = $statusPembayaran;
        $transaksiPinjaman->tanggal_pembayaran = now()->timezone('Asia/Jakarta');
        $transaksiPinjaman->save();
    
        return redirect()->route('tanggungan.view');
    }

    public function history()
    {
        $history = Tanggungan::with('pinjaman.user')
            ->whereHas('pinjaman', function ($query) {
                $query->where('keterangan', 'Disetujui')
                    ->where('id_user', Auth::user()->id_user);
            })->get();

        $data = [
            'title' => 'History',
        ];
        return view('roleAnggota.history', $data, compact('history'));
    }
    public function helpdesk()
    {
        $data = [
            'title' => 'Helpdesk',
        ];
        return view('roleAnggota.helpdesk', $data);
    }

    // --------------------------------------- PROFILE ----------------------------------------
    public function viewUser(Request $request): View
    {
        $data = [
            'title' => 'Profile',
        ];
        return view('roleAnggota.profile.view', [
            'user' => $request->user(), $data,
        ]);
    }
    public function updateUser(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.view')->with('status', 'profile-updated');
    }
}