<?php

namespace App\Controllers;

use App\Models\PesanModel;
use CodeIgniter\HTTP\RedirectResponse;

class Pages extends BaseController
{
    public function about(): string
    {
        return view('pages/about', ['title' => 'Tentang']);
    }

    public function contact(): string
    {
        return view('pages/contact', ['title' => 'Kontak']);
    }

    public function kirimPesan(): RedirectResponse
    {
        $model = new PesanModel();
        $data  = $this->request->getPost(['nama', 'email', 'subjek', 'isi']);

        if (! $model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to('/contact')->with('success', 'Terima kasih, pesan Anda sudah kami terima.');
    }
}
