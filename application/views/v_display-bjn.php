<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $title; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous" />
</head>

<body class="bg-light">
  <div class="wrapper">
    <div class="container-fluid">
      <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <!-- <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap" />
          </svg>
          <span class="fs-4 text-success">
            <strong>ANTRIAN PTSP <?= $satker; ?></strong>
          </span>
        </a>

        <ul class="nav nav-pills flex">
          <marquee behavior="" direction="">
            <h4 class="text-success"><?= $tanggal; ?></h4>
          </marquee>
        </ul> -->
        <marquee behavior="" direction="">
          <h3 class="text-success">
            <p><strong>ANTRIAN PTSP <?= $satker; ?> - <?= $tanggal; ?></strong></p>
            <!-- <p></p> -->
          </h3>
        </marquee>
      </header>
    </div>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container overflow-hidden">
          <div class="row gx-4">
            <?php
            $huruf = array('E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');
            $arraywarna = array('#2C6EB9', '#9F2CB9', '#84BE49', '#107A8B', '#B92C6E', '#B96C2C');
            foreach ($data_loket->result() as $row) :
            ?>
              <div class="col-4 mx-auto">
                <div class="p-3 border bg-light">
                  <div class="card">
                    <div class="col text-center">
                      <h5 class="card-header text-white" style="background-color:<?= $arraywarna[$row->urut_loket - 1]; ?>;">LOKET <?= $row->no_loket; ?></h5>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title text-center" style="color: <?= $arraywarna[$row->urut_loket - 1]; ?>;"><?= $row->nama_layanan; ?></h5>
                      <div class="card">
                        <div class="card-body">
                          <h1 class="text-center" id="noantrian" style="color: <?= $arraywarna[$row->urut_loket - 1]; ?>;"><?= $huruf[$row->urut_loket - 1] . "-" . $row->no_antrian; ?></h1>
                        </div>
                      </div>
                      <div class="col text-center mt-2">
                        <button class="btn cetak_antrian text-white" style="background-color:<?= $arraywarna[$row->urut_loket - 1]; ?>;" onclick="cetak_antrian(<?= $row->urut_loket ?> ,'<?= $row->nama_layanan ?>', <?= $row->berantai ?>)">CETAK ANTRIAN</button>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->

    <!-- Footer -->
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script type="text/javascript">
    function cetak_antrian(a, z, y) {
      console.log(a, z, y);
      window.open('<?php echo base_url(); ?>display/cetak_antrian/' + a + '/' + z + '/' + y, '', 'width=300, height=300, menubar=no,location=no,scrollbars=yes, resizeable=no, status=no, copyhistory=no,toolbar=no');
    }

    function cetak_antrian_test() {
      window.open('<?php echo base_url(); ?>display/cetak_antrian_test', '', 'width=300, height=300, menubar=no,location=no,scrollbars=yes, resizeable=no, status=no, copyhistory=no,toolbar=no');
    }
  </script>
</body>

</html>