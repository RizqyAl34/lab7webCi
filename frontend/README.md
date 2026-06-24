# Praktikum 11 - Frontend VueJS

**Nama:** [Nama Mahasiswa]  
**NIM:** [NIM]  
**Mata Kuliah:** Pemrograman Web 2  
**Universitas Pelita Bangsa**

---

## Tujuan

1. Memahami konsep dasar API
2. Memahami konsep dasar Framework VueJS
3. Membuat Frontend API menggunakan Framework VueJS 3

---

## Apa itu VueJS?

VueJS adalah framework JavaScript untuk membangun tampilan antarmuka website yang interaktif. Framework ini berfokus pada **view layer** dan mudah diintegrasikan dengan library lain. Fitur utamanya meliputi:

- **Reactive Data Binding** — perubahan data otomatis tercermin di tampilan
- **Component-Based Architecture** — membangun UI dari komponen-komponen kecil yang reusable
- **Directives** — atribut khusus seperti `v-for`, `v-if`, `v-model` untuk manipulasi DOM

---

## Struktur Direktori

```
lab11_vuejs/
│   index.html
└───assets
    ├───css
    │     style.css
    └───js
          app.js
```

---

## Langkah-Langkah Praktikum

### Persiapan — Library via CDN

Library VueJS dan Axios diambil melalui CDN tanpa perlu instalasi npm:

```html
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
```

> **Axios** digunakan untuk melakukan HTTP request ke REST API yang sudah dibuat pada Praktikum 10 (CodeIgniter 4).

---

### Langkah 1 — Menampilkan Data (GET)

Pada `app.js`, method `loadData()` dipanggil saat komponen di-mount untuk mengambil data dari endpoint `/post`:

```javascript
loadData() {
  axios.get(apiUrl + '/post')
    .then(response => {
      this.artikel = response.data.artikel
    })
    .catch(error => console.log(error))
},
```

Pada `index.html`, data ditampilkan menggunakan directive `v-for`:

```html
<tr v-for="(row, index) in artikel" :key="row.id">
  <td>{{ row.id }}</td>
  <td>{{ row.judul }}</td>
  <td>{{ statusText(row.status) }}</td>
</tr>
```

**Screenshot hasil:**

> *(Tambahkan screenshot tampilan tabel daftar artikel di sini)*

---

### Langkah 2 — Form Tambah dan Ubah Data (POST & PUT)

Modal form ditampilkan secara kondisional menggunakan `v-if="showForm"`:

```html
<div class="modal" v-if="showForm">
  <div class="modal-content">
    <form @submit.prevent="saveData">
      <input type="text" v-model="formData.judul" placeholder="Judul" required>
      <textarea v-model="formData.isi"></textarea>
      <select v-model="formData.status">
        <option v-for="option in statusOptions" :value="option.value">
          {{ option.text }}
        </option>
      </select>
      <button type="submit">Simpan</button>
    </form>
  </div>
</div>
```

Method `saveData()` menentukan apakah request POST (tambah) atau PUT (update) berdasarkan ada tidaknya `formData.id`:

```javascript
saveData() {
  if (this.formData.id) {
    // UPDATE data yang sudah ada
    axios.put(apiUrl + '/post/' + this.formData.id, this.formData)
      .then(() => this.loadData())
  } else {
    // TAMBAH data baru
    axios.post(apiUrl + '/post', this.formData)
      .then(() => this.loadData())
  }
  this.showForm = false
},
```

**Screenshot form tambah data:**

> *(Tambahkan screenshot modal form tambah data di sini)*

**Screenshot form ubah data:**

> *(Tambahkan screenshot modal form ubah data di sini)*

---

### Langkah 3 — Hapus Data (DELETE)

Method `hapus()` mengirim request DELETE ke endpoint `/post/{id}`:

```javascript
hapus(index, id) {
  if (confirm('Yakin menghapus data?')) {
    axios.delete(apiUrl + '/post/' + id)
      .then(() => {
        this.artikel.splice(index, 1)
      })
  }
},
```

**Screenshot konfirmasi hapus:**

> *(Tambahkan screenshot dialog konfirmasi hapus di sini)*

---

## Improvisasi / Pengembangan

Beberapa fitur tambahan yang diimplementasikan di luar modul:

| Fitur | Keterangan |
|-------|-----------|
| **Badge Status** | Status Publish/Draft ditampilkan dengan warna berbeda (hijau/kuning) |
| **Notifikasi** | Toast notification muncul di pojok kanan bawah setelah aksi berhasil/gagal |
| **Loading State** | Teks "Memuat data..." ditampilkan saat data sedang diambil dari API |
| **Empty State** | Pesan khusus jika belum ada data artikel |
| **Hover Effect** | Baris tabel berubah warna saat di-hover |
| **Error Handling** | Pesan error ditampilkan jika koneksi ke API gagal |

---

## Cara Menjalankan

1. Pastikan server XAMPP aktif (Apache + MySQL)
2. Pastikan project CI4 dari Praktikum 10 berjalan di `http://localhost/labci4/public`
3. Tempatkan folder `lab11_vuejs` di dalam `htdocs`
4. Buka browser dan akses `http://localhost/lab11_vuejs`

---

## Referensi

- [Dokumentasi VueJS 3](https://vuejs.org/guide/introduction)
- [Dokumentasi Axios](https://axios-http.com/docs/intro)
- Modul Praktikum Pemrograman Web 2 — Universitas Pelita Bangsa
