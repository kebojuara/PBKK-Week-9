<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

class Users extends BaseController
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index(): string
    {
        return view('admin/users/index', [
            'title' => 'Kelola User',
            'users' => $this->model->orderBy('role')->orderBy('nama')->findAll(),
        ]);
    }

    public function new(): string
    {
        return view('admin/users/form', ['title' => 'Tambah User', 'user' => null]);
    }

    public function create(): RedirectResponse
    {
        $data = $this->request->getPost(['nama', 'username', 'role']);

        if (! $this->validate(['password' => ['label' => 'Password', 'rules' => 'required|min_length[6]']])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $data['password_hash'] = password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT);

        if (! $this->model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/admin/users')->with('success', "User {$data['username']} berhasil ditambahkan.");
    }

    public function edit(int $id): string
    {
        return view('admin/users/form', ['title' => 'Edit User', 'user' => $this->cariAtau404($id)]);
    }

    public function update(int $id): RedirectResponse
    {
        $this->cariAtau404($id);
        $data     = ['id' => $id] + $this->request->getPost(['nama', 'username', 'role']);
        $password = (string) $this->request->getPost('password');

        // Admin tidak boleh menurunkan role dirinya sendiri agar tidak terkunci dari panel.
        if ($id === (int) session('user_id') && $data['role'] !== 'admin') {
            return redirect()->back()->withInput()->with('error', 'Anda tidak dapat mengubah role akun sendiri.');
        }

        if ($password !== '') {
            if (! $this->validate(['password' => ['label' => 'Password', 'rules' => 'min_length[6]']])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($id === (int) session('user_id')) {
            session()->set('nama', $data['nama']);
        }

        return redirect()->to('/admin/users')->with('success', "User {$data['username']} berhasil diperbarui.");
    }

    public function delete(int $id): RedirectResponse
    {
        $user = $this->cariAtau404($id);

        if ($id === (int) session('user_id')) {
            return redirect()->to('/admin/users')->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        $this->model->delete($id);

        return redirect()->to('/admin/users')->with('success', "User {$user['username']} berhasil dihapus.");
    }

    private function cariAtau404(int $id): array
    {
        $user = $this->model->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User tidak ditemukan.');
        }

        return $user;
    }
}
