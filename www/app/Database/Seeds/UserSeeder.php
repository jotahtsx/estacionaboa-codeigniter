<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Entities\User;
use App\Models\UserModel;
use Config\Database;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $db = Database::connect();

        // Verifica se o e-mail já existe na tabela auth_identities
        $emailIdentity = $db->table('auth_identities')
            ->where('type', 'email_password')
            ->where('secret', 'admin@example.com')
            ->get()
            ->getRow();

        if ($emailIdentity) {
            // Recupera o ID do usuário existente
            $userId = $emailIdentity->user_id;


            $user = $userModel->find($userId);
            if ($user) {
                $user->fill([
                    'password'    => 'senha123',
                    'first_name' => 'Jon',
                    'last_name' => 'Doe',
                    'gender' => 'male',
                ]);
                $userModel->save($user);
            }
        } else {
            $user = new User([
                'username'    => 'admin',
                'email'       => 'admin@example.com',
                'password'    => 'senha123',
                'active'      => 1,
                'first_name' => 'Administrador',
                'last_name' => 'Subtittulo',
                'gender' => 'male',
            ]);

            $userModel->save($user);
            $userId = $userModel->getInsertID();
        }

        // Verifica se a tabela de grupos existe
        if ($db->tableExists('auth_groups')) {
            $group = $db->table('auth_groups')
                ->where('name', 'admin')
                ->get()
                ->getRow();

            if (!$group) {
                $db->table('auth_groups')->insert([
                    'name'        => 'admin',
                    'description' => 'Administrador do sistema',
                ]);
                $groupId = $db->insertID();
            } else {
                $groupId = $group->id;
            }

            $alreadyAssociated = $db->table('auth_groups_users')
                ->where('user_id', $userId)
                ->where('group_id', $groupId)
                ->countAllResults();

            if (!$alreadyAssociated) {
                $db->table('auth_groups_users')->insert([
                    'user_id'  => $userId,
                    'group_id' => $groupId,
                ]);
            }
        }
    }
}
