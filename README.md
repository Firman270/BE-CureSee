---

# Curesee Backend – REST API Kesehatan Digital

Curesee Backend adalah layanan **RESTful API** berbasis **Laravel** yang berfungsi sebagai tulang punggung sistem Curesee. Backend ini menangani autentikasi, pengelolaan data pengguna, riwayat kesehatan, serta komunikasi antara aplikasi mobile Flutter, sistem machine learning, dan layanan eksternal lainnya.

Backend dikembangkan dengan fokus pada **keamanan, skalabilitas, dan keterpisahan logika bisnis**, sehingga mudah dikembangkan dan dipelihara dalam jangka panjang.

---

## 🌐 Gambaran Umum

Aplikasi Curesee membutuhkan sistem backend yang andal untuk mengelola data kesehatan pengguna secara terstruktur dan aman. Backend ini menyediakan API yang digunakan oleh aplikasi mobile untuk:

* Autentikasi dan otorisasi pengguna
* Penyimpanan dan pengambilan data kesehatan
* Pengelolaan riwayat deteksi penyakit kulit
* Manajemen peran pengguna (user & admin)
* Integrasi dengan Firebase dan sistem machine learning

Semua komunikasi data dilakukan menggunakan format **JSON** melalui protokol **HTTP/HTTPS**.

---

## 🎯 Permasalahan yang Diselesaikan

Backend Curesee dikembangkan untuk menjawab beberapa tantangan berikut:

* Pengelolaan data kesehatan yang aman dan terstruktur
* Kebutuhan API yang konsisten untuk aplikasi mobile
* Pemisahan logika bisnis agar sistem mudah dikembangkan
* Skalabilitas sistem untuk pengembangan fitur lanjutan
* Integrasi lintas sistem (Flutter, Firebase, Machine Learning)

---

## 💡 Fitur Utama Backend

Backend Curesee menyediakan berbagai fitur inti, antara lain:

* RESTful API berbasis Laravel
* Autentikasi pengguna menggunakan Firebase UID
* Manajemen data pengguna dan profil kesehatan
* Penyimpanan dan pengelolaan riwayat deteksi penyakit kulit
* Manajemen data admin dan pengguna
* Validasi dan sanitasi data input
* Struktur kode berbasis Service & Repository Pattern
* Dukungan pengembangan API lanjutan dan integrasi eksternal

---

## 🧑‍💼 Peran Pengguna

Backend Curesee mendukung pemisahan peran pengguna:

* **User**

  * Mengakses profil kesehatan
  * Melihat riwayat deteksi penyakit kulit
  * Mengirim data hasil analisis gambar

* **Admin**

  * Mengelola data pengguna
  * Monitoring data dan sistem
  * Validasi dan pengelolaan konten

---

## 🏗️ Arsitektur Backend

Backend Curesee dirancang dengan pendekatan **Clean Architecture & Layered Architecture** untuk menjaga keterpisahan tanggung jawab.

Lapisan utama:

* **Controller / Handler**
  Menangani request & response HTTP

* **Service Layer**
  Berisi logika bisnis utama aplikasi

* **Repository Layer**
  Abstraksi akses database

* **Model (Eloquent ORM)**
  Representasi tabel database

Pendekatan ini membuat backend:

* Mudah diuji
* Mudah dikembangkan
* Minim coupling antar modul

---

## 🔗 API dan Integrasi

* RESTful API berbasis Laravel
* Format data: JSON
* Autentikasi: Firebase Authentication
* Database: MySQL
* Integrasi dengan aplikasi Flutter sebagai client utama
* Dukungan integrasi machine learning (hasil prediksi disimpan sebagai data)

---

## 🚀 Instalasi dan Konfigurasi

### Prasyarat

* PHP ≥ 8.x
* Composer
* MySQL / MariaDB
* Laravel
* Firebase Project (untuk Authentication)

---

### Langkah Instalasi

```bash
git clone https://github.com/sony12subagyo/curesee-backend.git
cd curesee-backend
composer install
cp .env.example .env
php artisan key:generate
```

---

### Konfigurasi Database

Atur koneksi database pada file `.env`:

```env
DB_DATABASE=curesee
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan migration:

```bash
php artisan migrate
```

---

## ▶️ Menjalankan Server Backend

```bash
php artisan serve
```

Secara default backend akan berjalan di:

```
http://127.0.0.1:8000
```

---

## 🛠️ Teknologi yang Digunakan

* **Backend Framework**: Laravel
* **Bahasa Pemrograman**: PHP
* **Database**: MySQL
* **ORM**: Eloquent
* **Autentikasi**: Firebase Authentication
* **API Style**: RESTful API
* **Version Control**: Git & GitHub

---

## 📂 Struktur Utama Folder

```text
app/
 ├── Http/
 │   ├── Controllers/    # Controller API
 │   └── Requests/       # Validasi request
 ├── Services/           # Logika bisnis
 ├── Repositories/       # Akses data
 └── Models/             # Model Eloquent
routes/
 └── api.php             # Endpoint API
database/
 ├── migrations/         # Struktur database
 └── seeders/            # Data awal
```

---

## 🔐 Keamanan

* Validasi input di setiap endpoint
* Penggunaan Firebase UID untuk autentikasi
* Pemisahan hak akses user dan admin
* Proteksi endpoint sensitif

---

## 📄 Lisensi

Backend Curesee merupakan perangkat lunak open-source yang dikembangkan untuk keperluan akademik dan penelitian.

---
