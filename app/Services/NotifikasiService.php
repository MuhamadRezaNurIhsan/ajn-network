<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifikasiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('FONNTE_API_KEY');
        $this->baseUrl = env('FONNTE_BASE_URL', 'https://api.fonnte.com');
    }

    /**
     * Kirim pesan WhatsApp via Fonnte API
     */
    public function kirimWA($nomor, $pesan)
    {
        try {
            // Bersihkan nomor: hilangkan spasi, tanda kurung, strip
            $nomor = preg_replace('/[^0-9]/', '', $nomor);
            
            // Jika nomor dimulai dengan 0, ganti dengan 62 (kode Indonesia)
            if (substr($nomor, 0, 1) == '0') {
                $nomor = '62' . substr($nomor, 1);
            }
            
            // Pastikan nomor tidak kosong
            if (empty($nomor)) {
                Log::error("Nomor tujuan kosong");
                return false;
            }

            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->post($this->baseUrl . '/send', [
                'target' => $nomor,
                'message' => $pesan,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                Log::info("WA terkirim ke $nomor", ['response' => $result]);
                return true;
            } else {
                Log::error("Gagal kirim WA ke $nomor", [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Exception kirim WA: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim SMS (jika diperlukan)
     */
    public function kirimSMS($nomor, $pesan)
    {
        try {
            $nomor = preg_replace('/[^0-9]/', '', $nomor);
            if (substr($nomor, 0, 1) == '0') {
                $nomor = '62' . substr($nomor, 1);
            }

            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->post($this->baseUrl . '/send', [
                'target' => $nomor,
                'message' => $pesan,
                'gateway' => 'sms'
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Exception kirim SMS: " . $e->getMessage());
            return false;
        }
    }
}