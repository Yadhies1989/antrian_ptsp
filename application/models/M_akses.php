<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_akses extends CI_Model {



    public function smsotp ($nohp) {

        //sms

        $pin=$this->generate_otp();
        $pesan='Pin masuk antrian sidang adalah '.$pin." akan kadaluarsa dalam waktu 60 menit";
        $this->db->query("INSERT INTO smsku.outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nohp','$pesan','gammu')");
        //masukan ke db antrinpin
        $tanggals = date("Y-m-d H:i:s");
        $this->db->query("insert into antrian.antrian_pin (nohp,pin,tgl) values ('$nohp','$pin','$tanggals')");

    }


    public function chek_pin($nohp,$pin) {

        $kweri=$this->db->query("select pin,tgl from antrian.antrian_pin where  nohp like '%".$nohp."%' order by tgl desc limit 1")->row();

        if (isset($kweri->pin)) {

            if ($pin==$kweri->pin) {

                return 1;

                /* $data_login=array(
                     'satker'=>'pihak',
                     'nama'=>'nama_pihak',
                     'kewenangan'=>'kewenangan_pihak',
                     'iduser'=>'id_pihak',
                     'jabatan' =>'pihak/pengacara',
                     'login_time' => date('Y-m-d H:i:s')
                 );

                 $this->session->set_userdata($data_login);*/

            } else {

                return 0;

            }

        } else {

            return 0;
        }


    }


    public function list_perkara_pihak ($nohp) {


        $kweri_pihak=$this->db->query("select a.nomor_perkara,a.perkara_id,group_concat(distinct b.nama separator '<br>') as p, group_concat(distinct j.nama separator '<br>') as t,a.jenis_perkara_text,
                                            date_format(x.tanggal_sidang,'%d-%m-%Y') as tgl_sidang from perkara a
                                            left join perkara_pihak1 b on a.perkara_id=b.perkara_id
                                            left join perkara_pihak2 j on a.perkara_id=j.perkara_id	
                                            left join pihak z on b.pihak_id=z.id 
                                            left join perkara_jadwal_sidang x on a.perkara_id=x.perkara_id
                                            where z.telepon like '%".$nohp."%' and x.tanggal_sidang >=curdate() group by a.perkara_id order by x.tanggal_sidang asc");
        if ($kweri_pihak->num_rows() > 0) {

            return $kweri_pihak;

        } else {

            $kweri_pengacara=$this->db->query("select a.nomor_perkara,a.perkara_id,group_concat(distinct b.nama separator '<br>') as p, group_concat(distinct j.nama separator '<br>') as t,a.jenis_perkara_text,
                                                date_format(x.tanggal_sidang,'%d-%m-%Y') as tgl_sidang,k.nama as pengacara from perkara a
                                                left join perkara_pihak1 b on a.perkara_id=b.perkara_id
                                                left join perkara_pihak2 j on a.perkara_id=j.perkara_id	
                                                left join perkara_pengacara k on a.perkara_id=k.perkara_id
                                                left join pihak z on k.pengacara_id=z.id 
                                                left join perkara_jadwal_sidang x on a.perkara_id=x.perkara_id
                                                where z.telepon like '%".$nohp."%' and x.tanggal_sidang > curdate() group by a.perkara_id order by x.tanggal_sidang asc");

            if ($kweri_pengacara->num_rows() > 0) {

                return $kweri_pengacara;


            } else {


                return 0;
            }

        }




    }



    private function generate_otp($length = 6)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function send_otp($phone_number)
    {
        $otp_code = $this->generate_otp();
        $data = [
            'phone_number' => $phone_number,
            'otp_code' => $otp_code,
            'created' => time()
        ];
        $this->db->insert('antrian_otp', $data);
        $sms = '<#> Kode OTP Antrian Sidang Anda: '.$otp_code.' qvRG9eDX1PE';
    }

    /*
    function ambil_id($userid){

        $kweri=$this->db->query("

                                select a.userid,b.hakim_id,c.panitera_id,

                                ")


        $this->db->select('su.userid, uh.hakim_id, uj.jurusita_id, up.panitera_id');
        $this->db->from('sys_users su');
        $this->db->join('user_hakim uh','su.userid=uh.userid','left');
        $this->db->join('user_jurusita uj','su.userid=uj.userid','left');
        $this->db->join('user_panitera up','su.userid=up.userid','left');
        $this->db->where('su.userid', $userid);
        $res=$this->db->get();
        return $res->row(0);

    }
*/

    public function hapus_sesi(){
        $userName = $this->session->userdata('userid');
        if(empty($userName)){
            $this->session->sess_destroy();
            redirect('login');
        }
    }


    function chek_userpass_ptsp($user,$pass)
    {
        //checkuserpass
        $kweri=$this->db->query("select * from m_loket where username='".$user."' and password='".$pass."'");
        if($kweri->num_rows() > 0) {
            $data_login=array(
                'username'=>$kweri->row()->username,
                'loket' =>$kweri->row()->no_loket,
                'urut_loket' =>$kweri->row()->urut_loket,
                'layanan'=>$kweri->row()->nama_layanan,
                'berantai'=>$kweri->row()->berantai,
                'tanggal'=>date('Y-m-d'),
                'login_time' => date('Y-m-d H:i:s'),
                'logine' =>'oke'
            );
            $this->session->set_userdata($data_login);
            return 'wedhus';
        } else {
            $this->session->set_userdata('logine','oraoke');
            return 'gajah';
        }
    }



}