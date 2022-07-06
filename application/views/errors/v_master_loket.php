<h6 class="text-uppercase">MASTER LOKET DAN PASSWORD</h6>
<hr>
<div class="row">
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <div class="pull-right"><button type="button" class="btn btn-danger" onclick="tambah()"><i class="fa fa-plus-circle"></i>Tambah</button></div>
            </div>
            <div class="card-body" align="center">
                <div class="card-title" > Master
                </div>
                <table id="data-tabel" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Nomor Loket</th>
                        <th>Nama Layanan </th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($pegawai->num_rows() > 0) {
                        $no=1;
                        foreach ($pegawai->result() as $row) {

                            echo "<tr>";
                            echo "<td>$row->nama</td>";
                            echo "<td>$row->jabatan</td>";
                            echo "<td>$row->nomorhp</td>";
                            echo "<td align='center'><button type='button' class='btn btn-info edit' nama='".$row->nama."' jabatan='".$row->jabatan."' idsipp=$row->idsipp nohp='".$row->nomorhp."' id='tb".$no++."'>Edit</button> <button type='button' class='btn btn-info hapus'  nama='".$row->nama."' jabatan='".$row->jabatan."' idsipp=$row->idsipp id='tb".$no++."' >Hapus</button></td>";
                            echo "</tr>";
                        }


                    } else {

                        echo "<tr>";
                        echo "<td>-</td>";
                        echo "<td>-</td>";
                        echo "<td>-</td>";
                        echo "<td>-</td>";
                        echo "</tr>";


                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Nomor Loket</th>
                        <th>Nama Layanan </th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>aksi</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>