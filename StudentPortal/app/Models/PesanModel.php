<?php

namespace App\Models;

use CodeIgniter\Model;

class PesanModel extends Model
{
    protected $table         = 'pesan';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nama', 'email', 'subjek', 'isi'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'nama'   => ['label' => 'Nama', 'rules' => 'required|min_length[3]|max_length[100]'],
        'email'  => ['label' => 'Email', 'rules' => 'required|valid_email|max_length[100]'],
        'subjek' => ['label' => 'Subjek', 'rules' => 'required|min_length[3]|max_length[150]'],
        'isi'    => ['label' => 'Pesan', 'rules' => 'required|min_length[10]|max_length[2000]'],
    ];
}
