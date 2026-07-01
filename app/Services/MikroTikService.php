<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class MikroTikService
{
    protected $isDummy;
    protected $host;
    protected $user;
    protected $password;
    protected $client;

    public function __construct()
    {
        // Baca dari .env
        $this->host = env('MIKROTIK_HOST', '192.168.1.1');
        $this->user = env('MIKROTIK_USER', 'admin');
        $this->password = env('MIKROTIK_PASSWORD', '');
        
        // Jika password 'dummy' atau kosong, jalankan mode DUMMY
        $this->isDummy = ($this->password === 'dummy' || empty($this->password));
        
        if (!$this->isDummy) {
             $this->client = new \RouterOS\Client([
                 'host' => $this->host,
                 'user' => $this->user,
                 'pass' => $this->password,
                 'port' => 8728,
             ]);
        }
    }

    public function createUser($username, $password, $download, $upload)
    {
        if ($this->isDummy) {
            Log::info("DUMMY: Membuat user MikroTik", [
                'username' => $username,
                'password' => $password,
                'download' => $download . 'M',
                'upload' => $upload . 'M'
            ]);
            return true;
        }

        // REAL MODE: Kirim ke MikroTik asli
        try {
             $query = new \RouterOS\Query('/ip/hotspot/user/add');
             $query->equal('name', $username);
             $query->equal('password', $password);
             $this->client->query($query)->read();
            
            Log::info("REAL: User MikroTik berhasil dibuat", ['username' => $username]);
            return true;
        } catch (\Exception $e) {
            Log::error("Gagal membuat user MikroTik: " . $e->getMessage());
            return false;
        }
    }

    public function disableUser($username)
    {
        if ($this->isDummy) {
            Log::info("DUMMY: Menonaktifkan user MikroTik", ['username' => $username]);
            return true;
        }

        try {
             $query = new \RouterOS\Query('/ip/hotspot/user/set');
             $query->equal('.id', $username);
             $query->equal('disabled', 'yes');
             $this->client->query($query)->read();
            
            Log::info("REAL: User MikroTik dinonaktifkan", ['username' => $username]);
            return true;
        } catch (\Exception $e) {
            Log::error("Gagal menonaktifkan user: " . $e->getMessage());
            return false;
        }
    }

    public function enableUser($username)
    {
        if ($this->isDummy) {
            Log::info("DUMMY: Mengaktifkan user MikroTik", ['username' => $username]);
            return true;
        }

        try {
             $query = new \RouterOS\Query('/ip/hotspot/user/set');
             $query->equal('.id', $username);
             $query->equal('disabled', 'no');
             $this->client->query($query)->read();
            
            Log::info("REAL: User MikroTik diaktifkan", ['username' => $username]);
            return true;
        } catch (\Exception $e) {
            Log::error("Gagal mengaktifkan user: " . $e->getMessage());
            return false;
        }
    }

    public function getBandwidth($interface = 'ether1')
    {
        if ($this->isDummy) {
            return [
                'rx_bits_per_second' => rand(10 * 1000000, 50 * 1000000),
                'tx_bits_per_second' => rand(5 * 1000000, 30 * 1000000),
            ];
        }

        try {
             $query = new \RouterOS\Query('/interface/monitor-traffic');
             $query->equal('interface', $interface);
             $query->equal('once', '');
             $response = $this->client->query($query)->read();
            
             return [
                 'rx_bits_per_second' => $response[0]['rx-bits-per-second'] ?? 0,
                 'tx_bits_per_second' => $response[0]['tx-bits-per-second'] ?? 0,
             ];
            
             return ['rx_bits_per_second' => 0, 'tx_bits_per_second' => 0];
        } catch (\Exception $e) {
            Log::error("Gagal mengambil bandwidth: " . $e->getMessage());
            return null;
        }
    }

    public function getActiveUsers()
    {
        if ($this->isDummy) {
            return [
                ['name' => 'ahmad_fauzi', 'uptime' => '02:30:00', 'bytes-in' => 1024],
                ['name' => 'budi_santoso', 'uptime' => '05:45:00', 'bytes-in' => 2048],
            ];
        }

        try {
             $query = new \RouterOS\Query('/ip/hotspot/active/print');
             return $this->client->query($query)->read();
            return [];
        } catch (\Exception $e) {
            Log::error("Gagal mengambil active users: " . $e->getMessage());
            return [];
        }
    }
}