<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ambil_suara extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function ambil() {
        $this->load->model('m_suara');
        //$apine=$this->input->get('kuncine');
        $apine='W3dhu56emBeL';
       //  if ($apine<>'W3dhu56emBeL') {
    //             echo json_encode(array("hasill"=>"ANDA TIDAK BERHAK AKSES !!!!"));
     //   } else {
        $hasil=$this->m_suara->ambil_suara();

        echo json_encode(array("hasil"=>$hasil));
      // }
    }

    public function update_panggilan() {
        $this->load->model('m_suara');
        $apine=$this->input->post('kuncine');
        $id=$this->input->post('id');
        if ($apine<>'W3dhu56emBeL') {
            $this->session->sess_destroy();
            redirect(base_url());
        } else {
            $pesan=$this->m_suara->update_panggilan($id);
        }
    }


}