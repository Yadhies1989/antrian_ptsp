<h6 class="text-uppercase">MASTER LOKET</h6>
<hr>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="pull-right"><button type="button" class="btn btn-danger" onclick="tambah()"><i class="fa fa-plus-circle"></i>Tambah</button></div>
            </div>
            <div class="card-body" align="center">
                <table id="data-tabel" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nomor Loket</th>
                            <th>Nama Layanan </th>
                            <th>Username</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($loket->num_rows() > 0) {
                            $no = 1;
                            foreach ($loket->result() as $row) {

                                echo "<tr>";
                                echo "<td>$row->no_loket</td>";
                                echo "<td>$row->nama_layanan</td>";
                                echo "<td>$row->username</td>";
                                echo "<td>" . ($row->berantai ? 'Berantai' : 'Mandiri') . "</td>";
                                $status = ($row->aktif == 1) ? 'Aktif' : 'Tidak Aktif';
                                echo "<td>$status</td>";
                                echo "<td align='center'><button type='button' class='btn btn-info edit' data-noloket=$row->no_loket data-urut_loket=$row->urut_loket data-berantai=$row->berantai data-layanan='" . $row->nama_layanan . "' data-aktif='" . $row->aktif . "'>Edit</button> <button type='button' class='btn btn-info hapus' data-noloket=$row->no_loket>Hapus</button></td>";
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
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>