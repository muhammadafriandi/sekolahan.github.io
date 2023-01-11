<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Siswa.xls");

?>

<html>

<body>
    <table border="2">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">NISN</th>
                <th>NAMA</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($siswa->getResultArray() as $key => $data) : ?>
                <tr>
                    <td scope="row"><?php echo $no++; ?></td>
                    <td><?php echo $data['nisn'] ?></td>
                    <td><?php echo ucwords($data['nama']) ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>