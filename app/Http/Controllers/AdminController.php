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
}