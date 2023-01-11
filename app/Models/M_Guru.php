<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Guru extends Model
{
    protected $table = 'guru';

    // public function __construct()
    // {
    //     $this->db = db_connect();
    //     $this->builder = $this->db->table($this->table);
    // }

    public function getAllData($id = false)
    {
        if ($id == false) {
            return $this->table('guru')->get()->getResultArray();
        } else {
            $this->table('guru')->where('id', $id);
            return $this->table('guru')->get()->getRowArray();
        }
    }

    public function tambah($data)
    {
        return $this->table('guru')->insert($data);
    }

    public function hapus($id)
    {
        return $this->table('guru')->delete(['id' => $id]);
    }

    public function ubah($data, $id)
    {
        return $this->table('guru')->update($data, ['id' => $id]);
    }

    public function search($cari)
    {
        // (cara1)
        // $builder = $this->table('guru');
        // $builder->like('nama', $cari);
        // return $builder;

        // (cara 2)
        return $this->table('guru')->like('nama', $cari);
    }
}
