<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePegawaiController extends Controller
{
    public function index()
    {
        return view('pegawai.dashboard');
    }

    public function profile()
    {
        $pegawai = auth()->user()->pegawai;
        return view('pegawai.profile', compact('pegawai'));
    }
}
