<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use App\Models\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\Auth;

trait LogActivity
{
    /**
     * Fungsi untuk menambahkan log ke database.
     *
     * @param string $subject Deskripsi aktivitas
     * @return void
     */
    public function addToLog($subject)
    {
        try {
            $log = [
                'subject'   => $subject,
                'url'       => request()->fullUrl(),
                'method'    => request()->method(),
                'ip'        => request()->ip(),
                'agent'     => request()->header('user-agent'),
            ];

            if (Auth::check()) {
                $log['user_id'] = Auth::id();
            } else {
                $log['user_id'] = null;
            }

            LogActivityModel::create($log);
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan aktivitas log: ' . $e->getMessage());
        }
    }
}
