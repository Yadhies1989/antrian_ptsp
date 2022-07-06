<div class="overlay toggle-menu"></div>
<!--end overlay-->
</div>
<!-- End container-fluid-->
</div><!--End content-wrapper-->

<!--Start Back To Top Button-->
<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
<!--End Back To Top Button-->

<!--Start footer-->
<footer class="footer">
    <div class="container">
        <div class="text-center">
            Copyright © 2019 Dashtreme Admin
        </div>
    </div>
</footer>
<!--End footer-->
</div><!--End wrapper-->
<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/simplebar/js/simplebar.js"></script>
<script src="<?php echo base_url() ?>assets/js/horizontal-menu.js"></script>
<script src="<?php echo base_url() ?>assets/js/app-script.js"></script>
<script>
    $(".panggil").click(function() {
        var no_antrian = $(this).data("no_antrian");
        var tanggal = $(this).data("tanggal");
        var no_loket = $(this).data("no_loket");
        var huruf = ['E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U'];
        var nomor = huruf[ruang-1]+"-"+no_antrian;
        $.ajax({
            url: '<?php echo base_url('main/panggil'); ?>',
            type: 'post',
            data: {tglsidang:tglsidang,ruang:ruang,no:no_antrian},
            success: function(response){
                if(dilewat==1) {
                    $("#status2-"+ruang).text("**DIPANGGIL**");
                } else {
                    $("#status-"+ruang).text("**DIPANGGIL**");
                }
                $('#modal_isi').html("<h2>Sedang memanggil<br>Antrian <b>"+nomor+"</b> nomor perkara <b>"+noperk+"</b></h2>");
                $('#modalpanggil').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('error panggil sidang');
            }
        });
    });

    $(".selesai").click(function() {
        var no_antrian = $(this).data("no_antrian");
        var tanggal = $(this).data("tanggal");
        var no_loket = $(this).data("no_loket");
                $.ajax({
                    url: '<?php echo base_url('utama/selesi'); ?>',
                    type: 'post',
                    data: {tglsidang:tglsidang,ruang:ruang,no:no_antrian},
                    success: function(response){
                        location.reload();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('error lewati antrian sidang');
                    }
                });

        })
    });

    function startWorker() {
        if(typeof(Worker) !== "undefined") {
            if(typeof(w) == "undefined") {
                w = new Worker("<?= base_url() ?>assets/js/__status.js");

            }
            w.postMessage({'link': '<?= base_url() ?>main/check_status'});
            w.onmessage = function(event) {
                var status=event.data;
                if(status.status_panggil==1) {
                    $('#modalpanggil').modal('hide');
                }
            };
        } else {
            alert("Sorry, your browser does not support Web Workers");
        }
    }

    startWorker();
</script>
<div id="modalku" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" id='tutup' class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                <button type="button" id='simpan' class="btn btn-danger waves-effect waves-light" onclick="simpan()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="modalpanggil" class="modal fade  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="display: none; ">
<div class="modal-dialog modal-xl"">
<div class="modal-content">
    <div class="modal-body">
        <div id="modal_isi"></div>
    </div>
</div>
</div>

</div>
    </body>
    </html>