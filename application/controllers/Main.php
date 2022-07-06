
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/Ngakses.php';

class Main extends Ngakses {


    function __construct() {
        parent::__construct();
        $this->tokencek();
        $this->load->model('m_proses','proses');
    }

    public function index()
    {
        $berantai=$this->session->userdata('berantai');
        $no_loket=$this->session->userdata('loket');
        $urut_loket=$this->session->userdata('urut_loket');
        $nama_layanan=$this->session->userdata('layanan');
        $tanggal=$this->session->userdata('tanggal');
        if($berantai==1) {
            $data['berantai']=$berantai;
            $data['no_dipanggil']=$this->proses->no_dipanggil_berantai($no_loket,$urut_loket,$tanggal);
            $data['jumlah_antrian']=$this->proses->jumlah_antrian_berantai($tanggal);
            $data['jumlah_sisa_antrian']=$this->proses->jumlah_sisa_antrian_berantai($tanggal);
            $data['no_loket']=$no_loket;
            $data['urut_loket']=$urut_loket;
            $data['layanan']=$nama_layanan;
            $data['tanggal']=$tanggal;
            $data['satker']=$this->proses->ambil_satker();
            $datas['tanggal']=$this->_tgl_indo($tanggal);
            $this->load->view('v_header',$datas);
            $this->load->view('v_operator_berantai',$data);
            $this->load->view('v_footer_operator');

        } else if ($berantai==0) {
            $data['berantai']=$berantai;
            //$data['no_dipanggil']=$this->proses->no_dipanggil($no_loket,$tanggal);
            $data['no_dipanggil']=0;
            $data['no_loket']=$no_loket;
            $data['urut_loket']=$urut_loket;
            $data['layanan']=$nama_layanan;
            $data['tanggal']=$tanggal;
            $data['jumlah_antrian']=$this->proses->jumlah_antrian($urut_loket,$tanggal);
            $data['jumlah_sisa_antrian']=$this->proses->jumlah_sisa_antrian($urut_loket,$tanggal);
            $data['satker']=$this->proses->ambil_satker();
            $datas['tanggal']=$this->_tgl_indo($tanggal);
            $this->load->view('v_header',$datas);
            $this->load->view('v_operator',$data);
            $this->load->view('v_footer_operator');
        } else {
            redirect(base_url());
        }

    }


    public function admin()
    {
        $data['satker']=$this->proses->ambil_satker();
        $this->load->view('v_header_admin');
        $this->load->view('v_admin');
        $this->load->view('v_footer',$data);
    }


    public function selesai() {
        $tgl=$this->input->post('tanggal');
        $no_loket=$this->input->post('loket');
        $no_antrian=$this->input->post('noantrian');
        $nama_layanan=$this->input->post('nama_layanan');
        $this->proses->selesai($tgl,$no_loket,$no_antrian);
    }

  public function panggil_selanjutnya() {
        $berantai=$this->session->userdata('berantai');
        $huruf=array('E','F','G','H','I','J','K','el','M','N');
        $tgl=$this->input->post('tanggal');
        $no_loket=$this->input->post('loket');
        $urut_loket=$this->input->post('urutloket');
        $nama_layanan=$this->input->post('nama_layanan');
        //cek posisi antrian sidang
           if($berantai==1) {
               $no_antrian=$this->proses->ambil_posisi_berantai($urut_loket,$no_loket,$tgl);
           } else {
               //$no_antrian=$this->input->post('noantrian');
               $no_antrian=$this->proses->ambil_posisi($urut_loket,$no_loket,$tgl);
           }
          $waktu = date('Y-m-d H:i:s');
          $suara="antrian ".$huruf[$urut_loket-1]. "  ". $no_antrian."! silahkan ke loket ".$no_loket."! layanan ".$nama_layanan."!";
          $status=0;
          if($no_antrian>0) {
              $this->proses->input_panggilan($tgl,$no_loket,$urut_loket,$no_antrian,$suara,$status,$waktu);
          }
        echo json_encode(array('no'=>$no_antrian,'no_antrian'=>$huruf[$urut_loket-1]. "-". $no_antrian,'loket'=>$no_loket));
    }


    public function panggil_ulang() {
        $huruf=array('E','F','G','H','I','J','K','el','M','N');
        $tgl=$this->input->post('tanggal');
        $no_loket=$this->input->post('loket');
        $urut_loket=$this->input->post('urutloket');
        $no_antrian=$this->input->post('noantrian');
        $nama_layanan=$this->input->post('nama_layanan');
        $berantai=$this->session->userdata('berantai');
        $waktu = date('Y-m-d H:i:s');
        $suara="antrian ".$huruf[$urut_loket-1]. "  ". $no_antrian."! silahkan ke loket ".$no_loket."! layanan ".$nama_layanan."!";
        $status=0;
        $this->proses->input_panggilan($tgl,$no_loket,$urut_loket,$no_antrian,$suara,$status,$waktu);
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

    public function ambil_suara() {
        $apine=$this->input->get('kuncine');
        if ($apine<>'W3dhu56emBeL') {
          echo json_encode(array("hasill"=>"ANDA TIDAK BERHAK AKSES !!!!"));
        } else {
        $hasil=$this->m_suara->ambil_suara();

        echo json_encode(array("hasil"=>$hasil));
        }
    }

    public function update_panggilan() {
        $apine=$this->input->post('kuncine');
        $id=$this->input->post('id');
        if ($apine<>'W3dhu56emBeL') {
            $this->session->sess_destroy();
            redirect(base_url());
        } else {
            $pesan=$this->ptsp->update_panggilan($id);
        }
    }

    public function check_status() {
        $tanggal=$this->session->userdata('tanggal');
        $loket=$this->session->userdata('ruang_sidang');
        $status=$this->proses->check_status($tanggal,$ruang);
        $data_status=array("status_panggil"=>$status);
        $this->output->set_output(json_encode($data_status));
    }


    public function display_cetak() {
        $data['data_loket']=$this->proses->data_loket_aktif();
        $data['satker']=$this->proses->ambil_satker();
        $this->load->view('v_header_display');
        $this->load->view('v_display_cetak', $data);
        $this->load->view('v_footer_display',$data);
    }

   

}
