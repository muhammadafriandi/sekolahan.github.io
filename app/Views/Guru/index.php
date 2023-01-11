<?php echo session()->getFlashdata('message'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $judul; ?></h1>

    <div class="swal" data-swal="<?= session()->get('message'); ?>"></div>

    <div class="row">
        <div class="col-md-8">
            <?php
            if (session()->get('err')) {
                echo "<div class='alert alert-danger p-0 pt-2' role='alert'>" . session()->get('err') . "</div>";
            }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-sm btn-primary mb-2" data-toggle="modal" data-target="#modalTambah">
                <i class="fa fa-plus"></i> Tambah Data
            </button>
        </div>
        <div class="col-md-3">
            <?php echo $pager->links('halaman', 'bootstrap_pagination') ?>
        </div>
        <form action="" method="post">
            <div class="input-group col-md">
                <input type="text" class="form-control" name="cari" placeholder="Masukkan Pencarian . . . ">
                <button type="submit" class="btn btn-sm btn-primary" name="submit"><i class="fas fa-duotone fa-magnifying-glass"></i></button>
            </div>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>NIP</th>
                <th>NAMA</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($guru)) : ?>
                <?php $i = 1 + (10 * ($currentPage - 1)); ?>
                <?php foreach ($guru as $key => $data) : ?>
                    <tr>
                        <td scope="row"><?= $i++; ?></td>
                        <td><img width="70" height="70" src="<?= '/assets/img/profile/' . $data['gambar']; ?>" class="rounded"></td>
                        <td><?= $data['nip']; ?></td>
                        <td><?= $data['nama']; ?></td>
                        <td>
                            <button type="button" data-toggle="modal" data-target="#modalUbah" id="btn-edit" class="btn btn-sm btn-warning" data-id="<?= $data['id']; ?>" data-nip="<?= $data['nip']; ?>" data-nama="<?= $data['nama']; ?>"> <i class="fa fa-edit"></i> </button>
                            <a href="/guru/hapus/<?= $data['id']; ?>" class="btn btn-sm btn-danger btn-hapus"> <i class="fa fa-trash-alt"></i> </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <td colspan="5">
                    <h3 class="text-gray-500 text-center">Data Tidak Ada</h3>
                </td>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Box Tambah Data Guru -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah <?= $judul; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('guru/tambah'); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group mb-2">
                        <input type="text" name="nip" id="nip" class="form-control" placeholder="Masukkan nip">
                    </div>
                    <div class="form-group mb-2">
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama guru">
                    </div>
                    <div class="form-group mb-2">
                        <input type="file" name="gambar" class="dropify" data-height="100">
                        <label for="">File Max 1 Mb</label>
                    </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="tambah" class="btn btn-primary">Tambah Data</button>
            </div>
            </form>
        </div>
    </div>
</div>