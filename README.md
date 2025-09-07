# 🎉 Website Event

![Laravel](https://img.shields.io/badge/Laravel-12.x-red?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.x-blue?logo=php&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-TailwindCSS-38bdf8?logo=tailwindcss&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

Sistem manajemen **Event & RSVP** berbasis web dengan framework **Laravel**.  
Mendukung fitur pendaftaran event, pembelian tiket, notifikasi, serta dashboard admin & organizer.

---

## ✨ Fitur Utama
- 🔐 Autentikasi dengan Laravel Breeze
- 🎟️ Manajemen Event & Tiket
- 👥 RSVP & Partisipan Event
- 📢 Notifikasi & Reminder Email
- 📊 Dashboard Admin & Organizer
- 🎨 Tampilan modern dengan **Tailwind CSS**

---

## 📂 Struktur Project
```bash
📦 website-event
 ┣ 📂 app          # Logic utama Laravel (Models, Controllers, Middleware)
 ┣ 📂 bootstrap    # Bootstrap Laravel
 ┣ 📂 config       # Konfigurasi aplikasi
 ┣ 📂 database     # Migrations, seeders, factories
 ┣ 📂 public       # Aset publik (CSS, JS, gambar)
 ┣ 📂 resources    # View Blade + Tailwind
 ┣ 📂 routes       # Web & API routes
 ┣ 📂 storage      # Cache, logs, uploads
 ┣ 📂 tests        # Unit & feature tests
 ┣ 📜 artisan
 ┣ 📜 composer.json
 ┣ 📜 package.json
 ┗ 📜 README.md

⚡ Instalasi
1️⃣ Clone Repository
git clone https://github.com/LYChubby/website-event
cd website-event

2️⃣ Setup Environment
cp .env.example .env

3️⃣ Install Dependencies
composer install
npm install

4️⃣ Optimisasi Laravel
php artisan optimize

5️⃣ Build Frontend
npm run build

▶️ Menjalankan Aplikasi
php artisan serve

