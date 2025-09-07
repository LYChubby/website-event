🎉 Website Event - Sistem Manajemen Event & RSVP
<p align="center"> <img src="https://img.shields.io/badge/Laravel-12.x-ff2d20?logo=laravel&logoColor=white" /> <img src="https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white" /> <img src="https://img.shields.io/badge/Blade-TailwindCSS-38bdf8?logo=tailwindcss&logoColor=white" /> <img src="https://img.shields.io/badge/License-MIT-green" /> <img src="https://img.shields.io/github/issues/LYChubby/website-event" /> <img src="https://img.shields.io/github/forks/LYChubby/website-event" /> <img src="https://img.shields.io/github/stars/LYChubby/website-event" /> </p><p align="center"> <strong>Sistem manajemen Event & RSVP berbasis Laravel yang elegan dan powerful</strong> </p><p align="center"> <img src="https://readme-typing-svg.demolab.com?font=Fira+Code&weight=600&size=22&duration=4000&pause=1000&color=38BDF8&center=true&vCenter=true&width=500&lines=Mendukung+pendaftaran+event;Pembelian+tiket+online;Notifikasi+otomatis;Dashboard+Admin+%26+Organizer" alt="Features" /> </p>
✨ Fitur Utama
<div align="center">
🎯 Kategori	📋 Fitur
🔐 Autentikasi	Laravel Breeze dengan multi-level authentication
🎟️ Manajemen	Buat, edit, kelola event & tiket secara real-time
👥 Partisipan	Sistem RSVP & manajemen peserta terintegrasi
📢 Notifikasi	Email reminder & notifikasi event otomatis
📊 Dashboard	Analytics untuk Admin & Organizer
🎨 Tampilan	Modern UI dengan Tailwind CSS & responsive design
</div>
🏗️ Struktur Project
bash
website-event/
├── 📂 app/                 # Logic utama Laravel
│   ├── 📂 Models/         # Eloquent models
│   ├── 📂 Controllers/    # Application controllers
│   └── 📂 Middleware/     # Custom middleware
├── 📂 database/           # Migrations, seeders, factories
├── 📂 public/            # Assets publik (CSS, JS, images)
├── 📂 resources/         # Views dengan Blade + Tailwind
├── 📂 routes/            # Web & API routes
├── 📂 storage/           # Cache, logs, file uploads
├── 📂 tests/             # Unit & feature tests
├── 📜 .env.example       # Environment template
├── 📜 artisan            # Laravel CLI
├── 📜 composer.json      # PHP dependencies
└── 📜 package.json       # Frontend dependencies
🚀 Quick Start
Prerequisites
PHP 8.0+

Composer

Node.js & npm

MySQL/SQLite

Installation
bash
# 1. Clone repository
git clone https://github.com/LYChubby/website-event
cd website-event

# 2. Setup environment
cp .env.example .env

# 3. Install dependencies
composer install
npm install

# 4. Generate application key
php artisan key:generate

# 5. Setup database (edit .env file terlebih dahulu)
php artisan migrate --seed

# 6. Build assets
npm run build

# 7. Optimize application
php artisan optimize

# 8. Jalankan server development
php artisan serve
Buka http://localhost:8000 di browser Anda.

📸 Preview
<div align="center">
Dashboard Admin	Halaman Event
Coming Soon	Coming Soon
Mobile View	Dark Mode
Coming Soon	Coming Soon
</div>
🤝 Berkontribusi
Kami menyambut kontribusi! Silakan lihat pedoman kontribusi untuk detailnya.

Fork project ini

Buat feature branch (git checkout -b feature/AmazingFeature)

Commit perubahan (git commit -m 'Add some AmazingFeature')

Push ke branch (git push origin feature/AmazingFeature)

Buka Pull Request

📄 Lisensi
Project ini dilisensikan di bawah MIT License - lihat file LICENSE untuk detailnya.

👨‍💻 Developer
<div align="center">
Dikembangkan dengan ❤️ oleh LYChubby

https://img.shields.io/badge/GitHub-LYChubby-181717?style=for-the-badge&logo=github
https://img.shields.io/badge/LinkedIn-Profile-0A66C2?style=for-the-badge&logo=linkedin

</div>
<p align="center"> ⭐ Jangan lupa beri bintang jika project ini bermanfaat! </p>
