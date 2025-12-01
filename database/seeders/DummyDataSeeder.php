<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Admin Account
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@cybertask.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // 2. Create Staff Accounts
        $staffs = [
            ['name' => 'Andi Staff', 'email' => 'andi@cybertask.com'],
            ['name' => 'Budi Staff', 'email' => 'budi@cybertask.com'],
            ['name' => 'Cici Staff', 'email' => 'cici@cybertask.com'],
            ['name' => 'Dedi Staff', 'email' => 'dedi@cybertask.com'],
            ['name' => 'Eva Staff', 'email' => 'eva@cybertask.com'],
            ['name' => 'Fajar Staff', 'email' => 'fajar@cybertask.com'],
            ['name' => 'Gina Staff', 'email' => 'gina@cybertask.com'],
            ['name' => 'Hadi Staff', 'email' => 'hadi@cybertask.com'],
        ];

        $staffUsers = [];
        foreach ($staffs as $staff) {
            $user = User::create([
                'name' => $staff['name'],
                'email' => $staff['email'],
                'password' => bcrypt('password'),
                'role' => 'karyawan',
                'email_verified_at' => now(),
            ]);
            $staffUsers[] = $user;
        }

        // 3. Create Projects
        $projects = [
            [
                'name' => 'E-Commerce Website',
                'description' => 'Pengembangan website e-commerce modern dengan fitur shopping cart, payment gateway, dan admin panel. Menggunakan Laravel dan Vue.js untuk frontend.',
                'created_at' => Carbon::now()->subDays(30),
            ],
            [
                'name' => 'Mobile Banking App',
                'description' => 'Aplikasi mobile banking untuk Android dan iOS dengan fitur transfer, pembayaran, dan notifikasi real-time. Menggunakan React Native.',
                'created_at' => Carbon::now()->subDays(25),
            ],
            [
                'name' => 'HR Management System',
                'description' => 'Sistem manajemen HR untuk mengelola karyawan, payroll, dan attendance. Dilengkapi dengan dashboard analytics dan reporting.',
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'name' => 'Inventory Management',
                'description' => 'Sistem manajemen inventory dengan barcode scanner, real-time stock tracking, dan automatic reordering notifications.',
                'created_at' => Carbon::now()->subDays(15),
            ],
            [
                'name' => 'Learning Management System',
                'description' => 'Platform e-learning untuk corporate training dengan video streaming, quiz system, dan progress tracking.',
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'name' => 'CRM System',
                'description' => 'Customer Relationship Management system untuk mengelola leads, sales pipeline, dan customer communications.',
                'created_at' => Carbon::now()->subDays(8),
            ],
            [
                'name' => 'Booking System',
                'description' => 'Sistem reservasi online untuk hotel dan travel dengan calendar integration dan payment processing.',
                'created_at' => Carbon::now()->subDays(5),
            ],
            [
                'name' => 'Social Media Dashboard',
                'description' => 'Dashboard untuk mengelola multiple social media accounts dengan scheduling dan analytics features.',
                'created_at' => Carbon::now()->subDays(3),
            ],
        ];

        $createdProjects = [];
        foreach ($projects as $projectData) {
            $project = Project::create([
                'name' => $projectData['name'],
                'description' => $projectData['description'],
                'created_at' => $projectData['created_at'],
                'updated_at' => $projectData['created_at'],
            ]);
            $createdProjects[] = $project;

            // Assign staff to projects
            $assignedStaff = collect($staffUsers)->random(rand(3, 5))->pluck('id');
            foreach ($assignedStaff as $staffId) {
                $project->members()->attach($staffId, ['role' => $this->getRandomRole()]);
            }
        }

        // 4. Create Tasks for each project
        $taskTemplates = [
            ['title' => 'Setup Database Schema', 'priority' => 'high'],
            ['title' => 'Create User Authentication', 'priority' => 'high'],
            ['title' => 'Design UI/UX Mockups', 'priority' => 'medium'],
            ['title' => 'Implement Frontend Components', 'priority' => 'medium'],
            ['title' => 'API Development', 'priority' => 'high'],
            ['title' => 'Unit Testing', 'priority' => 'medium'],
            ['title' => 'Documentation', 'priority' => 'low'],
            ['title' => 'Code Review', 'priority' => 'medium'],
            ['title' => 'Performance Optimization', 'priority' => 'low'],
            ['title' => 'Security Audit', 'priority' => 'high'],
            ['title' => 'Deploy to Staging', 'priority' => 'medium'],
            ['title' => 'Client Presentation', 'priority' => 'low'],
        ];

        foreach ($createdProjects as $project) {
            $taskCount = rand(5, 12);
            $selectedTasks = collect($taskTemplates)->random($taskCount);
            
            foreach ($selectedTasks as $index => $taskTemplate) {
                $dueDate = Carbon::now()->addDays(rand(-10, 30));
                $status = $this->getRandomStatus($dueDate);
                
                $task = Task::create([
                    'title' => $taskTemplate['title'],
                    'description' => $this->generateTaskDescription($taskTemplate['title']),
                    'project_id' => $project->id,
                    'priority' => $taskTemplate['priority'],
                    'status' => $status,
                    'due_date' => $dueDate,
                    'created_at' => $project->created_at->addDays($index),
                    'updated_at' => $project->created_at->addDays($index + 1),
                ]);

                // Assign staff to tasks
                $projectStaff = $project->members->pluck('id');
                $assignedStaff = $projectStaff->random(rand(1, 3));
                $task->users()->attach($assignedStaff);

                // Create progress reports for completed/in-progress tasks
                if ($status !== 'pending') {
                    $this->createProgressReports($task, $assignedStaff);
                }
            }
        }

        $this->command->info('✅ Dummy data created successfully!');
        $this->command->info('📧 Admin login: admin@cybertask.com / password');
        $this->command->info('👥 Staff accounts: andi@cybertask.com, budi@cybertask.com, etc / password');
    }

    private function getRandomRole()
    {
        $roles = ['Developer', 'Designer', 'Tester', 'Project Manager', 'Team Lead'];
        return $roles[array_rand($roles)];
    }

    private function getRandomStatus($dueDate)
    {
        if ($dueDate->isPast()) {
            return rand(0, 3) === 0 ? 'pending' : 'completed';
        } elseif ($dueDate->diffInDays(now()) < 7) {
            return rand(0, 2) === 0 ? 'pending' : (rand(0, 1) ? 'in_progress' : 'completed');
        } else {
            return rand(0, 4) === 0 ? 'in_progress' : 'pending';
        }
    }

    private function generateTaskDescription($title)
    {
        $descriptions = [
            'Setup Database Schema' => 'Mendesain dan mengimplementasikan struktur database yang optimal untuk aplikasi. Membuat tabel-tabel yang diperlukan dengan relasi yang tepat.',
            'Create User Authentication' => 'Mengimplementasikan sistem autentikasi user yang aman dengan fitur login, register, password reset, dan role-based access control.',
            'Design UI/UX Mockups' => 'Membuat desain interface yang user-friendly dan modern. Menggunakan Figma untuk membuat wireframe dan high-fidelity mockups.',
            'Implement Frontend Components' => 'Mengembangkan komponen-komponen frontend yang reusable dengan React/Vue.js. Memastikan responsive design di semua device.',
            'API Development' => 'Membuat RESTful API yang robust dan well-documented. Mengimplementasikan proper error handling dan rate limiting.',
            'Unit Testing' => 'Menulis unit test untuk memastikan code quality dan functionality. Menggunakan PHPUnit untuk backend dan Jest untuk frontend.',
            'Documentation' => 'Membuat dokumentasi teknis yang lengkap untuk API dan user guide. Menggunakan Swagger untuk API documentation.',
            'Code Review' => 'Melakukan code review untuk memastikan best practices dan coding standards terpenuhi. Memberikan feedback yang constructive.',
            'Performance Optimization' => 'Mengoptimalkan aplikasi untuk performa yang lebih baik. Implementasi caching, query optimization, dan lazy loading.',
            'Security Audit' => 'Melakukan security audit untuk mengidentifikasi dan memperbaiki vulnerability. Implementasi security best practices.',
            'Deploy to Staging' => 'Mengatur deployment pipeline untuk staging environment. Mengimplementasikan CI/CD dengan GitHub Actions.',
            'Client Presentation' => 'Mempersiapkan dan melakukan presentasi ke client. Membuat demo yang impressive dan documentation yang jelas.',
        ];

        return $descriptions[$title] ?? 'Melakukan pengembangan fitur sesuai dengan requirements yang telah ditentukan. Memastikan deliverables sesuai dengan timeline dan quality standards.';
    }

    private function createProgressReports($task, $assignedStaff)
    {
        $reportCount = rand(1, 5);
        $staff = User::whereIn('id', $assignedStaff)->get();
        
        for ($i = 0; $i < $reportCount; $i++) {
            $reportDate = $task->created_at->addDays(rand(1, 10));
            $reporter = $staff->random();
            
            Comment::create([
                'task_id' => $task->id,
                'user_id' => $reporter->id,
                'title' => $this->generateReportTitle(),
                'content' => $this->generateReportContent(),
                'created_at' => $reportDate,
                'updated_at' => $reportDate,
            ]);
        }
    }

    private function generateReportTitle()
    {
        $titles = [
            'Progress Update',
            'Mantap',
            'Almost Done',
            'Bug Fixed',
            'Feature Complete',
            'Testing Phase',
            'Code Review Done',
            'Deployment Ready',
            'Client Feedback',
            'Performance Test',
            'Security Check',
            'Documentation Updated',
        ];
        return $titles[array_rand($titles)];
    }

    private function generateReportContent()
    {
        $contents = [
            "Sudah menyelesaikan fitur utama sesuai dengan requirement. Testing akan dilakukan besok.",
            "Progress hari ini sudah sesuai target. Tidak ada kendala yang signifikan.",
            "Bug yang dilaporkan kemarin sudah diperbaiki. Siap untuk testing.",
            "Implementasi API sudah selesai. Documentation sedang dalam proses.",
            "UI sudah responsive dan user-friendly. Menunggu approval dari design team.",
            "Database optimization berhasil dilakukan. Performa meningkat 40%.",
            "Security audit sudah selesai. Tidak ada vulnerability yang ditemukan.",
            "Integration testing berhasil. Semua modules berfungsi dengan baik.",
            "Client feedback sudah diterima. Perubahan minor akan dilakukan.",
            "Deployment ke staging berhasil. Production deployment besok.",
        ];
        return $contents[array_rand($contents)];
    }
}
