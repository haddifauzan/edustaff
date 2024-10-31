<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DeletedDataController extends Controller
{
    // Menampilkan data yang terhapus berdasarkan jenis model
    public function deleted_admin(Request $request, $modelType)
    {
        // Map model type to model class
        $modelClass = $this->getModelClass($modelType);

        // Jika model tidak ditemukan, kembalikan 404
        if (!$modelClass) {
            abort(404);
        }

        $query = $modelClass::onlyTrashed();

        // Pencarian berdasarkan nama atau asal data
        if ($request->filled('search')) {
            // Menyesuaikan pencarian berdasarkan tipe model
            if ($modelType == 'kelas') {
                // Pencarian berdasarkan jurusan pada kelas
                $query->whereHas('kelas', function ($q) use ($request) {
                    $q->where('nama_kelas', 'like', '%' . $request->search . '%');
                });
            } elseif ($modelType == 'mapel') {
                // Pencarian berdasarkan nama pelajaran atau kode pelajaran
                $query->where(function ($q) use ($request) {
                    $q->where('nama_pelajaran', 'like', '%' . $request->search . '%')
                        ->orWhere('kode_pelajaran', 'like', '%' . $request->search . '%');
                });
            } elseif ($modelType == 'jabatan') {
                // Pencarian berdasarkan nama jabatan
                $query->where('nama_jabatan', 'like', '%' . $request->search . '%');
            } elseif ($modelType == 'jurusan') {
                // Pencarian berdasarkan nama jurusan dan singkatan
                $query->where(function ($q) use ($request) {
                    $q->where('nama_jurusan', 'like', '%' . $request->search . '%')
                        ->orWhere('singkatan', 'like', '%' . $request->search . '%');
                });
            } else {
                // Pencarian umum berdasarkan nama (untuk tipe model yang lain)
                $query->where('nama', 'like', '%' . $request->search . '%');
            }
        } else {
            // Jika search kosong, tampilkan semua data
            $query->select('*');
        }

        // Dapatkan data yang dihapus
        $deletedData = $query->get();

        return view('admin.deleted.index', compact('deletedData', 'modelType'));
    }

    public function deleted_operator(Request $request, $modelType)
    {
        // Map model type to model class
        $modelClass = $this->getModelClass($modelType);

        // Jika model tidak ditemukan, kembalikan 404
        if (!$modelClass) {
            abort(404);
        }

        $query = $modelClass::onlyTrashed();

        // Pencarian berdasarkan nama atau asal data
        if ($request->filled('search')) {
            // Menyesuaikan pencarian berdasarkan tipe model
            if ($modelType == 'prestasi') {
                // Pencarian berdasarkan jurusan pada kelas
                $query->whereHas('prestasi', function ($q) use ($request) {
                    $q->where('nama_prestasi', 'like', '%' . $request->search . '%');
                });
            } elseif ($modelType == 'pegawai') {
                $query->where(function ($q) use ($request) {
                    $q->where('nama_pegawai', 'like', '%' . $request->search . '%')
                        ->orWhere('nik', 'like', '%' . $request->search . '%');
                });
            }
            else {
                // Pencarian umum berdasarkan nama (untuk tipe model yang lain)
                $query->where('nama', 'like', '%' . $request->search . '%');
            }
        } else {
            // Jika search kosong, tampilkan semua data
            $query->select('*');
        }

        // Dapatkan data yang dihapus
        $deletedData = $query->get();

        return view('operator.deleted.index', compact('deletedData', 'modelType'));
    }


    // Menghapus data secara permanen
    public function forceDelete($modelType, $id)
    {
        $modelClass = $this->getModelClass($modelType);

        if (!$modelClass) {
            abort(404);
        }

        $data = $modelClass::withTrashed()->findOrFail($id);
        $data->forceDelete();

        if (auth()->user()->role == 'Operator') {
            return redirect()->route('operator.deleted', ['modelType' => $modelType])->with('success', 'Data berhasil dihapus permanen');
        } else {
            return redirect()->route('admin.deleted', ['modelType' => $modelType])->with('success', 'Data berhasil dihapus permanen');
        }
    }

    // Memulihkan data yang dihapus
    public function restore($modelType, $id)
    {
        $modelClass = $this->getModelClass($modelType);

        if (!$modelClass) {
            abort(404);
        }

        $data = $modelClass::withTrashed()->findOrFail($id);
        $data->restore();

        if (auth()->user()->role == 'Operator') {
            return redirect()->route('operator.deleted', ['modelType' => $modelType])->with('success', 'Data berhasil dipulihkan');
        } else {
            return redirect()->route('admin.deleted', ['modelType' => $modelType])->with('success', 'Data berhasil dipulihkan');
        }
    }

    // Fungsi untuk mendapatkan model yang sesuai dengan parameter tipe model
    protected function getModelClass($modelType)
    {
        switch ($modelType) {
            case 'kelas':
                return \App\Models\Kelas::class;
            case 'jurusan':
                return \App\Models\Jurusan::class;
            case 'jabatan':
                return \App\Models\Jabatan::class;
            case 'mapel':
                return \App\Models\Mapel::class;
            case 'pegawai':
                return \App\Models\Pegawai::class;
            case 'prestasi':
                return \App\Models\Prestasi::class;
            default:
                return null; // Jika tidak ada tipe yang cocok, kembalikan null
        }
    }
}
