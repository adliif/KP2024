<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Rules\MatchOldPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
        ];
        return view('roleAdmin.dashboard', $data);
    }
    public function dataAnggota(){
        $data = [
            'title' => 'Data Anggota',
        ];
        return view('roleAdmin.dataAnggota', $data);
    }
    public function dataSimpananPokok(){
        $data = [
            'title' => 'Data Simpanan Pokok',
        ];
        return view('roleAdmin.dataSimpananPokok', $data);
    }
    public function dataPinjaman(){
        $data = [
            'title' => 'Data Pinjaman',
        ];
        return view('roleAdmin.dataPinjaman', $data);
    }
    public function dataAngsuran(){
        $data = [
            'title' => 'Data Angsuran',
        ];
        return view('roleAdmin.dataAngsuran', $data);
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