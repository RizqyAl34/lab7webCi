<?php
namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class Artikel extends BaseController
{
    public function index()
    {
        $title   = 'Daftar Artikel';
        $model   = new ArtikelModel();
        $artikel = $model->getArtikelDenganKategori();
        return view('artikel/index', compact('artikel', 'title'));
    }

    public function admin_index()
    {
        $title       = 'Daftar Artikel (Admin)';
        $q           = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $page        = (int)($this->request->getVar('page') ?? 1);

        $db      = \Config\Database::connect();
        $builder = $db->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }

        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $total   = $builder->countAllResults(false);
        $perPage = 10;
        $offset  = ($page - 1) * $perPage;
        $artikel = $builder->limit($perPage, $offset)->get()->getResultArray();

        $totalPage = $total > 0 ? ceil($total / $perPage) : 1;
        $links     = [];
        for ($i = 1; $i <= $totalPage; $i++) {
            $links[] = [
                'url'    => base_url("admin/artikel?page={$i}&q={$q}&kategori_id={$kategori_id}"),
                'title'  => (string)$i,
                'active' => ($i === $page),
            ];
        }

        $data = [
            'title'       => $title,
            'q'           => $q,
            'kategori_id' => $kategori_id,
            'artikel'     => $artikel,
            'pager'       => ['links' => $links],
        ];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }

        $data['kategori'] = (new KategoriModel())->findAll();
        return view('artikel/admin_index', $data);
    }

    public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul'       => 'required',
            'id_kategori' => 'required',
            'gambar'      => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,2048]',
        ]);

        if ($validation->withRequest($this->request)->run()) {
            $file     = $this->request->getFile('gambar');
            $namaFile = $file->getRandomName();
            $file->move(ROOTPATH . 'public/gambar', $namaFile);

            (new ArtikelModel())->insert([
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'slug'        => url_title($this->request->getPost('judul')),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'status'      => 1,
                'gambar'      => $namaFile,
            ]);

            return redirect()->to(base_url('admin/artikel'));
        }

        return view('artikel/form_add', [
            'kategori'   => (new KategoriModel())->findAll(),
            'title'      => 'Tambah Artikel',
            'validation' => $validation,
        ]);
    }

    public function edit($id)
    {
        $model = new ArtikelModel();

        if ($this->request->getMethod(true) === 'POST') {
            $model->update($id, [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
            ]);
            return redirect()->to('/admin/artikel');
        }

        return view('artikel/form_edit', [
            'artikel'  => $model->find($id),
            'kategori' => (new KategoriModel())->findAll(),
            'title'    => 'Edit Artikel',
        ]);
    }

    public function delete($id)
    {
        (new ArtikelModel())->delete($id);
        return redirect()->to('/admin/artikel');
    }

    public function view($slug)
    {
        $model           = new ArtikelModel();
        $data['artikel'] = $model
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->where('slug', $slug)
            ->first();

        if (!$data['artikel']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }

    public function kategori($id)
    {
        $model         = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        $artikel  = $model
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->where('artikel.id_kategori', $id)
            ->findAll();

        $kategori = $kategoriModel->find($id);

        return view('artikel/index', [
            'title'   => 'Artikel Kategori: ' . ($kategori['nama_kategori'] ?? ''),
            'artikel' => $artikel,
        ]);
    }
}