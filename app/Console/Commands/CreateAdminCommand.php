<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin {email=magalhaes.lemos@softmedia-ao.com} {password=54#Asoftmedia}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or reset the production admin user and roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $this->info("Creating roles...");
        $roles = ['admin', 'tech', 'formador', 'instrutor', 'aluno', 'empresa', 'cliente'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        $this->info("Creating/updating admin user: {$email}...");
        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Magalhães Lemos',
                'password' => Hash::make($password),
                'phone' => '+244 975 824 787',
                'is_active' => true,
                'require_password_change' => false,
                'email_verified_at' => now(),
            ]
        );

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admin->syncRoles([$adminRole]);
        }

        $this->info("SUCCESS! Admin user is ready.");
        $this->info("Email: {$email}");
        $this->info("Password: {$password}");
        $this->info("Role: admin");

        return Command::SUCCESS;
    }
}
