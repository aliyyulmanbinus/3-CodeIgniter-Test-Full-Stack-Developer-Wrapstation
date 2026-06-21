<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Nama tabel yang dipakai model ini
    protected $table = 'users';

    // Primary key tabel (bukan default 'id', jadi wajib disebutkan eksplisit)
    protected $primaryKey = 'user_id';

    // Tipe return default saat query (array asosiatif, bukan object)
    protected $returnType = 'array';

    // Kolom mana saja yang BOLEH diisi lewat insert()/update() massal
    // Ini proteksi keamanan dasar (mass assignment protection)
    protected $allowedFields = ['name'];

    // Otomatis isi created_at & updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi sebelum data disimpan ke database
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[150]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
            'max_length' => 'Nama maksimal 150 karakter.',
        ],
    ];
}