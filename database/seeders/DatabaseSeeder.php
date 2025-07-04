<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat role admin jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $manajerRole = Role::firstOrCreate(['name' => 'manajer']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $pelangganRole = Role::firstOrCreate(['name' => 'pelanggan']);

        // Membuat user admin dummy
        $admin = User::firstOrCreate(
            ['email' => 'admin@crmpln.test'],
            [
                'password' => Hash::make('admin123'),
                'nama_lengkap' => 'Admin CRM PLN',
            ]
        );
        $admin->assignRole($adminRole);

        // Membuat user manajer dummy
        $manajer = User::firstOrCreate(
            ['email' => 'manajer@crmpln.test'],
            [
                'password' => Hash::make('manajer123'),
                'nama_lengkap' => 'Manajer CRM PLN',
            ]
        );
        $manajer->assignRole($manajerRole);

        // Membuat user staff dummy
        $staff = User::firstOrCreate(
            ['email' => 'staff@crmpln.test'],
            [
                'password' => Hash::make('staff123'),
                'nama_lengkap' => 'Staff CRM PLN',
            ]
        );
        $staff->assignRole($staffRole);

        // Membuat user pelanggan dummy
        $pelanggan = User::firstOrCreate(
            ['email' => 'pelanggan@crmpln.test'],
            [
                'password' => Hash::make('pelanggan123'),
                'nama_lengkap' => 'Pelanggan CRM PLN',
            ]
        );
        $pelanggan->assignRole($pelangganRole);
    }
}
