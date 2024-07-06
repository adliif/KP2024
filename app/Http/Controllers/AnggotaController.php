<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Rules\MatchOldPassword;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AnggotaController extends Controller
{
    public function index()
    {
        $data =[
            'title' => 'Dahboard',
        ];
        return view('roleAnggota.dashboard', $data);
    }

    public function tanggungan()
    {
        $data =[
            'title' => 'Tanggungan',
        ];
        return view('roleAnggota.tanggungan', $data);
    }
    
    public function history()
    {
        $data =[
            'title' => 'History',
        ];
        return view('roleAnggota.history', $data);
    }
    public function helpdesk()
    {
        $data =[
            'title' => 'Helpdesk',
        ];
        return view('roleAnggota.helpdesk', $data);
    }

    // --------------------------------------- PROFILE ----------------------------------------
    public function viewUser(Request $request): View
    {
        $data =[
            'title' => 'Profile',
        ];
        return view('roleAnggota.profile.view', [
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