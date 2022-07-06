<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'controllers/Ngakses.php';
class Konfig extends Ngakses
{

    function __construct()
    {
        parent::__construct();
        $this->tokencek();
        $this->load->model('m_proses', 'proses');
    }


    Public function index() {

        redirect(base_url());

    }

    public function master_loket() {
        $data['loket']=$this->proses->data_loket();
        $data['satker']=$this->proses->ambil_satker();
        $this->load->view('v_header_admin');
        $this->load->view('v_master_loket', $data);
        $this->load->view('v_footer',$data);
    }

    public function tambah_loket() {
        $no_loket=$this->input->post('no_loket');
        $jenis=$this->input->post('jenis_layanan');
        //cek_apakah berantai
        $urut_loket=$this->proses->check_loket_berantai2($no_loket,$jenis);
        //echo"urut ".$urut_loket;exit;
        $nama_layanan=$this->input->post('nama_layanan');
        $password=$this->input->post('password');
        $aktif=$this->input->post('aktif');
        $username='loket'.$no_loket;
        $password='loket'.$no_loket;
        $this->proses->tambah_loket($no_loket,$urut_loket,$nama_layanan,$username,$password,$aktif,$jenis);
    }

    public function edit_loket() {
        $no_loket=$this->input->post('no_loket');
        $urut_loket=$this->input->post('urut_loket');
        $nama_layanan=$this->input->post('nama_layanan');
        $password=$this->input->post('password');
        $jenis=$this->input->post('berantai');
        $aktif=$this->input->post('aktif');
        $username='loket'.$no_loket;
        $password='loket'.$no_loket;
        $this->proses->tambah_loket($no_loket,$urut_loket,$nama_layanan,$username,$password,$aktif,$jenis);
    }

    public function hapus_loket() {
        $no_loket=$this->input->post('noloket');
        $this->proses->hapus_loket($no_loket);
    }

    public function check_loket_berantai () {
        $layanan=$this->proses->check_loket_berantai();
        $layanan=array("layanan"=>$layanan);
        echo json_encode($layanan);
    }


    public function view_edit_ptsp() {
        $noloket=$this->input->post('noloket');
        $urutloket=$this->input->post('urut_loket');
        $jenis=$this->input->post('jenis');
        $layanan=$this->input->post('namalayanan');
        $aktif=$this->input->post('aktif');

        echo '
       <form action="#" id="form">
                    <div class="form-group">
                        <label for="jabatan" class="control-label">Nomor Loket</label>
                         <input type="text" class="form-control" id="no_loket" name="no_loket" value="'.$noloket.'" readonly>
                         <input type="hidden" name="urut_loket" value="'.$urutloket.'" readonly>
                         <input type="hidden" name="berantai" value="'.$jenis.'" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_layanan" class="control-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="'.$layanan.'" >
                    </div>
                    <div class="form-group">
                        <label for="aktif" class="control-label">aktif</label>
                        <select name="aktif" class="form-control">';
                            echo '<option value="1" '. ($aktif=="1"?"selected":"").'>Aktif</option>';
                            echo '<option value="0" '. ($aktif=="0"?"selected":"").'>Tidak</option>';
                  echo '
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">password</label>
                        <input type="text" class="form-control" id="password" name="password" value="loket'.$noloket.'" readonly>
                    </div>
                </form> ';


    }

    public function view_tambah_ptsp() {
        $noloket=$this->proses->ambil_loket_baru();
        echo '
       <form action="#" id="form">
                    <div class="form-group">
                        <label for="jabatan" class="control-label">Nomor Loket</label>
                          <input type="text" class="form-control" id="no_loket" name="no_loket" value="'.$noloket.'" readonly>
        ';
        echo     '</select>
                    </div>
                     <div class="form-group">
                        <label for="nama_layanan" class="control-label">Jenis Antrian</label>
                        <select name="jenis_layanan" id="jenis_layanan" class="form-control" onchange="getNewVal(this);" >
                         <option value="0">Mandiri</option>
                         <option value="1">Berantai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_layanan" class="control-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="aktif" class="control-label">aktif</label>
                        <select name="aktif" class="form-control">';

                        echo "<option value='1'>Aktif</option>";
                        echo "<option value='0'>Tidak</option>";
                        echo '
                        </select>
                    </div>
                     <div class="form-group">
                        <label for="password" class="control-label">password</label>
                        <input type="text" class="form-control" id="password" name="password" value="loket'.$noloket.'" readonly>
                    </div>
                </form> ';


    }



}