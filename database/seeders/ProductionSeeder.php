<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Setting;
use App\Models\ProductCategory;
use App\Models\Category as CourseCategory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds for production.
     */
    public function run(): void
    {
        // 1. Roles & Permissions (Spatie)
        $roles = ['admin', 'tech', 'formador', 'instrutor', 'aluno', 'empresa', 'cliente'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // 2. Admin User
        $adminEmail = 'magalhaes.lemos@softmedia-ao.com';
        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Magalhães Lemos',
                'password' => Hash::make('54#Asoftmedia'),
                'phone' => '+244 975 824 787',
                'is_active' => true,
                'require_password_change' => false,
                'email_verified_at' => now(),
            ]
        );
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole && !$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        // 3. Initial Settings
        $settings = [
            'site_name' => 'ASoftMedia',
            'contact_email' => 'info@softmedia-ao.com',
            'contact_phone' => '+244 975 824 787',
            'contact_phone_alt' => '+244 956 616 567',
            'contact_address' => 'Sapu 2, Casas Azuis, Rua da Uva, Luanda - Angola',
            'whatsapp_number' => '244975824787',
            'geo_lat' => '-8.9343238138973',
            'geo_lng' => '13.30569966776501',
            'geo_radius_meters' => '50',
            'ponto_hora_entrada' => '08:00',
            'ponto_hora_saida' => '17:00',
        ];

        foreach ($settings as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        // 4. Default Categories for Store and LMS
        $prodCategories = ['Softwares & Licenças', 'Computadores & Servidores', 'Equipamentos de Rede', 'Acessórios & Periféricos'];
        foreach ($prodCategories as $cat) {
            ProductCategory::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($cat)],
                ['name' => $cat]
            );
        }

        $courseCategories = ['Desenvolvimento de Software', 'Redes & Infraestruturas', 'Gestão & Negócios', 'Segurança da Informação'];
        foreach ($courseCategories as $cCat) {
            CourseCategory::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($cCat)],
                ['name' => $cCat]
            );
        }
    }
}
