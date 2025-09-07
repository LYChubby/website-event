# 🎉 Website Event  

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-ff2d20?logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/Blade-TailwindCSS-38bdf8?logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/License-MIT-green" />
</p>

Sistem manajemen **Event & RSVP** berbasis **Laravel**.  
Mendukung fitur pendaftaran event, pembelian tiket, notifikasi, serta dashboard **admin** & **organizer**.

---

## 🚀 Fitur Utama
- 🔐 Autentikasi dengan **Laravel Breeze**
- 🎟️ Manajemen Event & Tiket
- 👥 RSVP & Partisipan Event
- 📢 Notifikasi & Reminder Email
- 📊 Dashboard **Admin & Organizer**
- 🎨 Tampilan modern dengan **Tailwind CSS**

---

## 📂 Struktur Project
```bash
website-event
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
```

# Clone repo
git clone https://github.com/LYChubby/website-event
cd website-event

# Setup environment
cp .env.example .env

# Install dependencies
composer install
npm install

# Generate key & migrate database
php artisan key:generate
php artisan migrate --seed

# Optimize & build frontend
php artisan optimize
npm run build

# Jalankan server
php artisan serve
