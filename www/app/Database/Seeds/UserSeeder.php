<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Models\UserModel;
use Config\Database;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $db = Database::connect();

        $identity = $db->table('auth_identities')
            ->where('type', 'email_password')
            ->where('secret', 'admin@example.com')
            ->get()
            ->getRow();

        if (!$identity) {
            $user = $userModel->register([
                'email'    => 'admin@example.com',
                'username' => 'admin',
                'password' => 'senha123',
            ]);

            $userId = $user->id;
        } else {
            $userId = $identity->user_id;
            $userModel->update($userId, [
                'username' => 'admin',
            ]);
        }


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

            $exists = $db->table('auth_groups_users')
                ->where('user_id', $userId)
                ->where('group_id', $groupId)
                ->countAllResults();

            if (!$exists) {
                $db->table('auth_groups_users')->insert([
                    'user_id'  => $userId,
                    'group_id' => $groupId,
                ]);
            }
        }
    }
}
