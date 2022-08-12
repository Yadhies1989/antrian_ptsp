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
        <nav class="navbar" style="background-color: #047050;">
            <div class="container-fluid">
                <div>
                    <marquee behavior="" direction="">
                        <h1 class="text-white" style="font-family: quicksand;">
                            ANTRIAN PTSP <?= $satker; ?>
                        </h1>
                    </marquee>
                </div>
            </div>
            <!-- </nav> -->
    </header>

    <!-- Begin page content -->
    <main class="flex-shrink-0 mt-3">
        <div class="container-fluid">
            <div class="row align-items-start text-center">
                <div class="col-12">
                    <div class="card mb-2">
                        <h2 class="card-header text-white" style="font-family: quicksand; background-color: #047050;">
                            ANTRIAN PELAYANAN TERPADU SATU PINTU (PTSP) - <?= $tanggal; ?>
                        </h2>
                        <div class="card-body row">
                            <?php
                            foreach ($data_loket->result() as $row) {
                                $huruf = array('E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');
                                $arraywarna = array('#2C6EB9', '#9F2CB9', '#84BE49', '#107A8B', '#B92C6E', '#B96C2C');
                                if ($row->no_antrian <> '--') {
                                    $no_antrian = $huruf[$row->urut_loket - 1] . "-" . $row->no_antrian;
                                } else {
                                    $no_antrian = '--';
                                }
                            ?>
                                <div class="col-12 col-lg-6 col-xl-4 col-md-4 mx-auto" style="margin-top:20px;">
                                    <!-- <div class="widget widget-stats" style="background-color:<?= $arraywarna[$row->urut_loket - 1]; ?>;"> -->
                                    <div class="widget widget-stats" style="background-color:#2C6EB9;">
                                        <div style="text-align: center">
                                            <a style="font-family:quicksand;font-size:50px;color:#ecf0f1;">
                                                <b>
                                                    LOKET <?php echo $row->no_loket; ?>
                                                    <hr>
                                                </b>
                                            </a>
                                            <p>
                                                <span class="badge badge-pill badge-danger" style="font-family:quicksand ;" id="no-antrian-<?php echo $row->no_loket; ?>">
                                                    <font style="color: white;font-size:70px"><?php echo $no_antrian; ?></font>
                                                </span>
                                                <hr>
                                            </p>
                                            <p>
                                                <label style="font-family:quicksand;font-size:35px;color:white" id="">
                                                    <?php echo $row->nama_layanan; ?>
                                                </label>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <footer class="footer mt-auto py-3" style="background-color: #047050;">
        <div class="container">
            <marquee behavior="" direction="left">
                <h3 class="text-white" style="font-family: quicksand;">
                    <?php echo $runningteks; ?>
                </h3>
            </marquee>

        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/simplebar/js/simplebar.js"></script>
    <script src="<?php echo base_url() ?>assets/js/horizontal-menu.js"></script>
    <script src="<?php echo base_url() ?>assets/js/app-script.js"></script>
    <script>
        function startWorker() {
            var w, y;
            if (typeof(Worker) !== "undefined") {
                if (typeof(w) == "undefined") {
                    w = new Worker("<?= base_url() ?>assets/js/antrian.js");
                }
                w.postMessage({
                    'link': '<?= base_url() ?>display/ambil_status'
                });
                w.onmessage = function(event) {
                    var status = event.data;
                    var urut = status.urut_loket;
                    var no_loket = status.no_loket;
                    var no_antrian = status.no_antrian;
                    var huruf = ['E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'];
                    var nomor = huruf[urut - 1] + "-" + no_antrian;
                    $("#no-antrian-" + status.no_loket).html("<font style='color: white;font-size:70px'>" + nomor + "</font>");
                };

                if (typeof(y) == "undefined") {
                    y = new Worker("<?= base_url() ?>assets/js/antrian.js");
                }
                y.postMessage({
                    'link': '<?= base_url() ?>display/update_display'
                });
                y.onmessage = function(event) {
                    var arr_status = event.data;
                    $(jQuery.parseJSON(JSON.stringify(arr_status))).each(function() {
                        if (this.hasil == 1) {
                            var st_pgl = this.status;
                            var suara = this.suara;

                            if (st_pgl == 0) {
                                $('#modal_isi').html("<span style='font-size:50px;color:red;font-family: quicksand;text-align: center;'><b>" + suara + "</b></span>");
                                $('#modalpanggil').modal('show');
                            } else {
                                $('#modalpanggil').modal('hide');
                            }
                        } else {
                            $('#modalpanggil').modal('hide');
                        }



                    });
                };



            } else {
                alert("Maaf, silahkan menggunalan Mozilla Firefox/Chrome Terbaru");
            }
        }
        startWorker();
    </script>

</body>

<div id="modalpanggil" class="modal fade" tabindex=" -1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="display: none;right:50%;bottom:50%">
    <div class="modal-dialog modal-dialog-centered modal modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h1 style="font-family: quicksand;"><i class="glyphicon glyphicon-thumbs-up"></i>SEDANG MEMANGGIL</h1>
            </div>
            <div class="modal-body">
                <div id="modal_isi"></div>
            </div>
        </div>
    </div>
</div>

</html>