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
            'nip' => '196805171995032000',
            'name' => 'Dra. Aryanti, Apt, MSi.',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '197907102006042000',
            'name' => 'Purwaningdyah Reni Hapsari, S.Farm, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '197203211998032000',
            'name' => 'Dwi Ernawati, S.Si, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198002152006042000',
            'name' => 'Suhriyah, S.Farm, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198012232006042000',
            'name' => 'Tri Nurkhayati, S.Farm, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '197706042002122000',
            'name' => 'Yuyun Wijayanti, S.Si, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '196812241997032000',
            'name' => 'Dra. Daniel Kristini, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198206012006042000',
            'name' => 'Elisa Kesumaesthy, S.Farm, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198101252006041000',
            'name' => 'Ronald Hatoguan Manik, STP, MBA',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198108252005012000',
            'name' => 'Suci Wulandari, STP',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '197808062005012000',
            'name' => 'Arini Himawati, SF, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '197312011996032000',
            'name' => 'Tri Wahyu Pujiasih, A.Md',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198403102009122000',
            'name' => 'Dian Cahyaningsih, S.Farm, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '197202011992032000',
            'name' => 'Eka Untari, SKM',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198310052008122000',
            'name' => 'Erna Kurniawati, S.Farm, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198109062007121000',
            'name' => 'Etta Hermawan, A.Md',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198103132006042000',
            'name' => 'Ika Dian Wahyuni, S.Farm, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);
        
        User::create([
            'nip' => '198404292008122000',
            'name' => 'Ima Diana Sari, S.Farm, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '197201301997032000',
            'name' => 'Nur Afifah, A.Md',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198002262006042000',
            'name' => 'Nur Faridah Amin, S.Si, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198010282005012000',
            'name' => 'Pniel Mardiana Chandra, S.Si, Apt,. M.A.B',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '197504261994032000',
            'name' => 'Retno Purwaningsih, SKM',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '198412302010121000',
            'name' => 'Sigit Hartomo, S.Farm, Apt',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '197107091995031000',
            'name' => 'Sumito, A.Md',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);

        User::create([
            'nip' => '196909271991031000',
            'name' => 'Teguh Budiono',
            'password' => 'tikbpomsmg',
            'role' => 'inspeksi'
        ]);
    }
}
