<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_kategori' => 'Teknologi', 'slug_kategori' => 'teknologi'],
            ['nama_kategori' => 'Pendidikan', 'slug_kategori' => 'pendidikan'],
            ['nama_kategori' => 'Lifestyle', 'slug_kategori' => 'lifestyle'],
            ['nama_kategori' => 'Bisnis', 'slug_kategori' => 'bisnis'],
            ['nama_kategori' => 'Olahraga', 'slug_kategori' => 'olahraga'],
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}