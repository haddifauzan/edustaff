<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Prestasi;
use App\Models\Jabatan;
use App\Models\TugasTambahan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomePegawaiController extends Controller
{
    public function index()
    {
        // Cards Summary Data
        $data['total_pegawai'] = Pegawai::count();
        $data['total_operator'] = User::where('role', 'operator')->count();
        $data['total_user'] = User::count();
        $data['total_prestasi'] = Prestasi::count();
        $data['total_jabatan'] = Jabatan::count();
        $data['total_tugas'] = TugasTambahan::count();

        // Percentage changes for cards (compared to last week)
        $lastWeek = Carbon::now()->subWeek();
        
        $data['pegawai_change'] = $this->getPercentageChange(
            Pegawai::where('created_at', '<=', $lastWeek)->count(),
            $data['total_pegawai']
        );

        $data['operator_change'] = $this->getPercentageChange(
            User::where('role', 'operator')->where('created_at', '<=', $lastWeek)->count(),
            $data['total_operator']
        );

        $data['user_change'] = $this->getPercentageChange(
            User::where('created_at', '<=', $lastWeek)->count(),
            $data['total_user']
        );

        $data['prestasi_change'] = $this->getPercentageChange(
            Prestasi::where('status', 'diterima')->where('created_at', '<=', $lastWeek)->count(),
            Prestasi::where('status', 'diterima')->count()
        );

        $data['jabatan_change'] = $this->getPercentageChange(
            Jabatan::where('created_at', '<=', $lastWeek)->count(),
            $data['total_jabatan']
        );

        $data['tugas_change'] = $this->getPercentageChange(
            TugasTambahan::where('created_at', '<=', $lastWeek)->count(),
            $data['total_tugas']
        );

        // Latest Data with relationships
        $data['pegawai_terbaru'] = Pegawai::with(['jabatan', 'prestasi'])
            ->latest()
            ->take(5)
            ->get();
        
        $data['prestasi_terbaru'] = Prestasi::with(['pegawai' => function($query) {
                $query->with('jabatan');
            }])
            ->where('status', 'diterima')
            ->latest()
            ->take(4)
            ->get();

        $data['jabatan_terbaru'] = Jabatan::withCount('pegawai')
            ->latest()
            ->take(5)
            ->get();

        // Chart Data
        // Status Pegawai Chart (Pie)
        $status_pegawai = Pegawai::select('status_kepegawaian', DB::raw('count(*) as total'))
            ->groupBy('status_kepegawaian')
            ->get();
        $data['chart_status_pegawai'] = [
            'labels' => $status_pegawai->pluck('status_kepegawaian'),
            'data' => $status_pegawai->pluck('total')
        ];

        // Status Akun Chart (Donut)
        $status_akun = User::select('status_akun', DB::raw('count(*) as total'))
            ->groupBy('status_akun')
            ->get();
        $data['chart_status_akun'] = [
            'labels' => $status_akun->pluck('status_akun'),
            'data' => $status_akun->pluck('total')
        ];

        // Gender Distribution Chart (Radial)
        $jenis_kelamin = Pegawai::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->get();
        $data['chart_jenis_kelamin'] = [
            'labels' => $jenis_kelamin->pluck('jenis_kelamin'),
            'data' => $jenis_kelamin->pluck('total')
        ];

        // Monthly Growth Charts (Line)
        $data['chart_weekly_pegawai'] = $this->getWeeklyData(Pegawai::class);
        $data['chart_monthly_login'] = $this->getMonthlyLoginData();
        
        // Department Distribution
        $data['chart_jabatan_distribution'] = $this->getJabatanDistribution();
        
        // Age Distribution
        $data['chart_age_distribution'] = $this->getAgeDistribution();

        // Education Level Distribution
        $data['chart_education_distribution'] = $this->getEducationDistribution();

        return view('pegawai.dashboard', $data);
    }

    private function getPercentageChange($old, $new)
    {
        if ($old == 0) return 100;
        return round((($new - $old) / $old) * 100, 1);
    }

    private function getWeeklyData($model)
    {
        return $model::select(
            DB::raw('DATE_FORMAT(created_at, "%d %b %Y") as date'),
            DB::raw('count(*) as total')
        )
            ->whereBetween('created_at', [Carbon::now()->subWeeks(11), Carbon::now()])
            ->orderBy('created_at')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();
    }

    private function getMonthlyLoginData()
    {
        return User::select(
            DB::raw('DATE_FORMAT(last_login, "%Y-%m") as month'),
            DB::raw('count(distinct id_user) as total')
        )
            ->whereNotNull('last_login')
            ->whereBetween('last_login', [Carbon::now()->subMonths(11), Carbon::now()])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();
    }

    private function getJabatanDistribution()
    {
        return Jabatan::with(['pegawai' => function ($query) {
                    // Hanya ambil pegawai dengan tanggal lahir valid
                    $query->whereNotNull('tanggal_lahir')
                        ->selectRaw('id_jabatan, jenis_kelamin, TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) as usia');
                }])
                ->withCount('pegawai')
                ->orderBy('level_jabatan', 'desc') // Urutkan berdasarkan level jabatan terlebih dahulu
                ->orderByDesc('pegawai_count')
                ->take(15)
                ->get()
                ->map(function ($jabatan) {
                    $pegawai = $jabatan->pegawai;

                    // Hitung total pegawai
                    $totalPegawai = $pegawai->count();

                    // Hitung rata-rata usia (cek jika ada pegawai dengan usia)
                    $averageAge = $totalPegawai > 0 ? $pegawai->avg('usia') : 0;

                    // Hitung rasio gender
                    $maleCount = $pegawai->where('jenis_kelamin', 'L')->count();
                    $femaleCount = $pegawai->where('jenis_kelamin', 'P')->count();
                    $genderRatio = [
                        'male' => $totalPegawai > 0 ? ($maleCount / $totalPegawai) * 100 : 0,
                        'female' => $totalPegawai > 0 ? ($femaleCount / $totalPegawai) * 100 : 0,
                    ];

                    return [
                        'name' => $jabatan->nama_jabatan,
                        'total' => $totalPegawai,
                        'average_age' => $averageAge,
                        'gender_ratio' => $genderRatio,
                        'level' => $jabatan->level_jabatan ?? null,
                        'golongan' => $jabatan->golongan ?? null,
                    ];
                });
    }

    private function getAgeDistribution()
    {
        return Pegawai::select(
            DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) as age'),
            DB::raw('count(*) as total')
        )
            ->whereNotNull('tanggal_lahir')
            ->groupBy('age')
            ->orderBy('age')
            ->get()
            ->groupBy(function ($item) {
                return floor($item->age / 5) * 5 . '-' . (floor($item->age / 5) * 5 + 4);
            })
            ->map(function ($group) {
                return $group->sum('total');
            })
            ->toArray(); // Convert Collection to array
    }


    private function getEducationDistribution()
    {
        return Pegawai::select('pendidikan_terakhir', DB::raw('count(*) as total'))
            ->whereNotNull('pendidikan_terakhir')
            ->groupBy('pendidikan_terakhir')
            ->orderBy('pendidikan_terakhir')
            ->pluck('total', 'pendidikan_terakhir')
            ->toArray();
    }

    public function profile()
    {
        $pegawai = auth()->user()->pegawai;
        return view('pegawai.profile', compact('pegawai'));
    }
}
