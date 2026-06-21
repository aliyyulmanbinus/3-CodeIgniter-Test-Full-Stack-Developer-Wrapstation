<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * READ - Tampilkan semua data user
     */
    public function index()
    {
        $data = [
            'title' => 'Daftar User',
            'users' => $this->userModel->orderBy('user_id', 'DESC')->findAll(),
        ];

        return view('users/index', $data);
    }

    /**
     * Tampilkan form tambah user
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah User',
        ];

        return view('users/create', $data);
    }

    /**
     * CREATE - Proses simpan data user baru
     */
    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->save([
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit user
     */
    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit User',
            'user'  => $user,
        ];

        return view('users/edit', $data);
    }

    /**
     * UPDATE - Proses update data user
     */
    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->update($id, [
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/users')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * DELETE - Hapus data user
     */
    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan.');
        }

        $this->userModel->delete($id);

        return redirect()->to('/users')->with('success', 'User berhasil dihapus.');
    }
}