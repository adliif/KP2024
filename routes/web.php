<?php

use Illuminate\Support\Facades\Route;


Route::get('/login', function () {
    return view('login', ['title' => 'Login']);
});

/* Routes Role Admin
    ------------ */


// Routes Role Anggota

Route::get('/', function () {
    return view('index', ['title' => 'Dashboard']);
});

Route::get('/tanggungan', function () {
    return view('/roleAnggota/tanggungan', ['title' => 'Tanggungan']);
});

Route::get('/history', function () {
    return view('/roleAnggota/history', ['title' => 'History']);
});

Route::get('/profile', function () {
    return view('/roleAnggota/profile', ['title' => 'Profile']);
});

Route::get('/helpdesk', function () {
    return view('/roleAnggota/helpdesk', ['title' => 'Helpdesk']);
});

Route::get('/logout', function () {
    return view('/roleAnggota/logout', ['title' => 'Logout']);
});