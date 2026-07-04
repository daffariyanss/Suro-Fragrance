<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        // load helper kalau perlu
        // helper(['form', 'url']);
    }

    protected function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return null;
    }

    protected function requireAdmin()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Hanya admin yang dapat membuka halaman ini.');
        }

        return null;
    }
}
