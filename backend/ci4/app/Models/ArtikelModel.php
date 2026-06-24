<?php
namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table          = 'artikel';
    protected $primaryKey     = 'id';
    protected $useAutoIncrement = true;

    // ✅ Matikan timestamps otomatis karena tabel pakai created_at manual
    protected $useTimestamps  = false;

    protected $allowedFields  = [
        'judul', 'isi', 'slug', 'id_kategori', 'status', 'gambar'
    ];

    public function getArtikelDenganKategori()
    {
        return $this->db->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->get()
            ->getResultArray();
    }
}