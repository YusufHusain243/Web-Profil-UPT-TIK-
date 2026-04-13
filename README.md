# 🚀 UPR TIK Redesign

[![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Vue 3](https://img.shields.io/badge/Vue.js-3.x-4FC08D?style=for-the-badge&logo=vuedotjs)](https://vuejs.org)
[![Tailwind CSS 4](https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![PHP 8.4](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php)](https://php.net)

Redesign website UPA TIK Universitas Palangka Raya dengan estetika premium, performa tinggi, dan arsitektur modern berbasis **Laravel 13**, **Inertia.js**, dan **Vue.js 3**.

---

## ✨ Features

- **Modern Bento UI**: Layout modern dengan desain grid yang responsif.
- **Inertia.js Integration**: Pengalaman Single Page Application (SPA) dengan kenyamanan routing sisi server.
- **Tailwind CSS v4**: Menggunakan engine CSS terbaru untuk performa styling maksimal.
- **AI Ready**: Terintegrasi dengan **Laravel Boost** untuk pengembangan yang optimal menggunakan AI coding agents.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 13 (Latest)
- **Frontend**: Vue.js 3 + Inertia.js
- **Styling**: Tailwind CSS v4 + Lucide Icons
- **Tooling**: Vite 8, PHP 8.4

---

## 🚀 Getting Started

Ikuti langkah-langkah di bawah ini untuk menjalankan project ini di environment lokal Anda.

### 📋 Prerequisites

Pastikan Anda sudah menginstall:
- **PHP 8.4+**
- **Composer**
- **Node.js & NPM**
- **MariaDB / MySQL**

### 📥 Installation & Setup

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/upr-tik-redesign.git
   cd upr-tik-redesign
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   *Edit `.env` dan sesuaikan konfigurasi database Anda.*

4. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

5. **Database Migration & Seeding**
   ```bash
   php artisan migrate --seed
   ```

6. **Build Frontend**
   ```bash
   npm run build
   # atau jalankan mode development
   npm run dev
   ```

---

## 🤖 AI Assistance (Optional)

Project ini didukung oleh **Laravel Boost**. Jika Anda menggunakan AI Coding Agents (seperti Cursor atau Claude Code), jalankan perintah berikut untuk mengoptimalkan workflow:

```bash
php artisan boost:install
```

---

## 📜 License

Project ini dilisensikan di bawah [MIT License](LICENSE).

---

<p align="center">Made with ❤️ for UPT TIK Universitas Palangka Raya</p>
