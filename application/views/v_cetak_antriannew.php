<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Antrian PTSP</title>
    <style type="text/css">
        @media print {
            @page {
                margin-top: 0;
                margin: 10px;
                size: 8cm 16cm;
            }

            html,
            body {
                width: 8cm;
                height: 16cm;
            }


        }
    </style>
    <script>
        function RefreshParent() {
            if (window.opener != null && !window.opener.closed) {
                window.opener.document.location.href = "<?php echo $url_antrian_sidang_depan; ?>";
                //window.opener.location.reload();
            }
        }

        function cetak() {
            window.print();
            window.onbeforeunload = RefreshParent;
            setTimeout(function() {
                window.close();
            }, 200);
        }
    </script>
</head>

<body onload="cetak()">
    <table width='350' style="font-size:40px" class="text-center">
        <tr>
            <td>
                <h4><?php echo strtoupper($nama_pa); ?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h5>ANTRIAN LAYANAN PTSP</h5>
                <h5>-------------------------------------</h5>
            </td>
        </tr>
        <tr>
            <td>
                <b style="font-size:100px ;">
                    <strong>
                        <?php echo $no_antrian; ?>
                    </strong>
                </b>
            </td>
        </tr>
        <?php
        if ($berantai == 0) {
        ?>
            <tr>
                <td>
                    <h5>-------------------------------------</h5>
                    <!-- <b style="font-size:40px">LOKET <?php echo $no_loket; ?> </b> -->
                    <h2>LOKET <?php echo $no_loket; ?></h2>
                </td>
            </tr>
        <?php
        } else {
        ?>

            <tr>
                <td>
                    <b style="font-size:30px">LOKET</b>
                </td>
            </tr>


        <?php
        }
        ?>
        <tr>
            <td>
                <h4><?php echo urldecode($nama_layanan); ?> </h4>
            </td>
        </tr>
        <tr>
            <td>
                <h5><?php echo $tanggal; ?> </h5>
            </td>
        </tr>
        <tr>
            <td>
                --------------------
            </td>
        </tr>
        <tr>
            <td style="font-size:20px">
                Mohon Menunggu!
            </td>
        </tr>
        <tr>
            <td style="font-size:20px">
                Anda Akan Dipanggil Sesuai <br>
                Nomor Urut!
            </td>
        </tr>
    </table>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>

</html>