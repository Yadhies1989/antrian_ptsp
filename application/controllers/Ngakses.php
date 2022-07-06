<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/JWT.php';
require APPPATH . '/libraries/BeforeValidException.php';
require APPPATH . '/libraries/ExpiredException.php';
require APPPATH . '/libraries/SignatureInvalidException.php';
use \Firebase\JWT\JWT;

class Ngakses extends CI_Controller {

    private $secretkey = '';

    function __construct() {
        parent::__construct();
        $this->secretkey=base64_decode(($this->config->item('jwt_key')));
        $this->load->model('m_akses','ptsp');
    }


    public function index() {
        redirect(base_url());
    }


    //method untuk melihat token pada user
    public function validasiuser(){
        $loket=$this->input->post('username',true);
        $pass=$this->input->post('password',true);
            if ($loket=='admin' and $pass=='Jempol') {
                $data['idtoken'] = base64_encode($this->secretkey);
                $output = JWT::encode($data,$this->secretkey,'HS256');
                $this->session->set_userdata('tokencuk',$output);
                $this->session->set_userdata('logine','oke');
                $data_login=array(
                    'nama'=>'administrator',
                    'kewenangan'=>'admin',
                    'login_time' => date('Y-m-d H:i:s')
                );
                $this->session->set_userdata($data_login);
                redirect('main/admin');
            } else {
                    //ptsp
                    if ($this->ptsp->chek_userpass_ptsp($loket,$pass)=='wedhus') {
                        $data['idtoken'] = base64_encode($this->secretkey);
                        $output = JWT::encode($data,$this->secretkey,'HS256');
                        $this->session->set_userdata('tokencuk',$output);
                        $this->session->set_userdata('logine','oke');
                      //  if ($this->session->userdata('berantai')==0) {
                            redirect('main');
                     //   } else {
                      //      redirect('main/berantai');
                      //  }

                    } else {
                        $this->session->set_userdata('logine','oraoke');
                        redirect(base_url());
                    }

            }

    }

    public function validasihp(){
        $this->load->model('m_akses');
        //chek hp_pihak
        $nohp=$this->input->post('nohp');
        $cekhp=$this->m_akses->chek_hp($nohp);
        if ($cekhp==1) {
            //kirim sms ke pihak
            $this->m_akses->smsotp($nohp);
            $data['nohp']= $nohp;
            $data['pesan']='';
            $this->load->view('halaman/login_otp',$data);
        }
        else {
            $data['pesan']="nomer HP anda belum/tidak terdaftar silahkan hubungi Meja Pendaftaran";
            $this->load->view('halaman/login_pihak',$data);
        }
    }

    public function validasiotp(){
        $this->load->model('m_akses');
        //chek hp_pihak
        $nohp=$this->input->post('nohp');
        $pin=$this->input->post('pinhp');
        $cekhp=$this->m_akses->chek_pin($nohp,$pin);
        if ($cekhp==1) {
            $data['nohp']=$nohp;
            $data['daftar_sidang_pihak']=$this->m_akses->list_perkara_pihak($nohp);
            $data['hal']= $this->load->view('halaman/list_perkara_pihak',$data,TRUE);
            $this->load->view('layout/main_pihak', $data);
        }
        else {
            $data['nohp']= $nohp;
            $data['pesan']= 'salah PIN atau sudah kadaluarsa';
            $this->load->view('halaman/login_otp',$data);
        }


    }
    //method untuk melihat token pada user
    public function validasipin(){
        $this->load->model('m_akses');
        if ($this->m_akses->chek_pin()==1) {
            $data['idtoken'] = base64_encode($this->secretkey);
            $output = JWT::encode($data,$this->secretkey,'HS256');
            $this->session->set_userdata('tokencuk',$output);
            $this->session->set_userdata('login_pihak','oke');
            redirect('utama_pihak');
        }
        else {
            $data['nohp']= $nohp;
            $this->load->view('halaman/login_otp');
        }
    }


    public function tokencek(){
        $token=base64_encode($this->secretkey);
        $jwt = $this->session->userdata('tokencuk');
        try {
            $decode = JWT::decode($jwt,$this->secretkey,array('HS256'));
                if ($decode->idtoken==$token) {
                    return true;
                } else {
                    redirect(base_url());
                }
        } catch (Exception $e) {
            redirect(base_url());
            exit;
        }
    }
}