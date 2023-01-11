<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\M_Guru;
use CodeIgniter\HTTP\Files\UploadedFile;

class Guru extends Controller
{
    public function __construct()
    {
        $this->model = new M_Guru;

        $this->session = service('session');
        $this->auth = service('authentication');
        $this->pager = \Config\Services::pager();
    }

    public function index()
    {
        // pengecekan jika belum login
        if (!$this->auth->check()) {
            $redirectURL = session('redirect_url') ?? '/login';
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }
        //mendapatkan halaman dan untuk ngitung nomor di tabel
        $currentPage = $this->request->getVar('page_halaman') ? $this->request->getVar('page_halaman') : 1;

        //pencarian
        $cari = $this->request->getVar('cari');
        if ($cari) {
            $hasil = $this->model->search($cari);
        } else {
            $hasil = $this->model;
        }

        $data = [
            'judul' => 'Data Guru',
            // 'guru' => $this->model->getAllData()
            'guru' => $this->model->paginate('10', 'halaman'),
            'pager' => $this->model->pager,
            'currentPage' => $currentPage
        ];
        // load view
        echo view('templates/v_header', $data);
        echo view('templates/v_sidebar');
        echo view('templates/v_topbar');
        echo view('guru/index', $data);
        echo view('templates/v_footer');
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
                'nip' => [
                    'label' => 'Nomor Induk Siswa Nasional',
                    'rules' => 'required|numeric|max_length[12]|is_unique[guru.nip]'
                ],
                'nama' => [
                    'label' => 'Nama Siswa',
                    'rules' => 'required'
                ],
                'gambar' => [
                    'uploaded[gambar]',
                    'mime_in[gambar,image/jpg,image/png,image/jpeg]',
                    'max_size[gambar, 1024]'
                ]
            ]);

            if (!$val) {
                session()->setFlashdata('err', \Config\Services::validation()->listErrors());

                $data = [
                    'judul' => 'Data Guru',
                    'guru' => $this->model->getAllData()
                ];

                echo view('templates/v_header', $data);
                echo view('templates/v_sidebar');
                echo view('templates/v_topbar');
                echo view('guru/index', $data);
                echo view('templates/v_footer');
            } else {
                $file = $this->request->getFile('gambar');
                $nama = $file->getRandomName();
                $file->move('./assets/img/profile', $nama);
                $data = [
                    'gambar' => $nama,
                    'nip' => $this->request->getPost('nip'),
                    'nama' => $this->request->getPost('nama')
                ];
                //insert data
                $success = $this->model->tambah($data);
                if ($success) {
                    session()->setFlashdata('message', 'Ditambahkan');
                    return redirect()->to('/guru');
                }
            }
        }
        return redirect()->to(site_url('/guru'));
    }

    public function hapus($id)
    {
        if (!$this->auth->check()) {
            $redirectURL = session('redirect_url') ?? site_url('/login');
            unset($_SESSION['redirect_url']);

            return redirect()->to($redirectURL);
        }

        // (cara 1 gambar default juga akan ke hapus)

        // cari gambar berdasarkan id
        // $data = $this->model->getAllData($id);
        // $this->model->hapus($id);
        //menghapus gambar
        // unlink('./assets/img/profile/' . $data['gambar']);
        //menghapus data di dalam model
        // -----------------------------------------------------------------------------------------------------------

        // (cara2 tidak menghapus gambar default)
        $data = [
            'guru' => $this->model->getAllData($id)
        ];

        //menghapus data di dalam model
        $this->model->hapus($id);

        //menghapus gambar
        $img = $data['guru']['gambar'];
        if ($img != 'deafault.png') {
            unlink(FCPATH . './assets/img/profile/' . $img);
        }



        session()->setFlashdata('message', 'Dihapus');
        return redirect()->to('/guru');
    }
}
