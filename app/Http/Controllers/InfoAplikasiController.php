<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoAplikasiController extends Controller
{
    public function index()
    {
        return view('vendor.info');
    }
}
