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
            Copyright@2021 <?php echo ucwords(strtolower($satker)); ?>
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
    $(document).ready(function(){

    });
    function getNewVal(item)
    {
        if(item.value=="1") {
            $.ajax({
                url: '<?php echo base_url('konfig/check_loket_berantai'); ?>',
                type: 'get',
                dataType: 'JSON',
                success: function(data){
                      if(data.layanan=="0") {
                          Swal.fire({
                              icon: 'Info',
                              text: 'Nama layanan yang akan diisi dibawah ini akan jadi nama master loket berantai',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'OK'
                          })
                      } else {
                          $('#nama_layanan').val(data.layanan);
                          $("#nama_layanan").prop("readonly", true);

                      }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    Swal.fire({
                        icon: 'error',
                        text: 'error pilih  jenis layanan',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    })
                }
            });

        } else {
            $("#nama_layanan").prop("readonly", false);
            $("#nama_layanan").val('');
        }
    }

var status='';
    function tambah()
    {
        status='tambah';

        $.ajax({
            url: '<?php echo base_url('konfig/view_tambah_ptsp'); ?>',
            type: 'post',
            success: function(response){
                $('.modal-body').html(response);
                $('#modalku').modal('show');
                $('.modal-title').text('Tambah Loket Layanan');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error tambah / update data');
            }
        });
    }

    $(".edit").click(function() {
        status='edit';
        var no_loket = $(this).data('noloket');
        var urutloket = $(this).data('urut_loket');
        var berantai = $(this).data('berantai');
        var layanan = $(this).data('layanan');
        var aktif_loket = $(this).data('aktif');
        $.ajax({
            url: '<?php echo base_url('konfig/view_edit_ptsp'); ?>',
            type: 'post',
            data: {noloket:no_loket,urut_loket:urutloket,jenis:berantai,namalayanan:layanan,aktif:aktif_loket},
            success: function(response){
                $('.modal-body').html(response);
                $('.modal-title').text('Edit Loket');
                $('#modalku').modal('show');
                $('#nama_layanan').focus();
            }
        });
    });

    $(".hapus").click(function() {
        var no_loket = $(this).data('noloket');
        swal.fire({
            title: 'Konfirmasi',
            text: 'Yakin akan menghapus loket '+no_loket,
            type: 'warning',
            buttons: true,
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Hapus!",
            closeOnConfirm: false
        }).then(function(yes) {
            if (yes) {
                $.ajax({
                    url: '<?php echo base_url('konfig/hapus_loket'); ?>',
                    type: 'POST',
                    data: {'noloket':no_loket},
                    success: function (data) {
                        location.reload();
                    }
                });
            }
            else {
                return false;
            }
        });
    });



    function simpan()
    {

        if($('#nama_layanan').val()==''){
            Swal.fire({
                icon: 'error',
                text: 'Nama layanan tidak boleh kosong',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK'
            })
            return;
        }
        var url;
        if(status == 'tambah')
        {
            url = "<?php echo base_url('konfig/tambah_loket'); ?>";
        }
        else if (status == 'edit')
        {
            url = "<?php echo base_url('konfig/edit_loket'); ?>";
        }

        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            success: function(data)
            {
                $('#modalku').modal('hide');
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Data telah tersimpan/teredit',
                    showConfirmButton: false,
                    timer: 1500
                })
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert("Status: " + textStatus); alert("Error: " + errorThrown);
            }
        });
    }
</script>
<div id="modalku" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Loket Layanan PTSP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="simpan()" >Simpan</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>