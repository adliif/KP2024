<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use App\Models\Tanggungan;
use App\Models\SimpananPokok;
use App\Models\TransaksiPinjaman;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('usertype', 'user')->count();
        $totalBesarPinjaman = Pinjaman::sum('besar_pinjaman');
        $data = [
            'title' => 'Dashboard',
        ];
        return view('roleAdmin.dashboard', $data, compact('totalUsers', 'totalBesarPinjaman'));
    }

    public function dataAnggota()
    {
        $users = User::where('usertype', 'user')->orderBy('id_user', 'asc')->get();
        $data = [
            'title' => 'Data Anggota',
        ];
        return view('roleAdmin.dataAnggota', $data, compact('users'));
    }

    public function editAnggota($id_user)
    {
        $user = User::findOrFail($id_user);
        return response()->json($user);
    }

    public function updateUser(Request $request, $id_user)
    {
        $user = User::findOrFail($id_user);
        $user->update($request->all());

        return redirect()->route('dataAnggota')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function dataSimpananPokok()
    {
        $simpanan = SimpananPokok::orderBy('id_simpanan_pokok', 'asc')->get();
        $data = [
            'title' => 'Data Simpanan Pokok',
        ];
        return view('roleAdmin.dataSimpananPokok', $data, compact('simpanan'));
    }

    public function dataPinjaman()
    {
        $pinjaman = Pinjaman::orderBy('id_pinjaman', 'asc')->get();
        $data = [
            'title' => 'Data Pinjaman',
        ];
        return view('roleAdmin.dataPinjaman', $data, compact('pinjaman'));
    }

    protected function createTanggungan($pinjaman)
    {
        $besar_pinjaman = $pinjaman->besar_pinjaman;
        // Bunga tahunan default
        $bunga_bulanan = 0.08;
        // Jumlah cicilan
        $tenor = $pinjaman->tenor_pinjaman;
        //jumlah bunga
        $jumlah_bunga = $besar_pinjaman * 0.08;
        //total pinjaman
        $total_pembayaran = $besar_pinjaman + ($bunga_bulanan * $besar_pinjaman);
        //pembayaran bulanan
        $pembayaran_bulanan = $total_pembayaran / $tenor;

        // Buat data tanggungan
        $tanggungan = Tanggungan::create([
            'id_pinjaman' => $pinjaman->id_pinjaman,
            'total_pinjaman' => $total_pembayaran,
            'bunga_pinjaman' => $jumlah_bunga,
            'iuran_perBulan' => $pembayaran_bulanan,
            'sisa_pinjaman' => $total_pembayaran,
            'status_pinjaman' => 'Belum Lunas'
        ]);

        // Pastikan tanggungan berhasil dibuat
        if ($tanggungan) {
            $jatuh_tempo_awal = now()->endOfDay(); // Menggunakan tanggal saat ini sebagai jatuh tempo awal, dan mengatur jam ke 00:00:00
            for ($i = 1; $i <= $tenor; $i++) {
                $jatuh_tempo = $jatuh_tempo_awal->copy()->addMonths($i);
                TransaksiPinjaman::create([
                    'id_tanggungan' => $tanggungan->id_tanggungan,
                    'jatuh_tempo' => $jatuh_tempo,
                    'tanggal_pembayaran' => null, // Set tanggal pembayaran ke null karena belum dibayar
                    'keterangan' => 'Bayar cicilan ke-' . $i
                ]);
            }
        }
    }

    public function updatePinjamanStatus(Request $request, $id_pinjaman)
    {
        $pinjaman = Pinjaman::findOrFail($id_pinjaman);
        $pinjaman->keterangan = $request->input('status');
        $pinjaman->save();

        if ($pinjaman->keterangan == 'Disetujui') {
            $this->createTanggungan($pinjaman);
        }

        return response()->json(['success' => true]);
    }

    public function dataTanggungan()
    {
        $tanggungan = Tanggungan::with('pinjaman.user')->whereHas('pinjaman', function ($query) {
            $query->where('keterangan', 'Disetujui');
        })->get();

        $data = [
            'title' => 'Data Tanggungan',
        ];

        return view('roleAdmin.dataTanggungan', $data, compact('tanggungan'));
    }

    public function destroyUser(Request $request, $id)
    {
        $user = User::findOrFail($id)->delete();
        return redirect(route('dataAnggota'));
    }
}
