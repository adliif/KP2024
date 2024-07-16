<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pinjaman;
use App\Models\Tanggungan;
use Illuminate\Http\Request;
use App\Models\SimpananPokok;
use App\Models\TransaksiPokok;
use App\Models\TransaksiPinjaman;
use Illuminate\Support\Facades\DB;

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

    public function buatTransaksiSimpanan(Request $request)
    {
        $simpananList = SimpananPokok::all();
        $allLunas = true;

        // Periksa apakah semua SimpananPokok berstatus Lunas
        foreach ($simpananList as $simpanan) {
            if ($simpanan->status_simpanan !== 'Lunas') {
                $allLunas = false;
                break;
            }
        }

        if (!$allLunas) {
            return response()->json(['message' => 'Beberapa pengguna belum melunasi transaksi sebelumnya'], 400);
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        foreach ($simpananList as $simpanan) {
            $params = [
                'transaction_details' => [
                    'order_id' => rand(),
                    'gross_amount' => $simpanan->iuran,
                ],
                'customer_details' => [
                    'first_name' => $simpanan->user->nama,
                    'email' => $simpanan->user->email,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Set jatuh_tempo to the first day of the next month ->startOfMonth()
            $now = now();
            $jatuh_tempo = $now->copy()->addMonth();

            TransaksiPokok::create([
                'id_simpanan_pokok' => $simpanan->id_simpanan_pokok,
                'jatuh_tempo' => $jatuh_tempo,
                'snap_token' => $snapToken,
                'keterangan' => 'Belum Lunas',
            ]);

            $simpanan->status_simpanan = 'Belum Lunas';
            $simpanan->save();
        }

        return response()->json(['message' => 'Semua transaksi berhasil dibuat']);
    }

    // public function updateTransaksiPokok(Request $request, $id)
    // {
    //     $transaksi = TransaksiPokok::find($id);
    //     if ($transaksi) {
    //         $transaksi->keterangan = $request->input('keterangan');
    //         $transaksi->save();

    //         // Update the corresponding SimpananPokok status if needed
    //         if ($transaksi->keterangan == 'Lunas') {
    //             $simpananPokok = SimpananPokok::find($transaksi->id_simpanan_pokok);
    //             if ($simpananPokok) {
    //                 $simpananPokok->status_simpanan = 'Lunas';
    //                 $simpananPokok->save();
    //             }
    //         }

    //         return response()->json(['message' => 'Transaksi Pokok updated successfully']);
    //     } else {
    //         return response()->json(['message' => 'Transaksi Pokok not found'], 404);
    //     }
    // }

    public function checkSimpananStatus()
    {
        $simpananList = SimpananPokok::all();
        $disableButton = false;

        foreach ($simpananList as $simpanan) {
            if ($simpanan->status_simpanan === 'Belum Lunas') {
                $disableButton = true;
                break;
            }
        }

        return response()->json(['disableButton' => $disableButton]);
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

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        // Pastikan tanggungan berhasil dibuat
        if ($tanggungan) {
            $jatuh_tempo_awal = now()->endOfDay(); // Menggunakan tanggal saat ini sebagai jatuh tempo awal, dan mengatur jam ke 00:00:00
            for ($i = 1; $i <= $tenor; $i++) {
                $params = array(
                    'transaction_details' => array(
                        'order_id' => rand(),
                        'gross_amount' => $pembayaran_bulanan,
                    ),
                    'customer_details' => array(
                        'first_name' => $tanggungan->pinjaman->user->nama,
                        'email' => $tanggungan->pinjaman->user->email,
                    ),
                );
                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $jatuh_tempo = $jatuh_tempo_awal->copy()->addMonths($i);
                TransaksiPinjaman::create([
                    'id_tanggungan' => $tanggungan->id_tanggungan,
                    'jatuh_tempo' => $jatuh_tempo,
                    'tanggal_pembayaran' => null, // Set tanggal pembayaran ke null karena belum dibayar
                    'snap_token' => $snapToken,
                    'keterangan' => 'Bayar cicilan ke-' . $i
                ]);
            }
        }
    }

    public function updatePinjamanStatus(Request $request, $id_pinjaman)
    {
        DB::beginTransaction();

        try {
            $pinjaman = Pinjaman::findOrFail($id_pinjaman);
            $pinjaman->keterangan = $request->input('status');
            $pinjaman->save();

            if ($pinjaman->keterangan == 'Disetujui') {
                $this->createTanggungan($pinjaman);
            }

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Error updating status', 'error' => $e->getMessage()], 500);
        }
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

    public function viewTransaksiSimpanan(){
        $transaksiPokok = TransaksiPokok::orderBy('id_transaksiPokok', 'asc')->get();

        $data = [
            'title' => 'Transaksi Simpanan'
        ];

        return view('roleAdmin.transaksiSimpanan', $data, compact('transaksiPokok'));
    }

    public function viewTransaksiPinjaman(){
        $transaksiPinjaman = TransaksiPinjaman::orderBy('id_transaksiPinjaman', 'asc')->get();

        $data = [
            'title' => 'Transaksi Simpanan'
        ];

        return view('roleAdmin.transaksiPinjaman', $data, compact('transaksiPinjaman'));
    }
}
