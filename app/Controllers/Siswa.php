<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\M_siswa;

class Siswa extends Controller
{
    public function __construct()
    {
        $this->model = new M_siswa;
        $this->session = service('session');
        $this->auth   = service('authentication');
    }

    public function index()
    {
        if (!$this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/login');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

        $data = [
            'judul' => 'Data Siswa',
            'siswa' => $this->model->getAllData(),
        ];
        echo view('templates/v_header', $data);
        echo view('templates/v_sidebar', $data);
        echo view('templates/v_topbar', $data);
        echo view('siswa/index', $data);
        echo view('templates/v_footer', $data);
    }

    public function tambah()
    {
        if (!$this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/login');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

        if (isset($_POST['tambah'])) {
            $val = $this->validate([
                'nisn' => [
                    'label' => 'Nomor Induk Siswa Nasional',
                    'rules' => 'required|numeric|max_length[12]|is_unique[siswa.nisn]'
                ],
                'nama' => [
                    'label' => 'Nama Siswa',
                    'rules' => 'required'
                ]
            ]);

            if (!$val) {
                session()->setFlashdata('err', \Config\Services::validation()->listErrors());

                $data = [
                    'judul' => 'Data Siswa',
                    'siswa' => $this->model->getAllData()
                ];

                echo view('templates/v_header', $data);
                echo view('templates/v_sidebar');
                echo view('templates/v_topbar');
                echo view('siswa/index', $data);
                echo view('templates/v_footer');
            } else {
                $data = [
                    'nisn' => $this->request->getPost('nisn'),
                    'nama' => $this->request->getPost('nama')
                ];
                //insert data
                $success = $this->model->tambah($data);
                if ($success) {
                    session()->setFlashdata('message', 'Ditambahkan');
                    return redirect()->to('/siswa');
                }
            }
        }
        return redirect()->to(site_url('/siswa'));
    }

    public function hapus($id)
    {
        if (!$this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/login');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

        $success = $this->model->hapus($id);
        if ($success) {
            session()->setFlashdata('message', 'Dihapus');
            return redirect()->to('/siswa');
        }
    }

    public function ubah()
    {
        if (!$this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/login');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

        if (isset($_POST['ubah'])) {
            $id = $this->request->getPost('id');
            $data = [
                'nisn' => $this->request->getPost('nisn'),
                'nama' => $this->request->getPost('nama')
            ];

            //Update data
            $success = $this->model->ubah($data, $id);
            if ($success) {
                session()->setFlashdata('message', 'Di Update');
                return redirect()->to('/siswa');
            }

            return redirect()->to('/siswa');
        }
    }

    public function excel()
    {
        $data = [
            'siswa' => $this->model->getAllData()
        ];

        echo view('siswa/excel', $data);
    }
}
