<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;

class Auth extends BaseController
{
    public function login(string $role = 'customer')
    {
        $role = $this->normalizeRole($role);

        return view('auth/login', [
            'title'       => $role === 'admin' ? 'Login Admin' : 'Login Pelanggan',
            'formAction'  => '/login/' . $role,
            'roleMode'    => $role,
            'subtitle'    => $role === 'admin'
                ? 'Masuk sebagai admin untuk kelola toko'
                : 'Masuk sebagai pelanggan untuk belanja',
            'adminAvailable' => $this->adminExists(),
        ]);
    }

    public function register()
    {
        return view('auth/register', [
            'title'       => 'Daftar Akun',
            'formAction'  => '/register',
            'submitLabel' => 'Daftar',
            'subtitle'    => 'Buat akun pelanggan baru',
            'isAdminForm' => false,
        ]);
    }

    public function registerAdmin()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return view('auth/register', [
            'title'       => 'Daftar Admin',
            'formAction'  => '/admin/register',
            'submitLabel' => 'Simpan Admin',
            'subtitle'    => 'Tambahkan akun admin baru',
            'isAdminForm' => true,
        ]);
    }

    public function processRegister()
    {
        return $this->processRegistration('customer', '/login/customer', 'Akun berhasil dibuat. Silakan login.');
    }

    public function processAdminRegister()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        return $this->processRegistration('admin', '/pengaturan', 'Akun admin berhasil dibuat.');
    }

    public function setupAdmin()
    {
        if ($this->adminExists()) {
            return redirect()->to('/login/admin')->with('error', 'Admin sudah tersedia. Silakan login sebagai admin.');
        }

        return view('auth/register', [
            'title'       => 'Setup Admin Pertama',
            'formAction'  => '/setup-admin',
            'submitLabel' => 'Buat Admin Pertama',
            'subtitle'    => 'Buat akun admin awal untuk mengelola toko',
            'isAdminForm' => true,
        ]);
    }

    public function processSetupAdmin()
    {
        if ($this->adminExists()) {
            return redirect()->to('/login/admin')->with('error', 'Admin sudah tersedia. Silakan login sebagai admin.');
        }

        return $this->processRegistration('admin', '/login/admin', 'Akun admin pertama berhasil dibuat. Silakan login.');
    }

    private function processRegistration(string $role, string $redirectTo, string $successMessage)
    {
        $rules = [
            'username' => [
                'rules'  => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
                'errors' => [
                    'required'            => 'Username wajib diisi.',
                    'alpha_numeric_space' => 'Username hanya boleh berisi huruf, angka, dan spasi.',
                    'min_length'          => 'Username minimal 3 karakter.',
                    'max_length'          => 'Username maksimal 30 karakter.',
                    'is_unique'           => 'Username sudah digunakan.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique'   => 'Email sudah terdaftar.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required'   => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 8 karakter.',
                    'max_length' => 'Password terlalu panjang.',
                ],
            ],
            'pass_confirm' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches'  => 'Konfirmasi password tidak sama.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = new UserModel();

        $userId = $users->insert([
            'username'      => trim((string) $this->request->getPost('username')),
            'email'         => trim((string) $this->request->getPost('email')),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'        => 1,
        ]);

        if (! $userId) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        \Config\Database::connect()
            ->table('users')
            ->where('id', $userId)
            ->update(['role' => $role]);

        return redirect()->to($redirectTo)->with('sukses', $successMessage);
    }

    public function process()
    {
        return $this->processLogin('customer');
    }

    public function processCustomerLogin()
    {
        return $this->processLogin('customer');
    }

    public function processAdminLogin()
    {
        return $this->processLogin('admin');
    }

    private function processLogin(string $expectedRole)
    {
        $db = \Config\Database::connect();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $db->table('users')
                   ->where('email', $email)
                   ->get()
                   ->getRow();

        if ($user && password_verify($password, $user->password_hash)) {
            $actualRole = $this->normalizeRole((string) ($user->role ?? 'customer'));

            if ($actualRole !== $expectedRole) {
                $message = $expectedRole === 'admin'
                    ? 'Akun ini bukan akun admin.'
                    : 'Akun admin harus masuk melalui halaman admin.';

                return redirect()->back()->withInput()->with('error', $message);
            }

            session()->set([
                'isLoggedIn' => true,
                'user_id'    => $user->id ?? $user->id_user,
                'username'   => $user->username ?? $user->nama,
                'email'      => $user->email,
                'role'       => $actualRole,
            ]);

            if ($actualRole === 'admin') {
                return redirect()->to('/dashboard'); // Admin ke Dashboard Manajemen
            }

            return redirect()->to('/barang'); // Pelanggan ke Toko/Katalog
        }

        return redirect()->back()->withInput()->with('error', 'Email atau password salah');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    private function adminExists(): bool
    {
        return \Config\Database::connect()
            ->table('users')
            ->where('role', 'admin')
            ->countAllResults() > 0;
    }

    private function normalizeRole(string $role): string
    {
        return $role === 'admin' ? 'admin' : 'customer';
    }
}
