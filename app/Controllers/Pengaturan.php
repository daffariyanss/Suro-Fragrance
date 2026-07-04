<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Pengaturan extends BaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $user = $this->findCurrentUser();

        return view('pengaturan/index', ['user' => $user]);
    }

    public function update()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $user = $this->findCurrentUser();
        $data = [
            'id'       => $user->id,
            'username' => trim((string) $this->request->getPost('username')),
            'email'    => trim((string) $this->request->getPost('email')),
        ];

        if (! $this->validateData($data, [
            'id' => 'required|is_natural_no_zero',
            'username' => [
                'rules'  => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
                'errors' => [
                    'required'            => 'Username wajib diisi.',
                    'alpha_numeric_space' => 'Username hanya boleh berisi huruf, angka, dan spasi.',
                    'min_length'          => 'Username minimal 3 karakter.',
                    'max_length'          => 'Username maksimal 30 karakter.',
                    'is_unique'           => 'Username sudah digunakan.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email,id,{id}]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah digunakan.',
                ],
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $newPassword = (string) $this->request->getPost('new_password');

        if ($newPassword !== '') {
            $currentPassword = (string) $this->request->getPost('current_password');
            $confirmation    = (string) $this->request->getPost('pass_confirm');

            if (! password_verify($currentPassword, $user->password_hash)) {
                return redirect()->back()->withInput()->with('errors', [
                    'current_password' => 'Password saat ini salah.',
                ]);
            }

            if (strlen($newPassword) < 8) {
                return redirect()->back()->withInput()->with('errors', [
                    'new_password' => 'Password baru minimal 8 karakter.',
                ]);
            }

            if ($newPassword !== $confirmation) {
                return redirect()->back()->withInput()->with('errors', [
                    'pass_confirm' => 'Konfirmasi password baru tidak sama.',
                ]);
            }

            $data['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        unset($data['id']);

        \Config\Database::connect()
            ->table('users')
            ->where('id', $user->id)
            ->update($data);

        session()->set([
            'username' => $data['username'],
            'email'    => $data['email'],
        ]);

        return redirect()->to('/pengaturan')->with('sukses', 'Pengaturan akun berhasil diperbarui.');
    }

    private function findCurrentUser(): object
    {
        $user = \Config\Database::connect()
            ->table('users')
            ->where('id', session()->get('user_id'))
            ->get()
            ->getRow();

        if (! $user) {
            session()->destroy();
            throw PageNotFoundException::forPageNotFound('Akun tidak ditemukan.');
        }

        return $user;
    }

}
