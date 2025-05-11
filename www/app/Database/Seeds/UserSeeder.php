<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use Config\Database;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $db = Database::connect();

        // Cria um novo usuário
        $user = new User([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => 'senha123',
            'active'   => 1,
        ]);

        $userModel->save($user);
        $userId = $userModel->getInsertID();

        // Verifica se a tabela de grupos existe
        if ($db->tableExists('auth_groups')) {
            // Tenta pegar o grupo "admin"
            $group = $db->table('auth_groups')
                        ->where('name', 'admin')
                        ->get()
                        ->getRow();

            // Se o grupo não existir, cria
            if (!$group) {
                $db->table('auth_groups')->insert([
                    'name'        => 'admin',
                    'description' => 'Administrador do sistema',
                ]);

                $groupId = $db->insertID();
            } else {
                $groupId = $group->id;
            }

            // Associa o usuário ao grupo
            $db->table('auth_groups_users')->insert([
                'user_id'  => $userId,
                'group_id' => $groupId,
            ]);
        }
    }
}
