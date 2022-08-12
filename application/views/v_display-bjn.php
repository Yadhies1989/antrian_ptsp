<!doctype html>
<html lang="en" class="h-100">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title><?= $title; ?></title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sticky-footer-navbar/">
  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .hover {
      width: 315px;
      height: 315px;
      transition: all .3s ease-in-out;
    }
  </style>


  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@700&display=swap" rel="stylesheet">

  <!-- Favicons -->
  <meta name="theme-color" content="#7952b3">
  <!-- Custom styles for this template -->
  <link href="sticky-footer-navbar.css" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">

  <header>
    <!-- Fixed navbar -->
    <!-- <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark"> -->
    <nav class="navbar navbar-light" style="background-color: #2C6EB9 ;">

      <div class="container-fluid">
        <div class="navbar-brand">
          <table class="mr-5">
            <tr>
              <td>
                <a href="<?php echo $url_antrian_sidang_depan; ?>">
                  <img src="<?php echo base_url('assets/logo/logo-pa.png'); ?>" alt="logo-pa" width="80" height="100">
                </a>
              </td>
              <td></td>
              <td>
                <h2 class="text-white" style="font-family: quicksand;">APP ANTRIAN PTSP <br><?= $satker; ?></h2>
              </td>
            </tr>
          </table>
        </div>
        <div class="card bg-success">
          <div class="card-body">
            <marquee behavior="" direction="">
              <span class="text-white" style="font-size: 1.2em ; font-weight: bold; font-family: quicksand;"> <?= $tanggal; ?></span>
            </marquee>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <!-- Begin page content -->
  <main class="flex-shrink-0 mt-3 mb-3">
    <!-- isi -->
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
                      <h5 class="card-header text-white" style="background-color:#2C6EB9;">LOKET <?= $row->no_loket; ?></h5>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title text-center" style="color: #2C6EB9;"><?= $row->nama_layanan; ?></h5>
                      <div class="card">
                        <div class="card-body">
                          <h1 class="text-center" id="noantrian" style="color: #2C6EB9;"><?= $huruf[$row->urut_loket - 1] . "-" . $row->no_antrian; ?></h1>
                        </div>
                      </div>
                      <div class="col text-center mt-2">
                        <button class="btn cetak_antrian text-white" style="background-color:#2C6EB9;" onclick="cetak_antrian(<?= $row->urut_loket ?> ,'<?= $row->nama_layanan ?>', <?= $row->berantai ?>)">CETAK ANTRIAN</button>
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
    <!-- isi -->
  </main>

  <footer class="footer mt-auto py-3 bg-success">
    <div class="container">
      <marquee behavior="" direction="left">
        <h3 class="text-white" style="font-family: quicksand;">
          ANTRIAN SIDANG & PTSP <?= $satker; ?>
        </h3>
      </marquee>

    </div>
  </footer>


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