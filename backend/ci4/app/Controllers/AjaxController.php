<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
    public function index()
    {
        return view('ajax/index');
    }

    // GET DATA
    public function getData()
    {
        $model = new ArtikelModel();
        $data  = $model->getArtikelAjax();

        return $this->response->setJSON($data);
    }

    // DELETE DATA
    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);

        return $this->response->setJSON([
            'status' => 'OK'
        ]);
    }

    // TAMBAH DATA
    public function create()
    {
        $model = new ArtikelModel();

        $judul = $this->request->getPost('judul');

        // ambil file
        $file = $this->request->getFile('gambar');

        $namaGambar = null;

        // validasi file
        if ($file && $file->isValid() && !$file->hasMoved()) {

            // generate nama random
            $namaGambar = $file->getRandomName();

            // pindahkan ke folder public/gambar
            $file->move(ROOTPATH . 'public/gambar', $namaGambar);
        } else {
            return $this->response->setStatusCode(400)
                ->setJSON(['error' => 'Upload gambar gagal']);
        }

        // insert ke database
        $model->insert([
            'judul'       => $judul,
            'isi'         => $this->request->getPost('isi'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'slug'        => url_title($judul, '-', true),
            'status'      => 'draft',
            'gambar'      => $namaGambar
        ]);

        return $this->response->setJSON([
            'status' => 'OK'
        ]);
    }

    // UPDATE DATAr
    public function update($id)
    {
        $model = new ArtikelModel();

        $artikel = $model->find($id);

        if (!$artikel) {
            return $this->response->setStatusCode(404)
                ->setJSON(['error' => 'Data tidak ditemukan']);
        }

        $judul = $this->request->getPost('judul');

        $file = $this->request->getFile('gambar');

        // default pakai gambar lama
        $namaGambar = $artikel['gambar'];

        // kalau upload baru
        if ($file && $file->isValid() && !$file->hasMoved()) {

            $namaGambar = $file->getRandomName();
            $file->move(ROOTPATH . 'public/gambar', $namaGambar);

            // hapus gambar lama
            if (!empty($artikel['gambar']) &&
                file_exists(ROOTPATH . 'public/gambar/' . $artikel['gambar'])) {

                unlink(ROOTPATH . 'public/gambar/' . $artikel['gambar']);
            }
        }

        $model->update($id, [
            'judul'       => $judul,
            'isi'         => $this->request->getPost('isi'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'slug'        => url_title($judul, '-', true),
            'gambar'      => $namaGambar
        ]);

        return $this->response->setJSON(['status' => 'OK']);
    }
}