<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Pinjaman;
use App\Models\SimpananPokok;
use App\Models\Tanggungan;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index()
    {
        $total = User::count();
        $data = [
            'title' => 'Dashboard',
        ];
        return view('roleAdmin.dashboard', $data, compact(['total']));
    }
    public function register(){
        $data = [
            'title' => 'Register'
        ];
        return view('auth.register', $data);
    }
    public function dataAnggota(){
        $users = User::orderBy('id_user', 'asc')->get();
        $total = User::count();
        $data = [
            'title' => 'Data Anggota',
        ];
        return view('roleAdmin.dataAnggota', $data, compact(['users', 'total']));
    }
    public function dataSimpananPokok(){
        $simpanan = SimpananPokok::orderBy('id_simpanan_pokok', 'asc')->get();
        $data = [
            'title' => 'Data Simpanan Pokok',
        ];
        return view('roleAdmin.dataSimpananPokok', $data, compact('simpanan'));
    }
    public function dataPinjaman(){
        $pinjaman = Pinjaman::orderBy('id_pinjaman', 'asc')->get();
        $data = [
            'title' => 'Data Pinjaman',
        ];
        return view('roleAdmin.dataPinjaman', $data, compact('pinjaman'));
    }
    public function dataTanggungan(){
        $tanggungan = Tanggungan::with('pinjaman.user')->get();
        $data = [
            'title' => 'Data Tanggungan',
        ];
        return view('roleAdmin.dataTanggungan', $data, compact('tanggungan'));
    }

    // --------------------------------------- PROFILE ----------------------------------------
    public function viewUser(Request $request): View
    {
        $data = [
            'title' => 'Profile',
        ];
        return view('roleAdmin.profile.view', [
            'user' => $request->user(), $data
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