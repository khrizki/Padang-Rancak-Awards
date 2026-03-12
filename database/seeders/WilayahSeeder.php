<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\RW;
use App\Models\RT;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Kecamatan di Kota Padang
        $kecamatans = [
            ['nama' => 'Padang Timur', 'kode' => '101'],
            ['nama' => 'Padang Barat', 'kode' => '102'],
            ['nama' => 'Padang Selatan', 'kode' => '103'],
            ['nama' => 'Padang Utara', 'kode' => '104'],
            ['nama' => 'Lubuk Begalung', 'kode' => '105'],
            ['nama' => 'Lubuk Kilangan', 'kode' => '106'],
            ['nama' => 'Pauh', 'kode' => '107'],
            ['nama' => 'Koto Tangah', 'kode' => '108'],
            ['nama' => 'Nanggalo', 'kode' => '109'],
            ['nama' => 'Bungus Teluk Kabung', 'kode' => '110'],
            ['nama' => 'Kuranji', 'kode' => '111'],
        ];

        foreach ($kecamatans as $kecamatanData) {
            $kecamatan = Kecamatan::create([
                'nama' => $kecamatanData['nama'],
                'kode' => $kecamatanData['kode'],
                'kota' => 'Padang',
            ]);

            $this->seedKelurahans($kecamatan);
        }
    }

    private function seedKelurahans(Kecamatan $kecamatan)
    {
        $kelurahanData = $this->getKelurahanData($kecamatan->nama);

        foreach ($kelurahanData as $kelData) {
            $kelurahan = Kelurahan::create([
                'kecamatan_id' => $kecamatan->id,
                'nama' => $kelData['nama'],
                'kode' => $kelData['kode'],
            ]);

            // Create 2-3 RWs per kelurahan
            $numberOfRWs = rand(2, 3);
            for ($i = 1; $i <= $numberOfRWs; $i++) {
                $rw = RW::create([
                    'kelurahan_id' => $kelurahan->id,
                    'nama' => "RW {$i} {$kelurahan->nama}",
                    'nomor_rw' => $i,
                ]);

                // Create 2-4 RTs per RW
                $numberOfRTs = rand(2, 4);
                for ($j = 1; $j <= $numberOfRTs; $j++) {
                    RT::create([
                        'rw_id' => $rw->id,
                        'nama' => "RT {$j} {$rw->nama}",
                        'nomor_rt' => $j,
                        'status_terdaftar' => rand(0, 1) === 1 ? 'sudah' : 'belum', // Random status
                        'alamat' => "Jalan {$kelurahan->nama} No. {$j}{$i}",
                        'jumlah_warga' => rand(100, 500),
                        'no_hp_ketua_rt' => $this->generatePhoneNumber(),
                    ]);
                }
            }
        }
    }

    private function getKelurahanData($kecamatanName)
    {
        $data = [
            'Padang Timur' => [
                ['nama' => 'Sawahan', 'kode' => '10101'],
                ['nama' => 'Arai Pinang', 'kode' => '10102'],
                ['nama' => 'Ganting', 'kode' => '10103'],
                ['nama' => 'Parak Gadang', 'kode' => '10104'],
            ],
            'Padang Barat' => [
                ['nama' => 'Belakang Tangsi', 'kode' => '10201'],
                ['nama' => 'Berok Nipah', 'kode' => '10202'],
                ['nama' => 'Padang Pasir', 'kode' => '10203'],
            ],
            'Padang Selatan' => [
                ['nama' => 'Ranah Parak Rumbio', 'kode' => '10301'],
                ['nama' => 'Pasa Gadang', 'kode' => '10302'],
                ['nama' => 'Seberang Padang', 'kode' => '10303'],
            ],
            'Padang Utara' => [
                ['nama' => 'Alai Parak Kopi', 'kode' => '10401'],
                ['nama' => 'Campago', 'kode' => '10402'],
                ['nama' => 'Olo', 'kode' => '10403'],
            ],
            'Lubuk Begalung' => [
                ['nama' => 'Lubuk Begalung', 'kode' => '10501'],
                ['nama' => 'Gurun Laweh', 'kode' => '10502'],
                ['nama' => 'Padang Sarai', 'kode' => '10503'],
            ],
            'Lubuk Kilangan' => [
                ['nama' => 'Lubuk Kilangan', 'kode' => '10601'],
                ['nama' => 'Bandar Buat', 'kode' => '10602'],
            ],
            'Pauh' => [
                ['nama' => 'Pauh', 'kode' => '10701'],
                ['nama' => 'Lambung Bukit', 'kode' => '10702'],
                ['nama' => 'Bungo Pasang', 'kode' => '10703'],
            ],
            'Koto Tangah' => [
                ['nama' => 'Koto Tangah', 'kode' => '10801'],
                ['nama' => 'Balai Gadang', 'kode' => '10802'],
                ['nama' => 'Teluk Sirih', 'kode' => '10803'],
            ],
            'Nanggalo' => [
                ['nama' => 'Nanggalo', 'kode' => '10901'],
                ['nama' => 'Kampung Jao', 'kode' => '10902'],
                ['nama' => 'Surau Gadang', 'kode' => '10903'],
            ],
            'Bungus Teluk Kabung' => [
                ['nama' => 'Bungus Teluk Kabung', 'kode' => '11001'],
                ['nama' => 'Teluk Kabung Utara', 'kode' => '11002'],
                ['nama' => 'Teluk Kabung Selatan', 'kode' => '11003'],
            ],
            'Kuranji' => [
                ['nama' => 'Kuranji', 'kode' => '11101'],
                ['nama' => 'Paiambai', 'kode' => '11102'],
                ['nama' => 'Andaleh', 'kode' => '11103'],
            ],
        ];

        return $data[$kecamatanName] ?? [];
    }

    private function generatePhoneNumber()
    {
        $prefixes = ['0812', '0813', '0821', '0822', '0823', '0852', '0853', '0878'];
        $prefix = $prefixes[array_rand($prefixes)];
        $number = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);

        return $prefix . $number;
    }
}
