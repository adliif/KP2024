<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Pinjaman;
use App\Models\Tanggungan;
use App\Rules\MatchOldPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Symfony\Contracts\Service\Attribute\Required;

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
        $validatedData = $request->validate([
            'tgl_pengajuan' => 'required|date_format:Y-m-d H:i:s',
            'besar_pinjaman' => 'required|integer',
            'tenor_pinjaman' => 'required|integer',
        ]);

        $validatedData['id_user'] = Auth::user()->id_user;
        $validatedData['keterangan'] = 'Diproses';

        Pinjaman::create($validatedData);

        return redirect()->route('pengajuan.view')->with('success', 'Pengajuan berhasil ditambahkan.');
    }

    public function tanggungan()
    {
        $tanggungan = Tanggungan::where('id_pinjaman', Auth::user()->id_user)->orderBy('id_tanggungan', 'asc')->get();
        $data = [
            'title' => 'Tanggungan',
        ];
        return view('roleAnggota.tanggungan', $data, compact('tanggungan'));
    }

    public function history()
    {
        $data = [
            'title' => 'History',
        ];
        return view('roleAnggota.history', $data);
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
    public function destroyUser(Request $request)
    {
        $request->validate([
            'password' => ['required', new MatchOldPassword],
        ]);

        $user = $request->user();
        $user->delete();

        return redirect('/')->with('status', 'Account deleted successfully.');
    }
}