<div class="row">
    <center class="col-md-12" style="background-color:#2c3e50; margin-top:80px;">
        <center>
            <h1 style='font-family: arial;color:#ecf0f1;font-size:40px'>Antrian Pelayanan Terpadu Satu Pintu <a href="#" onclick="cetak_antrian_test();">(PTSP)</a> <br><?php echo ucwords(strtolower($satker)); ?></h1>
        </center>
        <center>
            <h1 style='font-family: arial;color:#ecf0f1;font-size:30px'><?php echo $tanggal; ?></h1>
        </center>
</div>

<div class="row" style="padding:30px;">
    <div class="col-lg-12">
        <div class="row">
            <?php
            $huruf = array('E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');
            foreach ($data_loket->result() as $row) {
                echo "
					<div class='col-12 col-lg-6 col-xl-3 col-xl-4 mx-auto'>
                         <div class='card gradient-ohhappiness'>
                           <div class='card-body'>
                              <h3 class='text-white mb-0'><center>LOKET $row->no_loket</center></h3>
                              <h5 class='mb-0 text-white'><center>$row->nama_layanan</center></h5>
                               <center><font size='60px' style='color: orange;'><span class='badge badge-pill badge-info' id='noantrian'>" . $huruf[$row->urut_loket - 1] . '-' . $row->no_antrian . "</span></font></center>
                              <center><button type='button' class='btn btn-danger btn-round waves-effect waves-light m-1 cetak_antrian' onclick=\"cetak_antrian($row->urut_loket,'$row->nama_layanan',$row->berantai);\">Cetak Antrian</button></center>
                            </div>
                         </div> 
                       </div>
					";
            }
            ?>
        </div>

    </div>
</div>
<script type="text/javascript">
    function cetak_antrian(a, z, y) {
        window.open('<?php echo base_url(); ?>display/cetak_antrian/' + a + '/' + z + '/' + y, '', 'width=300, height=300, menubar=no,location=no,scrollbars=yes, resizeable=no, status=no, copyhistory=no,toolbar=no');
    }


    function cetak_antrian_test() {
        window.open('<?php echo base_url(); ?>display/cetak_antrian_test', '', 'width=300, height=300, menubar=no,location=no,scrollbars=yes, resizeable=no, status=no, copyhistory=no,toolbar=no');
    }
</script>