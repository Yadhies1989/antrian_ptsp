
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

    function startWorker() {
        var w,y;
        if(typeof(Worker) !== "undefined") {
            if(typeof(w) == "undefined") {
                w = new Worker("<?= base_url() ?>assets/js/antrian.js");
            }
            w.postMessage({'link': '<?= base_url() ?>display/ambil_status'});
            w.onmessage = function(event) {
              var status=event.data;
                var urut=status.urut_loket;
                var no_loket = status.no_loket;
                var no_antrian = status.no_antrian;
                var huruf = ['E','F','G','H','I','J','K','L','M','N'];
                var nomor = huruf[urut-1]+"-"+no_antrian;
                $("#no-antrian-"+status.no_loket).html("<font style='color: white;font-size:70px'>"+nomor+"</font>");
            };

            if(typeof(y) == "undefined") {
                y = new Worker("<?= base_url() ?>assets/js/antrian.js");
            }
            y.postMessage({'link': '<?= base_url() ?>display/update_display'});
            y.onmessage = function(event) {
                var arr_status = event.data;
                $(jQuery.parseJSON(JSON.stringify(arr_status))).each(function() {
                    if(this.hasil==1) {
                        var st_pgl = this.status;
                        var suara = this.suara;

                        if(st_pgl==0) {
                            $('#modal_isi').html("<span style='font-size:50px;color:red;'><b>"+suara+"</b></span>");
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
<div id="modalpanggil" class="modal fade  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" style="display: none;right:50%;buttom:50%">
<div class="modal-dialog  modal-dialog-centered modal" >
    <div class="modal-content">
        <div class="modal-header modal-header-danger">
            <h1><i class="glyphicon glyphicon-thumbs-up"></i>SEDANG MEMANGGIL</h1>
        </div>
        <div class="modal-body">
            <div id="modal_isi"></div>
        </div>
    </div>
</div>
</div>
</body>
</html>