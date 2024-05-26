<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Gender;
use App\Models\jabatan;
use App\Models\Level_user;
use App\Models\Organization;
use App\Models\Priority;
use App\Models\Profil;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Profil::create([
        //     'kontak' => '082188456925',
        //     'alamat' => 'Matakali'
        // ]);
        
        // User::create([
        //     'name' => 'Hera Annisa',
        //     'username' => 'herawati',
        //     'email' => 'hera@gmail.com',
        //     'password' => bcrypt('123456'),
        //     'genders_id' => 2,
        //     'roles_id' => 2,
        //     'profil_id' => 1
        // ]);

        
        // jabatan::create(
        //     [
        //         'name' => 'Kaprodi Teknik Sipil',
        //         'organisasi_id' => 1
        //     ]
        // );

        // jabatan::create(
        //     [
        //         'name' => 'Staf Teknik Sipil',
        //         'organisasi_id' => 1
        //     ]
        // );
        // User::factory(3)->create();

        // Organization::create(
        //     [
        //         'name' => "Informatika"
        //     ]
        // );

        // Organization::create(
        //     [
        //         'name' => "Teknik Sipil"
        //     ]
        // );

        // Organization::create(
        //     [
        //         'name' => "PWK"
        //     ]
        // );

        // Organization::create(
        //     [
        //         'name' => "Fakultas"
        //     ]
        // );

        // Gender::create([
        //     'namaGender' => "Laki-laki"
        // ]);

        // Gender::create([
        //     'namaGender' => "Perempuan"
        // ]);

        // Role::create([
        //     'name_role' => 'Admin'
        // ]);

        // Role::create([
        //     'name_role' => 'pejabat'
        // ]);

        // Role::create([
        //     'name_role' => 'staf'
        // ]);

        // Priority::create([
        //     'name'   => 'low'
        // ]);

        // Priority::create([
        //     'name'   => 'medium'
        // ]);
        // Priority::create([
        //     'name'   => 'high'
        // ]);
        // Priority::create([
        //     'name'   => 'urgent'
        // ]);


        // Status::create([
        //     'name_status'   => 'register'
        // ]);

        // Status::create([
        //     'name_status'   => 'on progres'
        // ]);
        // Status::create([
        //     'name_status'   => 'pending'
        // ]);
        // Status::create([
        //     'name_status'   => 'revisi'
        // ]);
        // Status::create([
        //     'name_status'   => 'finish'
        // ]);
        // Status::create([
        //     'name_status'   => 'accepted'
        // ]);

        Level_user::create([
            'name_level'    =>  'Dekan',
            'role_id'       =>  2
        ]);

        Level_user::create([
            'name_level'    =>  'Wakil Dekan 1',
            'role_id'       =>  2
        ]);

        Level_user::create([
            'name_level'    =>  'Wakil Dekan 2',
            'role_id'       =>  2
        ]);

        Level_user::create([
            'name_level'    =>  'Pimpinan Prodi',
            'role_id'       =>  2
        ]);

        Level_user::create([
            'name_level'    =>  'Staf',
            'role_id'       =>  2
        ]);
    }
}
