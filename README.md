

# 📘 Praktikum 4 – Framework Lanjutan (Modul Login)

**Nama:** M. Rizqy Al
**NIM:** 312410424
**Kelas:** I241C
**Mata Kuliah:** Pemrograman Web 2
**Dosen:** Agung Nugroho


## 🎯 Tujuan Praktikum

1. Memahami konsep Authentication (Auth)
2. Memahami penggunaan Filter pada CodeIgniter 4
3. Membuat sistem login sederhana
4. Mengamankan halaman admin

---

## 🗄️ Membuat Database

Membuat tabel `user` untuk menyimpan data login:

```sql
CREATE TABLE user (
  id INT(11) auto_increment,
  username VARCHAR(200) NOT NULL,
  useremail VARCHAR(200),
  userpassword VARCHAR(200),
  PRIMARY KEY(id)
);
```

📷 Screenshot:
![img](database.png/)

---

## 🧩 Membuat Model

File:

```
app/Models/UserModel.php
```

Model digunakan untuk mengelola data user dari database.

📷 Screenshot:
![img](model.png/)

---

## 🎮 Membuat Controller

File:

```
app/Controllers/User.php
```

Controller berfungsi untuk:

* Menampilkan data user
* Proses login
* Menyimpan session
* Logout user

📷 Screenshot:
![img](controller.png/)

---

## 🖼️ Membuat View Login

File:

```
app/Views/user/login.php
```

Menggunakan Bootstrap untuk tampilan login agar lebih menarik.

📷 Screenshot:
![img](login.png/)

---

## 🌱 Membuat Seeder

Digunakan untuk menambahkan data user otomatis.

Perintah:

```
php spark make:seeder UserSeeder
php spark db:seed UserSeeder
```

Data default:

* Email: [admin@email.com](mailto:admin@email.com)
* Password: admin123

📷 Screenshot:
![img](seeder.png/)

---

## 🔐 Membuat Filter Auth

File:

```
app/Filters/Auth.php
```

Fungsi:

* Mengecek user sudah login atau belum
* Jika belum login → redirect ke halaman login

📷 Screenshot:
![img](filter.png/)

---

## 🔀 Konfigurasi Routes

Menambahkan proteksi halaman admin:

```php
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('artikel', 'Artikel::admin_index');
});
```

📷 Screenshot:
![img](routes-login.png/)

---

## 🚪 Fitur Logout

Menambahkan method logout pada controller:

```php
public function logout()
{
    session()->destroy();
    return redirect()->to('/user/login');
}
```

📷 Screenshot:
![img](logout.png/)

---

## 📌 Hasil Praktikum

Fitur yang berhasil dibuat:

* Login user
* Session login
* Proteksi halaman admin
* Logout

---

## ✅ Kesimpulan

Pada praktikum ini telah dipelajari:

* Implementasi sistem login menggunakan CodeIgniter 4
* Penggunaan session untuk autentikasi
* Penggunaan filter untuk keamanan halaman
* Pembuatan logout

Sistem login berhasil berjalan dengan baik dan dapat digunakan untuk mengamankan halaman admin.

---

