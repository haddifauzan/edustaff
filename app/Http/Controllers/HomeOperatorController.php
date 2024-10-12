<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeOperatorController
{
    public function index()
    {
        return view('operator.dashboard');
    }
}
