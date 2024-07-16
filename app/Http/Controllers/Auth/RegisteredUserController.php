<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SimpananPokok;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $data = [
            'title' => 'Register',
        ];
        return view('auth.register', $data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'NIP' => 'required|string|max:255|unique:users',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string|max:255',
            'no_tlp' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'NIP' => $request->NIP,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'password' => bcrypt($request->password),
        ]);

        $this->createSimpananPokok($user->id_user);

        return response()->json(['success' => true]);
    }

    protected function createSimpananPokok($id_user)
    {
        SimpananPokok::create([
            'id_user' => $id_user,
            'iuran' => 100000,
            'total_simpanan' => 0,
            'status_simpanan' => 'Lunas'
        ]);
    }
}
