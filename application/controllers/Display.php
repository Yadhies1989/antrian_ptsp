<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Display extends CI_Controller
{

    /* public function index()
    {
        $this->load->model('m_proses','proses');
        $data['satker']=$this->proses->ambil_satker();
        $data['tanggal']=$this->_tgl_indo(date('Y-m-d'));
        $data['data_loket']=$this->proses->data_loket_aktif();
        $this->load->view('v_header_display');
        $this->load->view('v_display',$data);
        $this->load->view('v_footer_display_tv');
    } */

    public function index()
    {
        $this->load->model('m_proses', 'proses');
        $data['satker'] = $this->proses->ambil_satker();
        $data['tanggal'] = $this->_tgl_indo(date('Y-m-d'));
        $data['data_loket'] = $this->proses->data_loket_aktif();
        $this->load->view('v_header_display');
        $this->load->view('v_display', $data);
        $this->load->view('v_footer_display_tv');
    }

    public function v2()
    {
        $this->load->model('m_proses', 'proses');
        $data['satker'] = $this->proses->ambil_satker();
        $data['tanggal'] = $this->_tgl_indo(date('Y-m-d'));
        $data['data_loket'] = $this->proses->data_loket_aktif();
        $data['nama_pa'] = $this->proses->ambil_satker();
        $this->load->view('v_header_display');
        $this->load->view('v_display2', $data);
        $this->load->view('v_footer_display_tv');
    }

    public function v4()
    {
        $this->load->model('m_proses', 'proses');
        $data['title'] = 'Antrian PTSP PA BJN';
        $data['satker'] = $this->proses->ambil_satker();
        $data['tanggal'] = $this->_tgl_indo(date('Y-m-d'));
        $data['data_loket'] = $this->proses->data_loket_aktif();
        $data['nama_pa'] = $this->proses->ambil_satker();
        $data['runningteks'] = $this->proses->ambil_runningteks();
        // $this->load->view('v_header_display');
        $this->load->view('v_display3', $data);
        // $this->load->view('v_footer_display_tv');
    }


    public function cetak()
    {
        $this->load->model('m_proses', 'proses');
        $data['satker'] = $this->proses->ambil_satker();
        $data['tanggal'] = $this->_tgl_indo(date('Y-m-d'));
        $data['data_loket'] = $this->proses->data_loket_aktif_cetak();
        $data['nama_pa'] = $this->proses->ambil_satker();
        $data['title'] = "Antrian PTSP";
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';
        $url =  $protocol . $domainName;
        $data['url_antrian_sidang_depan'] = $url . $this->config->item('folder_antrian_sidang') . "/display_cetak";
        // $this->load->view('v_header_display');
        $this->load->view('v_display-bjn', $data);
        // $this->load->view('v_display_cetak', $data);
        // $this->load->view('v_footer_display');
    }

    function _tgl_indo($tanggal)
    {
        $bulan = array(
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


        $tanggal = $dayList[$day] . ', ' . $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
        return $tanggal;
    }

    public function cetak_antrian()
    {
        $huruf = array('E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N');
        $this->load->model('m_proses', 'proses');
        $no_loket = $this->uri->segment(3);
        $nama_layanan = $this->uri->segment(4);
        $berantai = $this->uri->segment(5);
        $data['nama_pa'] = $this->proses->ambil_satker();
        $tanggal = date('Y-m-d');
        //cek sudah ambil atau belum
        $info = $this->proses->info_antrian($no_loket, $tanggal)->row();
        $info_loket = $this->proses->info_loket($no_loket);
        $no_antrian = $info->no_antrian + 1;
        $data['no_antrian'] = $huruf[$no_loket - 1] . "-" . $no_antrian;
        $data['no_loket'] = $info_loket;
        $data['tanggal'] = date('d-m-Y');
        $data['nama_layanan'] = $nama_layanan;
        $data['berantai'] = $berantai;
        $tgl_diambil = date("Y-m-d H:i:s");
        $data['tgl_diambil'] = $tgl_diambil;
        $ip = $this->input->ip_address();
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'] . '/';
        $url =  $protocol . $domainName;
        $data['url_antrian_sidang_depan'] = $url . $this->config->item('folder_antrian_sidang') . "/display_cetak";
        $this->proses->insert_antrian($no_loket, $nama_layanan, $no_antrian, $tanggal, $tgl_diambil, $berantai);
        $this->load->view('v_cetak_antriannew', $data);
    }

    public function cetak_antrian_test()
    {
        $this->load->model('m_proses', 'proses');
        $data['nama_pa'] = $this->proses->ambil_satker();
        $tanggal = date('Y-m-d');
        //cek sudah ambil atau belum
        $data['tanggal'] = date('d-m-Y');
        $tgl_diambil = date("Y-m-d H:i:s");
        $data['tgl_diambil'] = $tgl_diambil;
        $this->load->view('v_cetak_antrian2', $data);
    }

    public function update_display()
    {
        $this->load->model('m_proses', 'proses');
        $data = $this->proses->get_antrian();
        $this->output->set_output(json_encode($data));
    }

    public function ambil_status()
    {
        $this->load->model('m_proses', 'proses');
        $result  = $this->proses->get_antrian_status();
        $this->output->set_output(json_encode($result));
    }
}
