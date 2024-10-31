<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Log::with('user')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery->where('action', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('nama_user', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->start_date, function ($query, $start_date) {
                $query->where('created_at', '>=', $start_date);
            })
            ->when($request->end_date, function ($query, $end_date) {
                $query->where('created_at', '<=', $end_date);
            })
            ->get();

        return view('admin.log.index', compact('logs'));
    }

}
