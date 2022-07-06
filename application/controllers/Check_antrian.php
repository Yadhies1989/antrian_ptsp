<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_antrian extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        // $this->tokencek();
        $this->load->model('m_proses', 'proses');

    }

    public function index() {
        //cek julah ruangan antrian
        $data['jumlah_ruang']=$this->proses->data_ruang();
        $data['posisi_antrian']=$this->proses->posisi_antrian();
        echo json_encode($data);
    }

    public function status() {
        $tanggal=$this->session->userdata('tanggal');
        $no_loket=$this->session->userdata('loket');
        $urut_loket=$this->session->userdata('urut_loket');
        $berantai=$this->session->userdata('berantai');
        $status=$this->proses->check_status($tanggal,$no_loket,$urut_loket,$berantai);
        //$data_status=array("status_panggil"=>$status);
        $this->output->set_output(json_encode($status));
    }


} 