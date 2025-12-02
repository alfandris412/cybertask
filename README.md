# CyberTask - Project & Task Management System

## ERD 
<img width="5664" height="2547" alt="erdcybertask" src="https://github.com/user-attachments/assets/e6ea30b8-10b2-4e30-ad30-82f18021d696" />

## UML 
<img width="1400" height="1000" alt="uml" src="https://github.com/user-attachments/assets/4105bfd1-6296-4dc5-b901-fa2bf27ae1bc" />


## Deskripsi

CyberTask adalah sistem manajemen proyek dan tugas yang dikembangkan dengan Laravel 12 dan Tailwind CSS. Sistem ini dirancang untuk mengelola proyek, menugaskan tugas kepada karyawan, dan memantau progres dengan fitur dashboard yang komprehensif.

## Fitur Utama

### Fitur Admin
- Dashboard Komprehensif - Statistik lengkap (total project, staff, tasks, completed, pending, overdue)
- Manajemen Project - Create, read, update, delete projects
- Manajemen Tasks - Create, read, update, delete tasks
- Alert System - Notifikasi overdue projects dan due soon tasks
- Assign Tasks - Menugaskan tasks kepada multiple karyawan
- Progress Tracking - Monitoring progress semua projects

### Fitur Karyawan
- Personal Dashboard - Statistik personal (my projects, my tasks, completed, overdue)
- Task Management - View dan update status tasks yang ditugaskan
- Progress Reporting - Update progress dan tambahkan komentar
- Alert Notifications - Notifikasi overdue dan due soon tasks
- Project View - Melihat detail project yang diikuti

### Alert System
- Overdue Tasks Alert - Notifikasi tasks yang terlewat deadline
- Due Soon Tasks Alert - Peringatan tasks yang deadline dalam 3 hari
- Overdue Projects Alert - Projects dengan tasks yang overdue
- Real-time Updates - Alert langsung di dashboard

### Dashboard Statistics
- Admin Dashboard: Total projects, total staff, total tasks, completed tasks, pending tasks, overdue tasks, due soon tasks
- Karyawan Dashboard: My projects, my tasks, completed tasks, overdue tasks, due soon tasks
- Visual Cards - Tampilan statistik dengan icons dan colors
- Interactive Links - Direct navigation dari alert ke detail

### UI/UX Features
- Modern Design - Dark theme dengan Tailwind CSS
- Responsive Layout - Mobile-friendly design
- Interactive Elements - Hover effects, transitions, animations
- Role-based Access - UI berbeda untuk admin dan karyawan
- Pagination - Untuk data yang besar
- Search & Filter - Kemudahan mencari data

## Teknologi

- Backend: Laravel 12 (PHP 8.2+)
- Frontend: Tailwind CSS 3.x
- Database: MySQL 8.0
- Authentication: Laravel Breeze
- Validation: Laravel Form Request
- File Upload: Laravel Storage

## Requirement Sistem

- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & NPM (untuk build assets)
- Web server (Apache/Nginx)

## Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd cybertask
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
```bash
# Edit .env file untuk database credentials
DB_DATABASE=cybertask
DB_USERNAME=root
DB_PASSWORD=

# Run migration
php artisan migrate
```

### 5. Seed Data (Optional)
```bash
php artisan db:seed
```

### 6. Build Assets
```bash
npm run build
```

### 7. Start Server
```bash
php artisan serve
```

## Default Akun

### Admin:
- Email: admin@cybertask.com
- Password: password

### Karyawan:
- Email: karyawan@cybertask.com
- Password: password

## Struktur Folder

```
cybertask/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── karyawan/
│   │   ├── layouts/
│   │   └── projects/
│   └── css/
├── routes/
├── storage/
└── public/
```

## Cara Penggunaan

### Untuk Admin:
1. Login sebagai admin
2. Buat project baru dari dashboard
3. Tambahkan tasks ke dalam project
4. Assign tasks kepada karyawan
5. Monitor progress di dashboard
6. Review overdue dan due soon alerts
7. Update status tasks jika needed

### Untuk Karyawan:
1. Login sebagai karyawan
2. Lihat dashboard untuk statistik personal
3. Klik "Proyek Saya" untuk melihat project yang diikuti
4. Update status tasks yang ditugaskan
5. Tambahkan progress report dan komentar
6. Perhatikan alert untuk overdue dan due soon tasks

## Alur Kerja

### 1. Project Creation
Admin → Create Project → Add Tasks → Assign to Karyawan

### 2. Task Execution
Karyawan → View Tasks → Update Status → Add Progress → Mark Complete

### 3. Monitoring
Admin → Dashboard → Review Statistics → Handle Alerts → Generate Reports

## Fitur yang Telah Diimplementasikan

### Core Features:
- [x] User authentication (Admin/Karyawan roles)
- [x] Project CRUD operations
- [x] Task CRUD operations
- [x] Task assignment to multiple users
- [x] Progress tracking dengan komentar
- [x] Dashboard dengan statistik lengkap
- [x] Alert system untuk overdue dan due soon

### UI/UX Enhancements:
- [x] Modern dark theme design
- [x] Responsive layout untuk mobile
- [x] Pagination untuk data yang besar
- [x] Search dan filter functionality
- [x] Hover effects dan smooth transitions
- [x] Role-based navigation

### Advanced Features:
- [x] Real-time statistics calculation
- [x] Due date tracking dengan Carbon
- [x] File upload untuk attachments
- [x] Activity logging
- [x] Data validation dan error handling

## Database Schema

Lihat file `ERD.md` untuk diagram Entity Relationship dan detail relasi database.

## Konfigurasi

### Environment Variables:
```env
APP_NAME=CyberTask
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cybertask
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

## Troubleshooting

### Common Issues:

1. Database Connection Error
   - Pastikan MySQL server running
   - Check .env database credentials
   - Run `php artisan migrate:fresh --seed`

2. Asset Not Loading
   - Run `npm run build`
   - Clear cache: `php artisan cache:clear`

3. Permission Issues
   - Set storage permissions: `chmod -R 775 storage/`
   - Clear config cache: `php artisan config:clear`

## Catatan Pengembang

### Code Standards:
- Mengikuti PSR-12 coding standards
- Menggunakan Laravel best practices
- Comment pada kode yang kompleks
- Consistent naming conventions

### Security Features:
- CSRF protection pada semua forms
- Input sanitization dan validation
- SQL injection prevention dengan Eloquent
- XSS protection dengan Blade templating
- Role-based access control

## Kontribusi

1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## Lisensi

Project ini dilisensi under MIT License - lihat file `LICENSE` untuk detail.

## Kontak

- Developer: [Your Name]
- Email: [your.email@example.com]
- Project: CyberTask Management System

---

## Roadmap

### Version 2.0 (Planned):
- [ ] Email notifications system
- [ ] Advanced reporting dengan charts
- [ ] File attachments untuk tasks
- [ ] API endpoints untuk mobile app
- [ ] Real-time updates dengan WebSocket
- [ ] Advanced user permissions
- [ ] Project templates
- [ ] Time tracking feature
- [ ] Calendar integration
- [ ] Mobile app (React Native)

### Version 1.1 (Bug Fixes):
- [ ] Performance optimization
- [ ] Additional validation rules
- [ ] UI/UX improvements
- [ ] Better error handling
- [ ] Enhanced search functionality

---

 2024 CyberTask Management System. All rights reserved.
