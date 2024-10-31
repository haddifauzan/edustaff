<?php

namespace App\Observers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class ModelObserver
{
    public function creating($model)
    {
        $this->logActivity($model, 'create', $model->getDirty());
    }

    public function updating($model)
    {
        $this->logActivity($model, 'update', $model->getDirty());
    }

    public function deleting($model)
    {
        $this->logActivity($model, 'delete', $model->toArray());
    }

    public function restoring($model)
    {
        $this->logActivity($model, 'restore', $model->toArray());
    }

    public function forceDeleting($model)
    {
        $this->logActivity($model, 'force_delete', $model->toArray());
    }

    /**
     * Helper method untuk mencatat log aktivitas.
     */
    private function logActivity($model, $action, $data)
    {
        if ($this->shouldLog()) {
            Log::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model' => class_basename($model),
                'data' => !empty($data) ? $data : $model->toArray(), // Gunakan data lengkap jika $data kosong
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
    }

    private function shouldLog()
    {
        $user = auth()->user();
        return $user && in_array($user->role, ['Operator', 'Pegawai']);
    }
}
