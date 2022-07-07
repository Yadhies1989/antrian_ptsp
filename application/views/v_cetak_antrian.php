<html>

<head>
    <style type="text/css">
        table {
            font-family: Calibri, Helvetica, Arial, sans-serif;
            font-size: 40px;
            line-height: 110%;
        }

        h1 {
            font-family: "Arial Black", "Times New Roman", serif;
        }

        .nomor {
            font-family: "Arial Black", "Times New Roman", serif;
            font-size: 125px;
            line-height: 90%;
        }

        .space {
            line-height: 50%
        }

        @media print {
            @page {
                margin-top: 0;
                 !important;
                margin: 10px;
                size: 8cm 10cm;
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
    <table width='350' align='left' style="font-size:40px">
        <tr>
            <td align="center">
                <b><?php echo strtoupper($nama_pa); ?></b>
            </td>
        </tr>
        <tr>
            <td align="center">
                <b style="font-size:40px">ANTRIAN LAYANAN TERPADU</b>
            </td>
        </tr>
        <tr>
            <td align="center">
                -----------------------------------------------
            </td>
        </tr>
        <tr class="nomor" height="50px">
            <td align="center">
                <p class="nomor"><?php echo $no_antrian; ?></p>
            </td>
        </tr>
        <tr>
            <td align="center">
                -----------------------------------------------
            </td>
        </tr>
        <?php
        if ($berantai == 0) {
        ?>
            <tr>
                <td align="center">
                    <b style="font-size:50px">LOKET <?php echo $no_loket; ?> </b>
                </td>
            </tr>
        <?php
        } else {
        ?>

            <tr>
                <td align="center">
                    <b style="font-size:50px">LOKET</b>
                </td>
            </tr>


        <?php
        }
        ?>
        <tr>
            <td align="center">
                <b style="font-size:40px"><?php echo urldecode($nama_layanan); ?> </b>
            </td>
        </tr>
        <tr>
            <td align="center">
                <b style="font-size:30px"><?php echo $tanggal; ?> </b>
            </td>
        </tr>
        <tr align="center">
            <td>
                -----------------------------------------------
            </td>
        </tr>
        <tr>
            <td align="center" style="font-size:30px">
                Mohon menunggu
            </td>
        </tr>
        <tr>
            <td align="center" style="font-size:30px">
                Anda akan dipanggil sesuai nomor urut
            </td>
        </tr>
        <tr>
            <td align="center" style="font-size:30px">
                Dalam Masa Pandemi, Dimohon untuk mematuhi Protocol COVID 19, Selalu menggunakan Masker dan cuci tangan sebelum masuk ke Kantor Pengadilan Agama
            </td>
        </tr>
    </table>
</body>

</html>