<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use App\Models\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\Auth; // Import Auth Facade

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

            // --- PERBAIKAN UTAMA DI SINI ---
            // Cek apakah ada pengguna yang login. Jika ya, gunakan ID-nya.
            // Jika tidak (misalnya saat logout), gunakan null.
            if (Auth::check()) {
                $log['user_id'] = Auth::id();
            } else {
                // Untuk aktivitas yang terjadi tanpa sesi (seperti gagal login),
                // kita bisa biarkan user_id kosong atau set default.
                $log['user_id'] = null;
            }

            LogActivityModel::create($log);
        } catch (\Exception $e) {
            // Jika gagal, catat error di file log Laravel
            Log::error('Gagal menyimpan aktivitas log: ' . $e->getMessage());
        }
    }
}
