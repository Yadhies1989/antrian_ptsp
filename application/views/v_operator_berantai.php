<h6 class="text-uppercase"><b>Loket <?php echo $no_loket ?> Layanan <?php echo $layanan; ?></b></h6>
<hr>
<div class="row">
    <div class="col-12 col-lg-2">
        <div class="card">
            <div class="card-body" align="center">
                <div class="card-title">Antrian<br>
                </div>
                <?php
                $huruf = array('E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');
                if ($no_dipanggil == 0) {
                    $no_antrian = '-';
                } else {
                    $no_antrian = $huruf[$urut_loket - 1] . '-' . $no_dipanggil;
                }

                ?>
                <font size='60px' style='color: orange;'><span class='badge badge-pill badge-success' id='noantrian'><?php echo $no_antrian; ?></span></font>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-2">
        <div class="card">
            <div class="card-body" align="center">
                <div class="card-title">Status<br>
                    <font size='20px' style='color: orange;font-size:20px'><span id='status'><?php echo ($no_dipanggil > 0 ? "-- Belum dipanggil --" : "--"); ?></span></font>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-body" align="center">
                <div class="card-title">Aksi
                </div>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type='button' class='btn btn-danger  btn-xs waves-effect waves-light m-1 panggil_selanjutnya' id="selanjutnya" data-no_antrian=<?php echo $no_dipanggil; ?> data-no_loket=<?php echo $no_loket; ?> data-urut_loket=<?php echo $urut_loket; ?> data-layanan="<?php echo $layanan; ?>" data-tanggal="<?php echo $tanggal; ?>">Panggil Antrian Selanjutnya</button>
                    <button type='button' class='btn btn-primary btn-xs waves-effect waves-light m-1 panggil_ulang' id="panggilulang" data-no_antrian=<?php echo $no_dipanggil; ?> data-no_loket=<?php echo $no_loket; ?> data-urut_loket=<?php echo $urut_loket; ?> data-layanan="<?php echo $layanan; ?>" data-tanggal="<?php echo $tanggal; ?>">Panggil Ulang</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-2">
        <div class="card">
            <div class="card-body" align="center">
                <div class="card-title">Total Antrian
                </div>
                <font size='60px' style='color: orange;'><span class='badge badge-pill badge-info' id='total_antrian'><?php echo $jumlah_antrian; ?></span></font>";
            </div>
        </div>

    </div>
    <div class="col-12 col-lg-2">
        <div class="card">
            <div class="card-body" align="center">
                <div class="card-title">Sisa Antrian
                </div>
                <font size='60px' style='color: orange;'><span class='badge badge-pill badge-success' id='sisa_antrian'><?php echo (($jumlah_sisa_antrian) >= 0 ? $jumlah_sisa_antrian : "0"); ?></span></font>";
            </div>
        </div>

    </div>
</div>