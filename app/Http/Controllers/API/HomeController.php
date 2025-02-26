<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Prestasi;
use App\Models\Jabatan;
use App\Models\TugasTambahan;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function getDashboard(): JsonResponse
    {
        $user = Auth::user();

        $notifikasi = Notifikasi::where('id_user', $user->id_user)->get();

        // Data summary
        $data = [
            'total_pegawai' => Pegawai::count(),
            'total_operator' => User::where('role', 'operator')->count(),
            'total_user' => User::count(),
            'total_prestasi' => Prestasi::count(),
            'total_jabatan' => Jabatan::count(),
            'total_tugas' => TugasTambahan::count(),
        ];

        // Percentage changes compared to last week
        $lastWeek = Carbon::now()->subWeek();
        $data += [
            'pegawai_change' => $this->getPercentageChange(
                Pegawai::where('created_at', '<=', $lastWeek)->count(),
                $data['total_pegawai']
            ),
            'operator_change' => $this->getPercentageChange(
                User::where('role', 'operator')->where('created_at', '<=', $lastWeek)->count(),
                $data['total_operator']
            ),
            'user_change' => $this->getPercentageChange(
                User::where('created_at', '<=', $lastWeek)->count(),
                $data['total_user']
            ),
            'prestasi_change' => $this->getPercentageChange(
                Prestasi::where('status', 'diterima')->where('created_at', '<=', $lastWeek)->count(),
                Prestasi::where('status', 'diterima')->count()
            ),
            'jabatan_change' => $this->getPercentageChange(
                Jabatan::where('created_at', '<=', $lastWeek)->count(),
                $data['total_jabatan']
            ),
            'tugas_change' => $this->getPercentageChange(
                TugasTambahan::where('created_at', '<=', $lastWeek)->count(),
                $data['total_tugas']
            ),
        ];

        // Chart data
        $data += [
            'chart_status_pegawai' => $this->getChartData(Pegawai::class, 'status_kepegawaian'),
            'chart_status_akun' => $this->getChartData(User::class, 'status_akun'),
            'chart_jenis_kelamin' => $this->getChartData(Pegawai::class, 'jenis_kelamin'),
            'chart_weekly_pegawai' => $this->getWeeklyData(Pegawai::class),
            'chart_monthly_login' => $this->getMonthlyLoginData(),
            'chart_jabatan_distribution' => $this->getJabatanDistribution(),
            'chart_age_distribution' => $this->getAgeDistribution(),
            'chart_education_distribution' => $this->getEducationDistribution(),
        ];

        // Add user profile info
        $data['user'] = [
            'nama_user' => $user->nama_user,
            'foto_profil' => asset('foto_profil/' . $user->foto_profil),
        ];

        $data['notifikasi'] = $notifikasi->whereNull('read_at')->count();

        return response()->json($data);
    }

    private function getChartData($model, $column)
    {
        return $model::select($column, DB::raw('count(*) as total'))
            ->groupBy($column)
            ->get()
            ->pluck('total', $column);
    }

    private function getPercentageChange($old, $new)
    {
        return $old === 0 ? 100 : round((($new - $old) / $old) * 100, 1);
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
            $query->whereNotNull('tanggal_lahir')
                ->selectRaw('id_jabatan, jenis_kelamin, TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) as usia');
        }])
            ->withCount('pegawai')
            ->orderBy('level_jabatan', 'desc')
            ->orderByDesc('pegawai_count')
            ->take(15)
            ->get()
            ->map(function ($jabatan) {
                $pegawai = $jabatan->pegawai;

                $totalPegawai = $pegawai->count();
                $averageAge = $totalPegawai > 0 ? $pegawai->avg('usia') : 0;
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
            ->toArray();
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
}
