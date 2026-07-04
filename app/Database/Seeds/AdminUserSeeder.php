<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\UserModel;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $email = 'admin@gmail.com';
        $username = 'admin';
        $password = '123456';

        $users = new UserModel();
        $existing = $users->where('email', $email)->first();

        $payload = [
            'username'      => $username,
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'active'        => 1,
        ];

        if ($existing) {
            $users->update($existing->id, $payload);
        } else {
            $users->insert($payload);
        }

        $this->db->table('users')
            ->where('email', $email)
            ->update(['role' => 'admin']);
    }
}
