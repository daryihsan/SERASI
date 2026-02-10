<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nip' => 'admin',
            'name' => 'Administrator Utama',
            'password' => 'tikAdmiNbpomsmg',
            'role' => 'inspeksi'
        ]);
        
        User::create([
            'nip' => '198308192010121001',
            'name' => 'Agung Wijayanto, S.Kom',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);
    }
}
