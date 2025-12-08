<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // admins table
        $admin = Admin::firstOrNew(['email' => 'admin@example.com']);
        $admin->name = 'Administrator';
        $admin->password = Hash::make('password123');
        $admin->save();

        // users table - ensure role is admin
        $user = User::firstOrNew(['email' => 'admin@example.com']);
        $user->name = 'Administrator';
        $user->password = Hash::make('password123');
        $user->role = 'admin';
        $user->email_verified_at = now();
        $user->remember_token = Str::random(40);  
        $user->save();

        // OPTIONAL: staff user
        $staff = User::firstOrNew(['email' => 'staff@example.com']);
        $staff->name = 'Staff User';
        $staff->password = Hash::make('staffpass');
        $staff->role = 'staff';
        $staff->email_verified_at = now();
        $staff->remember_token = Str::random(40);
        $staff->save();
    }
}
