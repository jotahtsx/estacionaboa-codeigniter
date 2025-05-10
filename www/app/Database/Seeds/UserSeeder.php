<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $faker = Factory::create();

        $numUsers = 5;
        for ($i = 0; $i < $numUsers; $i++) {
            $username = $faker->userName;
            $email = $faker->email;
            $password = 'senha123';

            $userData = [
                'username'   => $username,
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'active'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $userId = $userModel->insert($userData);

            if ($userId) {
                $this->db->table('auth_identities')->insert([
                    'user_id' => $userId,
                    'type'    => 'email_password',
                    'secret'  => $email,
                    'secret2' => password_hash($password, PASSWORD_DEFAULT),
                ]);
            }
        }

        $existingAdmin = $userModel->where('username', 'admin')->first();

        if (!$existingAdmin) {
            $adminData = [
                'username'   => 'admin',
                'first_name' => 'Admin',
                'last_name'  => 'User',
                'active'     => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $adminId = $userModel->insert($adminData);

            if ($adminId) {
                $this->db->table('auth_identities')->insert([
                    'user_id' => $adminId,
                    'type'    => 'email_password',
                    'secret'  => 'admin@example.com',
                    'secret2' => password_hash('admin123', PASSWORD_DEFAULT),
                ]);

                $adminGroup = $this->db->table('auth_groups')->where('name', 'admin')->get()->getRow();
                if (!$adminGroup) {
                    $this->db->table('auth_groups')->insert([
                        'name'        => 'admin',
                        'description' => 'Administrador do sistema',
                    ]);
                    $adminGroup = $this->db->table('auth_groups')->where('name', 'admin')->get()->getRow();
                }

                $this->db->table('auth_groups_users')->insert([
                    'group_id' => $adminGroup->id,
                    'user_id'  => $adminId,
                ]);
            }
        }

        echo "Seeders de usuários criados com sucesso!\n";
    }
}
