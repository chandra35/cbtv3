<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================================
        // PERMISSIONS FOR CBT SYSTEM
        // ============================================
        
        $permissions = [
            // Dashboard
            'view-dashboard',
            
            // Exam Management
            'view-exams',
            'create-exams',
            'edit-exams',
            'delete-exams',
            'publish-exams',
            'view-exam-detail',
            
            // Question Management
            'view-questions',
            'create-questions',
            'edit-questions',
            'delete-questions',
            'manage-question-bank',
            'import-questions',
            
            // Question Groups
            'view-question-groups',
            'create-question-groups',
            'edit-question-groups',
            'delete-question-groups',
            
            // Participant Management
            'view-participants',
            'add-participants',
            'remove-participants',
            'bulk-import-participants',
            'export-participants',
            
            // Exam Execution
            'view-exam-execution',
            'monitor-exam-live',
            'unlock-participant-exam',
            'end-exam-early',
            'view-submissions',
            
            // Grading & Results
            'view-results',
            'grade-essay-questions',
            'export-results',
            'view-analytics',
            'view-question-statistics',
            
            // Mobile App Settings
            'manage-mobile-app-settings',
            'set-exam-passwords',
            'manage-mobile-restrictions',
            'configure-anti-cheating',
            
            // Settings
            'manage-settings',
            'manage-integrations',
            'view-activity-logs',
            
            // GTK Personal
            'view-gtk-dashboard',
            'edit-gtk-profile',
            'change-password-gtk',
            
            // Profile
            'view-profile',
            'edit-profile',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        $this->command->info('✅ ' . count($permissions) . ' permissions created');

        // ============================================
        // ROLES
        // ============================================

        // 1. SUPER ADMIN - Full Access
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());
        $this->command->info('✅ Super Admin role created');

        // 2. ADMIN CBT - Full exam and question management
        $adminCBT = Role::firstOrCreate(['name' => 'Admin CBT']);
        $adminCBT->givePermissionTo([
            'view-dashboard',
            'view-exams', 'create-exams', 'edit-exams', 'delete-exams', 'publish-exams', 'view-exam-detail',
            'view-questions', 'create-questions', 'edit-questions', 'delete-questions', 'manage-question-bank', 'import-questions',
            'view-question-groups', 'create-question-groups', 'edit-question-groups', 'delete-question-groups',
            'view-participants', 'add-participants', 'remove-participants', 'bulk-import-participants', 'export-participants',
            'view-exam-execution', 'monitor-exam-live', 'unlock-participant-exam', 'end-exam-early',
            'view-submissions', 'grade-essay-questions',
            'view-results', 'export-results', 'view-analytics', 'view-question-statistics',
            'manage-mobile-app-settings', 'set-exam-passwords', 'manage-mobile-restrictions', 'configure-anti-cheating',
            'manage-settings', 'manage-integrations', 'view-activity-logs',
            'view-profile', 'edit-profile',
        ]);
        $this->command->info('✅ Admin CBT role created');

        // 3. OPERATOR CBT - Data entry and monitoring
        $operatorCBT = Role::firstOrCreate(['name' => 'Operator CBT']);
        $operatorCBT->givePermissionTo([
            'view-dashboard',
            'view-exams', 'view-exam-detail',
            'view-questions', 'view-question-groups',
            'view-participants', 'add-participants', 'remove-participants', 'bulk-import-participants',
            'view-exam-execution', 'monitor-exam-live',
            'view-submissions',
            'view-results', 'export-results',
            'view-analytics', 'view-question-statistics',
            'view-activity-logs',
            'view-profile', 'edit-profile',
        ]);
        $this->command->info('✅ Operator CBT role created');

        // 4. GTK (Guru & Tenaga Kependidikan) - Can create exams and questions
        $gtk = Role::firstOrCreate(['name' => 'GTK']);
        $gtk->givePermissionTo([
            'view-dashboard',
            'view-exams', 'create-exams', 'edit-exams', 'view-exam-detail',
            'view-questions', 'create-questions', 'edit-questions', 'manage-question-bank', 'import-questions',
            'view-question-groups', 'create-question-groups', 'edit-question-groups',
            'view-participants',
            'view-exam-execution', 'monitor-exam-live',
            'view-submissions',
            'view-results', 'view-analytics', 'view-question-statistics',
            'manage-mobile-app-settings', 'set-exam-passwords', 'configure-anti-cheating',
            'view-gtk-dashboard',
            'edit-gtk-profile', 'change-password-gtk',
            'view-profile', 'edit-profile',
        ]);
        $this->command->info('✅ GTK role created');

        // 5. KEPALA MADRASAH - Leadership role
        $kepalaMadrasah = Role::firstOrCreate(['name' => 'Kepala Madrasah']);
        $kepalaMadrasah->givePermissionTo([
            'view-dashboard',
            'view-exams', 'view-exam-detail',
            'view-questions', 'view-question-groups',
            'view-participants', 'export-participants',
            'view-exam-execution', 'monitor-exam-live',
            'view-submissions',
            'view-results', 'export-results', 'view-analytics', 'view-question-statistics',
            'view-activity-logs',
            'view-profile', 'edit-profile',
        ]);
        $this->command->info('✅ Kepala Madrasah role created');

        // 6. WAKA (Wakil Kepala) - Similar to Kepala Madrasah
        $waka = Role::firstOrCreate(['name' => 'WAKA']);
        $waka->givePermissionTo([
            'view-dashboard',
            'view-exams', 'view-exam-detail',
            'view-questions', 'view-question-groups',
            'view-participants', 'export-participants',
            'view-exam-execution', 'monitor-exam-live',
            'view-submissions',
            'view-results', 'export-results', 'view-analytics', 'view-question-statistics',
            'view-activity-logs',
            'view-profile', 'edit-profile',
        ]);
        $this->command->info('✅ WAKA role created');

        // 7. SISWA - Student taking exam (minimal permissions)
        $siswa = Role::firstOrCreate(['name' => 'Siswa']);
        $siswa->givePermissionTo([
            'view-profile',
            'edit-profile',
        ]);
        $this->command->info('✅ Siswa role created');

        $this->command->line('');
        $this->command->info('🎉 CBT RBAC System setup completed!');
        $this->command->line('');
        $this->command->info('📋 Summary:');
        $this->command->info('   - Total Permissions: ' . Permission::count());
        $this->command->info('   - Total Roles: ' . Role::count());
        $this->command->line('');
        $this->command->info('👥 Roles created:');
        $this->command->info('   1. Super Admin (All Permissions)');
        $this->command->info('   2. Admin CBT (Full Management)');
        $this->command->info('   3. Operator CBT (Data Entry & Monitoring)');
        $this->command->info('   4. GTK (Guru & Tenaga Kependidikan - Create Exams & Questions)');
        $this->command->info('   5. Kepala Madrasah (Leadership - View Only)');
        $this->command->info('   6. WAKA (Deputy Principal - View Only)');
        $this->command->info('   7. Siswa (Student - Profile Access Only)');
    }
}
