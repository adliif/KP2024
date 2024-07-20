<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use Illuminate\View\View;
use App\Models\Tanggungan;
use Illuminate\Http\Request;
use App\Models\TransaksiPokok;
use App\Models\TransaksiPinjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class AnggotaController extends Controller
{
    public function index()
    {
        $totalUser = User::where('usertype', 'user')->count();
        $data = [
            'title' => 'Dashboard',
            'user' => $totalUser,
        ];
        return view('roleAnggota.dashboard', $data);
    }

    public function getChartData()
    {
        $userId = Auth::id();

        // Ambil dan proses data total pinjaman untuk user yang sedang login
        $totalPinjaman = DB::table('pinjaman')
        ->select(DB::raw('MONTH(tgl_pengajuan) as month'), DB::raw('SUM(besar_pinjaman) as total'))
        ->where('id_user', $userId)
            ->where('keterangan', 'Disetujui')
            ->groupBy(DB::raw('MONTH(tgl_pengajuan)'))
            ->pluck('total', 'month');

        // Ambil dan proses data total simpanan pokok untuk user yang sedang login
        $totalSimpanan = DB::table('simpanan_pokoks')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_simpanan) as total'))
        ->where('id_user', $userId)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'month');

        // Inisialisasi array data dengan 0 untuk setiap bulan
        $pinjamanData = array_fill(1, 12, 0);
        $simpananData = array_fill(1, 12, 0);

        // Isi array dengan data yang didapat dari query
        foreach ($totalPinjaman as $month => $total) {
            $pinjamanData[$month] = $total;
        }

        foreach ($totalSimpanan as $month => $total) {
            $simpananData[$month] = $total;
        }

        return response()->json([
            'pinjaman' => array_values($pinjamanData),
            'simpanan' => array_values($simpananData)
        ]);
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
    
        $tanggungan = Tanggungan::with('pinjaman.user')
            ->whereHas('pinjaman', function ($query) {
                $query->where('id_user', Auth::user()->id_user);
            })
            ->where('status_pinjaman', 'Belum Lunas')
            ->first();
        
        if ($tanggungan) {
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            \Midtrans\Config::$isProduction = config('midtrans.isProduction');
            \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is3ds');
        
            $besar_pinjaman = $tanggungan->sisa_pinjaman - (($tanggungan->bunga_pinjaman / $tanggungan->pinjaman->tenor_pinjaman) * $tanggungan->sisa_tenor);
        
            $paramsLunas = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => ceil($besar_pinjaman),
                ),
                'customer_details' => array(
                    'first_name' => $tanggungan->pinjaman->user->nama,
                    'email' => $tanggungan->pinjaman->user->email,
                ),
            );
            $snapTokenLunas = \Midtrans\Snap::getSnapToken($paramsLunas);
        
            // Update snapTokenLunas attribute
            $tanggungan->snap_tokenLunas = $snapTokenLunas;
            $tanggungan->save();
        }
    
        $data = [
            'title' => 'Tanggungan',
            'transaksiPinjaman' => $transaksiPinjaman,
            'transaksiPokok' => $transaksiPokok,
            'tanggungan' => $tanggungan,
        ];
    
        return view('roleAnggota.tanggungan', $data);
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
            $tanggungan->sisa_tenor -= 1;
            
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

    public function updatePinjamanLunas(Request $request)
    {
        $tanggungan = Tanggungan::with('pinjaman.user')
            ->whereHas('pinjaman', function ($query) {
                $query->where('id_user', Auth::user()->id_user);
            })->where('status_pinjaman', 'Belum Lunas')->firstOrFail();
    
        $statusPembayaran = $request->input('status');
        if ($statusPembayaran == 'Lunas') {
            $tanggungan->sisa_pinjaman = 0;
            $tanggungan->sisa_tenor = 0;
            $tanggungan->status_pinjaman = 'Lunas';
    
            $tanggungan->save();
        }
    
        // Mengupdate semua transaksi yang berkaitan dengan tanggungan ini
        $transaksiPinjaman = $tanggungan->transaksiPinjaman()->get();
        foreach ($transaksiPinjaman as $transaksi) {
            // Perbarui keterangan dan tanggal pembayaran jika tanggal_pembayaran kosong
            if (is_null($transaksi->tanggal_pembayaran)) {
                $transaksi->keterangan = $statusPembayaran;
                $transaksi->tanggal_pembayaran = now()->timezone('Asia/Jakarta');
                $transaksi->save();
            }
        }
    
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

    // ----------------------------------- DATA TRANSAKSI -------------------------------------
    public function viewTransaksiSimpanan(){
        $transaksiPokok = TransaksiPokok::with('simpananPokok.user')
            ->whereHas('simpananPokok', function ($query) {
                $query->where('keterangan', 'Lunas')
                    ->where('id_user', Auth::user()->id_user);
            })->get();

        $data = [
            'title' => 'Transaksi Simpanan'
        ];

        return view('roleAnggota.transaksiSimpanan', $data, compact('transaksiPokok'));
    }

    public function viewTransaksiPinjaman(){
        $transaksiPinjaman = TransaksiPinjaman::with('tanggungan.pinjaman.user')
            ->whereHas('tanggungan.pinjaman', function ($query) {
                $query->where('id_user', Auth::user()->id_user);
            })->where('keterangan', 'Lunas')->get(); 

        $data = [
            'title' => 'Transaksi Simpanan'
        ];

        return view('roleAnggota.transaksiPinjaman', $data, compact('transaksiPinjaman'));
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