<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ArtikelModel;

class Post extends ResourceController
{
    use ResponseTrait;

    // ✅ Method ini WAJIB ada
    protected function setCorsHeaders()
    {
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    }

    // GET /post
    public function index()
    {
        $this->setCorsHeaders();
        $model           = new ArtikelModel();
        $data['artikel'] = $model->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }

    // POST /post
    public function create()
    {
        $this->setCorsHeaders();
        $model = new ArtikelModel();

        $data = [
            'judul'  => $this->request->getVar('judul'),
            'isi'    => $this->request->getVar('isi'),
            'slug'   => url_title($this->request->getVar('judul'), '-', true),
            'status' => $this->request->getVar('status') ?? 0,
        ];

        $model->insert($data);

        return $this->respondCreated([
            'status'   => 201,
            'error'    => null,
            'messages' => ['success' => 'Data artikel berhasil ditambahkan.']
        ]);
    }

    // GET /post/{id}
    public function show($id = null)
    {
        $this->setCorsHeaders();
        $model = new ArtikelModel();
        $data  = $model->find($id);

        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }

    // PUT /post/{id}
    public function update($id = null)
    {
        $this->setCorsHeaders();
        $model    = new ArtikelModel();
        $existing = $model->find($id);

        if (!$existing) {
            return $this->failNotFound('Data tidak ditemukan.');
        }

        // Baca JSON body dari Axios
        $json = $this->request->getJSON(true);

        $judul  = $json['judul']  ?? $existing['judul'];
        $isi    = $json['isi']    ?? $existing['isi'];
        $status = $json['status'] ?? $existing['status'];

        $model->update($id, [
            'judul'  => $judul,
            'isi'    => $isi,
            'status' => (int)$status,
            'slug'   => url_title($judul, '-', true),
        ]);

        return $this->respond([
            'status'   => 200,
            'error'    => null,
            'messages' => ['success' => 'Data artikel berhasil diubah.']
        ]);
    }

    // DELETE /post/{id}
    public function delete($id = null)
    {
        $this->setCorsHeaders();
        $model    = new ArtikelModel();
        $existing = $model->find($id);

        if ($existing) {
            $model->delete($id);
            return $this->respondDeleted([
                'status'   => 200,
                'error'    => null,
                'messages' => ['success' => 'Data artikel berhasil dihapus.']
            ]);
        } else {
            return $this->failNotFound('Data tidak ditemukan.');
        }
    }
}