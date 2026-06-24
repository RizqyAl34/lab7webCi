<?php

namespace App\Cells;

use App\Models\ArtikelModel;

class ArtikelTerkini
{
    public function show()
    {
        $model = new ArtikelModel();

        $data = $model
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
            ->orderBy('kategori.nama_kategori', 'ASC')
            ->orderBy('artikel.id', 'DESC')
            ->findAll();

        $grouped = [];

        foreach ($data as $row) {
            $kategori = $row['nama_kategori'] ?? 'Tidak ada';
            $grouped[$kategori][] = $row;
        }

        return view('components/artikel_terkini', [
            'grouped' => $grouped
        ]);
    }
}