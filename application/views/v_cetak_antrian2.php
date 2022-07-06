<html>
<head>
    <style type="text/css">
        table { 	font-family: Calibri, Helvetica, Arial, sans-serif;
            font-size: 22px;
            line-height: 110%;}
        h1 { font-family: "Arial Black","Times New Roman",serif; }

        .nomor{
            font-family: "Arial Black","Times New Roman",serif;
            font-size:125px;
            line-height: 90%;
        }
        .space
        {
            line-height: 50%
        }
        @media print
        {
            @page
            {
                margin-top:0; !important;
                margin :10px;
                size: 8cm 10cm;
            }
        }

    </style>
    <script>

        function RefreshParent() {
            if (window.opener != null && !window.opener.closed) {
                window.opener.document.location.href = 'http://192.168.2.58/ptsp/display/cetak';
            }
        }

        function cetak()
        {
            window.print();
            window.onbeforeunload = RefreshParent;
            setTimeout(function () { window.close(); }, 200);
        }


    </script>
</head>
<body onload="cetak()">
<table width='350' align='left' style="font-size:30px">
    <tr>
        <td align="center">
            <?php //echo $nama_pa; ?>
            <b><?php echo str_replace('|','<br>',strtoupper($nama_pa)); ?></b>
        </td>
    </tr>
    <tr>
        <td align="center" >
            <b style="font-size:40px">ANTRIAN PTSP TEST</b>
        </td>
    </tr>
    <tr>
        <td align="center">
            -----------------------------------------------
        </td>
    </tr>
    <tr class="nomor" height="50px">
        <td align="center">
            <p class="nomor">TEST</p>
        </td>
    </tr>
    <tr>
        <td align="center">
            -----------------------------------------------
        </td>
    </tr>
    <tr>
        <td align="center" >
            <b style="font-size:40px">LOKET TEST</b>
        </td>
    </tr>
    <tr>
        <td align="center" >
            <b style="font-size:25px">LAYANAN TEST </b>
        </td>
    </tr>
    <tr>
        <td align="center" >
            <b style="font-size:18px"><?php echo $tanggal; ?> </b>
        </td>
    </tr>
    <tr align = "center">
        <td>
            -----------------------------------------------
        </td>
    </tr>
    <tr>
        <td align="center" style="font-size:20px">
            Mohon menunggu
        </td>
    </tr>
    <tr>
        <td align="center" style="font-size:20px">
            Anda akan dipanggil sesuai nomor urut
        </td>
    </tr>
</table>
</body>
</html>