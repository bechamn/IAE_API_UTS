# 📦 IAE_API_UTS

Repository ini berisi implementasi API untuk layanan pengguna (consumer) dan admin (provider) dalam sistem pemesanan barang berbasis Laravel.

## 📌 Struktur Layanan

- **User Service (Consumer)**: Bertanggung jawab atas registrasi, login, pemesanan, dan logout user.
- **Admin Service (Provider)**: Mengelola data item, memverifikasi pesanan, dan mengatur user.

---

## 🔐 Autentikasi

Beberapa endpoint menggunakan middleware `auth:sanctum`, artinya token login harus dikirim pada header `Authorization: Bearer {token}`.

---

## 📲 User Service (Consumer)

### 🔓 Public Endpoint

| Method | Endpoint           | Deskripsi                       |
|--------|--------------------|----------------------------------|
| GET    | `/token`           | Mendapatkan CSRF token.          |
| POST   | `/register`        | Registrasi user baru.            |
| POST   | `/login`           | Login user, mengembalikan token. |
| GET    | `/items`           | Melihat semua item.              |
| GET    | `/orders`          | Melihat semua pesanan user.      |
| PUT    | `/orders/{id}/confirm` | Konfirmasi pesanan (tanpa auth). |

### 🔒 Protected Endpoint (Butuh Token)

| Method | Endpoint           | Deskripsi                       |
|--------|--------------------|----------------------------------|
| POST   | `/order`           | Membuat pesanan baru.            |
| POST   | `/logout`          | Logout user, hapus token.        |

---

## 🛠️ Admin Service (Provider)

### 📦 Item Management

| Method | Endpoint             | Deskripsi                         |
|--------|----------------------|------------------------------------|
| POST   | `/items`             | Menambahkan item baru.             |
| PUT    | `/items/{id}`        | Mengupdate item berdasarkan ID.    |
| DELETE | `/items/{id}`        | Menghapus item berdasarkan ID.     |
| GET    | `/items`             | Menampilkan semua item.            |

### 📦 Order Management

| Method | Endpoint                   | Deskripsi                             |
|--------|----------------------------|----------------------------------------|
| GET    | `/orders`                  | Melihat semua pesanan.                 |
| POST   | `/orders/{id}/confirm`     | Mengonfirmasi pesanan berdasarkan ID.  |

### 👤 User Management

| Method | Endpoint         | Deskripsi                      |
|--------|------------------|-------------------------------|
| GET    | `/users`         | Melihat seluruh user.          |
| GET    | `/users/{user}`  | Melihat detail user berdasarkan ID. |
| POST   | `/logout`        | Logout admin.                 |

---

## 📎 Catatan

- Endpoint pada User Service `/orders/{id}/confirm` **tidak diamankan dengan auth** – sebaiknya diamankan.
- Pastikan Anda mengirimkan token saat mengakses endpoint dengan middleware `auth:sanctum`.
- Perbedaan peran user/admin dapat dikontrol dari sistem autentikasi dan role management di database.

---

## 📂 Struktur Folder Terkait

- `app/Http/Controllers/UserController.php` – Mengatur autentikasi dan data user.
- `app/Http/Controllers/ItemController.php` – CRUD item.
- `app/Http/Controllers
