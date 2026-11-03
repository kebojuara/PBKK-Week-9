<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesanModel;
use CodeIgniter\HTTP\RedirectResponse;

class Pesan extends BaseController
{
    public function index(): string
    {
        $model = new PesanModel();

        return view('admin/pesan/index', [
            'title' => 'Pesan Masuk',
            'pesan' => $model->orderBy('created_at', 'DESC')->paginate(10),
            'pager' => $model->pager,
        ]);
    }

    public function delete(int $id): RedirectResponse
    {
        (new PesanModel())->delete($id);

        return redirect()->to('/admin/pesan')->with('success', 'Pesan berhasil dihapus.');
    }
}
