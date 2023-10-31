<?php

namespace Database\Seeders;

use App\Repository\UserRepository;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Admin',
            'email' =>  'admin@dailycstore.com.br',
            'password' => 'D@ily23$$!',
        ];

        try {
            (new UserRepository($data))->create();
        } catch (\Throwable) {
            exit;
        }
    }
}
