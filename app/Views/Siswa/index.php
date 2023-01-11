<?php echo session()->getFlashdata('message'); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data Siswa</h1>

    <div class="swal" data-swal="<?php echo session()->get('message'); ?>"></div>

    <div class="row">
        <div class="col-md-8">
            <?php
            if (session()->get('err')) {
                echo "<div class='alert alert-danger' role='alert'>" . session()->get('err') . "</div>";
            }
            ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md">
                    <button type="button" class="btn btn-primary shadow btn-sm" data-toggle="modal" data-target="#modalTambah">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                    <button onclick="window.print()" type="button" class="btn btn-primary shadow btn-sm">
                        <i class="fa-solid fa-print"></i> Print
                    </button>
                </div>
                <div class="col-md">
                    <button type="button" class="btn btn-success btn-sm shadow float-right">
                        <i class="fa-sharp fa-solid fa-arrow-up-from-bracket"></i> Upload
                    </button>
                    <a href="<?php echo base_url('/siswa/excel') ?>" class="btn btn-success btn-sm shadow float-right mr-1">
                        <i class="fas fa-regular fa-download"></i> Download
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>NAMA</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php foreach ($siswa->getResultArray() as $key => $data) : ?>
                        <tr>
                            <td scope="row"><?php echo $no++; ?></td>
                            <td><?php echo $data['nisn'] ?></td>
                            <td><?php echo ucwords($data['nama']) ?></td>
                            <td>
                                <button type="button" data-toggle="modal" data-target="#modalUbah<?php echo $data['id']; ?>" class="btn btn-sm btn-warning" id="btn-edit" href=""><i class="fa fa-edit"></i></button>
                                <!-- <button type="button" data-toggle="modal" data-target="#modalHapus" class="btn btn-sm btn-danger"><i class="fa fa-trash-alt"></i></button> -->
                                <a href="/siswa/hapus/<?php echo $data['id']; ?>" class="btn btn-sm btn-danger btn-hapus"><i class="fa fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah <?php echo $judul; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('siswa/tambah'); ?>" method="post">
                    <div class="form-group mb-0">
                        <label for="nisn">NISN</label>
                        <input type="text" name="nisn" id="nisn" class="form-control" placeholder="Masukkan NISN">
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="tambah" class="btn btn-primary">Tambah Data</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- modal Update data siswa -->
<?php foreach ($siswa->getResultArray() as $key => $data) : ?>
    <div class="modal fade" id="modalUbah<?php echo $data['id']; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url('siswa/ubah'); ?>" method="POST">
                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                        <div class="form-group mb-0">
                            <label for="nisn"></label>
                            <input type="text" name="nisn" id="nisn" class="form-control" value="<?php echo $data['nisn']; ?>">
                        </div>
                        <div class="form-group mb-0">
                            <label for="nam"></label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $data['nama']; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="ubah" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>