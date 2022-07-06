<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/Ngakses.php';

class Utama extends Ngakses {


    function __construct() {
        parent::__construct();
        $this->tokencek();
    }

    public function index()
    {
        $this->load->model('m_proses','proses');
        $data['satker']=$this->proses->ambil_satker();
        $this->load->view('v_header');
        $this->load->view('v_operator');
        $this->load->view('v_footer',$data);
    }

    public function panggil() {
        $huruf=array('E','F','G','H','I','J','K','el','M','N');
        $tgl=$this->input->post('tgl');
        $loket=$this->input->post('loket');
        $no_antrian=$this->input->post('no');
        $noperk=$this->sidang->ambil_noperk($tgl,$loket,$no_antrian);
        $suara="antrian#".$huruf[$ruang-1]."-".$no_antrian."#ke loket#".$ruang;
        $waktu = date('Y-m-d H:i:s');
        $status=4;
        $st_panggil = 0;
        $this->sidang->input_panggilan($tgl);
    }

    public function lewati() {
        $tgl=$this->input->post('tglsidang');
        $loket=$this->input->post('loket');
        $no_antrian=$this->input->post('no');
        $this->sidang->lewati($tgl_sidang,$loket,$no_antrian);
    }

    function _tgl_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        $tanggal='Hari '.$dayList[$day].' '.$pecahkan[2].' '.$bulan[ (int)$pecahkan[1] ].' '.$pecahkan[0];
        return $tanggal;
    }


}
