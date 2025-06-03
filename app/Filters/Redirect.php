<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Redirect implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Kosong, karena ini after filter
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $session = session();

        // Cek apakah user baru saja login
        if ($session->has('isLoggedIn') && current_url() === site_url('login')) {
            $role = $session->get('role');

            // Redirect berdasarkan role
            if ($role === 'admin') {
                return redirect()->to('/produk');
            } elseif ($role === 'user') {
                return redirect()->to('/');
            }
        }

        return $response;
    }
}