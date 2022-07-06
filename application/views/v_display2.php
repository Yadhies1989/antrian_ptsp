<div class="row">
    <center class="col-md-12" style="background-color:#2c3e50; margin-top:20px;">
        <center><h1 style='font-family: arial;color:#ecf0f1;font-size:40px' >Antrian Pelayanan Terpadu Satu Pintu (PTSP) <?php echo ucwords(strtolower($satker)); ?></h1></center>
        <center><h1 style='font-family: arial;color:#ecf0f1;font-size:30px' ><?php echo $tanggal; ?></h1></center>
</div>

<div class="row" style="padding:40px;">
    <div class="col-lg-5">
        <div class="row">


            <?php
            foreach ($data_loket->result() as $row){
                $huruf = array('E','F','G','H','I','J','K','L','M','N');
                if($row->no_antrian<>'--') {
                    $no_antrian=$huruf[$row->urut_loket-1]."-".$row->no_antrian;
                } else {
                    $no_antrian='--';
                }
           ?>

					<div class="col-lg-6" style="margin-top:20px;">
					<div class="widget widget-stats" style="opacity:0.8;background-color:#16a085;" >
						<div style="text-align: center;">
						<a style="font-family:sanserif;font-size:30px;color:#ecf0f1;"><b>Antrian</b></a>
								<p><span class="badge badge-pill badge-danger" id="no-antrian-<?php echo $row->no_loket; ?>"><font style="color: white;font-size:70px"><?php echo $no_antrian; ?></font></span></p>
						<p><label style="font-family:sanserif;font-size:30px;color:#ecf0f1" id=""><b>LOKET <?php echo $row->no_loket; ?></b></label></p>
						</div>
							
						</div>
					</div>

            <?php
            }

            ?>

        </div>

    </div>
    <div class="col-lg-7">
        <div class="card" style="margin-top:20px; ">
            <div class="card-body" style="padding: 5px;">
                <div class="embed-responsive embed-responsive-16by9 muted autoplay loop">
                    <video controls autoplay loop>
                        <source src=""<?php echo base_url('assets/video_disabilitas.mp4');?>" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
        <div class="card" style="margin-top:20px; ">
            <div class="card-body" style="padding: 10px;">
                <marquee direction="left"><h1 style='font-family: arial;color:#FF2600; margin-top:20px;font-size:40px' class="">HARAP PATUHI PROTOCOL COVID 19 DI KANTOR PENGADILAN AGAMA</h1></marquee>
            </div>
        </div>

    </div>