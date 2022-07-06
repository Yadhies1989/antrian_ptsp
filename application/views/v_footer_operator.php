<div class="overlay toggle-menu"></div>
</div>
</div>
<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
<footer class="footer">
    <div class="container">
        <div class="text-center">
            Copyright@2021 <?php echo ucwords(strtolower($satker)); ?>
        </div>
    </div>
</footer>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/simplebar/js/simplebar.js"></script>
<script src="<?php echo base_url() ?>assets/js/horizontal-menu.js"></script>
<script src="<?php echo base_url() ?>assets/js/app-script.js"></script>
<script>
    $(".panggil_selanjutnya").click(function() {
        var no_antrian = $('#panggilulang').attr("data-no_antrian");
        var tgl = $('#panggilulang').attr("data-tanggal");
        var no_loket = $('#panggilulang').attr("data-no_loket");
        var urut_loket = $('#panggilulang').attr("data-urut_loket");
        var layanan = $('#panggilulang').attr("data-layanan");
            $.ajax({
                url: '<?php echo base_url('main/panggil_selanjutnya'); ?>',
                type: 'post',
                dataType: 'JSON',
                data: {tanggal: tgl, loket:no_loket,urutloket:urut_loket, noantrian: no_antrian, nama_layanan: layanan},
                success: function (data) {
                    if(data.no==0) {
                        Swal.fire({
                            position: 'center',
                            icon: 'info',
                            title: 'Belum ada antrian yang baru ',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#status').html("--");
                        $('#selanjutnya').attr('data-no_antrian',0);
                        $('#panggilulang').attr('data-no_antrian',0);
                        $('#noantrian').html("--");
                        $("#panggilulang").prop('disabled', true);
                        return;
                    }
                    $("#panggilulang").prop('disabled', false);
                    $('#status').html("--Dipanggil--");
                    $('#modal_isi').html("<center><h2>Sedang memanggil Antrian <b>"+data.no_antrian+"</b><br>Jangan direfresh/tutup browser ini <br> Tunggu giliran dipanggil suara</h2></center>");
                    $('#modalpanggil').modal('show');
                    $('#selanjutnya').attr('data-no_antrian',data.no);
                    $('#panggilulang').attr('data-no_antrian',data.no);
                    $('#noantrian').html(data.no_antrian);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'error panggil antrian ptsp loket '+no_loket,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            });
    });

    $(".panggil_ulang").click(function() {
        var no_antrian = $('#panggilulang').attr("data-no_antrian");
        var tgl = $('#panggilulang').attr("data-tanggal");
        var no_loket = $('#panggilulang').attr("data-no_loket");
        var urut_loket = $('#panggilulang').attr("data-urut_loket");
        var layanan = $('#panggilulang').attr("data-layanan");
        var huruf = ['E','F','G','H','I','J','K','L','M','N'];
        var nomor = huruf[urut_loket-1]+"-"+no_antrian;
        if (no_antrian>0) {
            $.ajax({
                url: '<?php echo base_url('main/panggil_ulang'); ?>',
                type: 'post',
                data: {tanggal:tgl,loket:no_loket,urutloket:urut_loket,noantrian:no_antrian,nama_layanan:layanan},
                success: function(response){
                    $('#status').html("--Dipanggil Ulang--");
                    $('#modal_isi').html("<center><h2>Sedang memanggil Antrian <b>"+nomor+"</b><br>Jangan direfresh/tutup browser ini <br> Tunggu giliran dipanggil suara</h2></center>");
                    $('#modalpanggil').modal('show');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('error panggil sidang');
                }
            });
        } else {
            $('#status').html("--");
            Swal.fire({
                position: 'center',
                icon: 'info',
                title: 'Belum ada antrian yang baru ',
                showConfirmButton: false,
                timer: 2000
            });
        }

    });

    $(".melayani").click(function() {
        var no_antrian = $('#panggilulang').attr("data-no_antrian");
        var tgl = $('#panggilulang').attr("data-tanggal");
        var no_loket = $('#panggilulang').attr("data-no_loket");
        var urut_loket = $('#panggilulang').attr("data-urut_loket");
        var layanan = $('#panggilulang').attr("data-layanan");
            $.ajax({
                url: '<?php echo base_url('main/melayani'); ?>',
                type: 'post',
                data: {tanggal:tgl,loket:no_loket,urutloket:urut_loket,noantrian:no_antrian,nama_layanan:layanan},
                success: function(response){
                    $('#status').html("--Dipanggil Ulang--");
                    $('#modal_isi').html("<center><h2>Sedang memanggil Antrian <b>"+nomor+"</b><br>Jangan direfresh/tutup browser ini <br> Tunggu giliran dipanggil suara</h2></center>");
                    $('#modalpanggil').modal('show');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('error panggil sidang');
                }
            });
    });

    $("#refresh").click(function() {
        location.reload();
    });
    
   function startWorker() {
        if(typeof(Worker) !== "undefined") {
            if(typeof(w) == "undefined") {
                w = new Worker("<?= base_url() ?>assets/js/status.js");

            }
            w.postMessage({'link': '<?= base_url() ?>check_antrian/status'});
            w.onmessage = function(event) {
                var status=event.data;
                if(status.status_panggil==1) {
                    $('#modalpanggil').modal('hide');
                    $('#total_antrian').text(status.total_antrian);
                    $('#sisa_antrian').text(status.sisa_antrian);
                }
            };
        } else {
            alert("Sorry, your browser does not support Web Workers");
        }
    }
    startWorker();
</script>
<div id="modalpanggil" class="modal fade  tabindex=" -1 " role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="display: none; ">
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-body">
        <div id="modal_isi"></div>
    </div>
</div>
</div>

</div>

</body>
</html>