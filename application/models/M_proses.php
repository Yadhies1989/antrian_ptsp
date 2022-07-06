<?php
class M_proses extends CI_Model
{

    public function ambil_satker() {

        $satker=$this->db->query("select b.nama as satker
                                from ".$this->config->item('database_sipp').".sys_config a
                                left join ".$this->config->item('database_sipp').".pengadilan_negeri b
                                on a.value=b.kode_pn
                                where a.id=61")->row();
        return $satker->satker;
    }


    public function check_loket_berantai() {
        $kweri=$this->db->query("select nama_layanan from m_loket where berantai=1 order by no_loket asc");
        if($kweri->num_rows() > 0) {
            $layanan=$kweri->row()->nama_layanan;
        } else {
            $layanan="0";
        }
        return $layanan;
    }

    public function check_loket_berantai2($loket,$jenis_layanan) {
        $kweri=$this->db->query("select no_loket,urut_loket,berantai from m_loket where berantai=$jenis_layanan order by no_loket desc limit 1");
        if($kweri->num_rows() > 0) {
                if($kweri->row()->berantai==1) {
                    $urut = $kweri->row()->urut_loket;
                } else {
                    $kweris = $this->db->query("select max(urut_loket)+1 as urut_loket from m_loket");
                    $urut = $kweris->row()->urut_loket;
                }

        } else {
            $kweris = $this->db->query("select max(urut_loket)+1 as urut_loket from m_loket");
            if(empty( $kweris->row()->urut_loket)) {
                $urut=1;
            } else {
                $urut = $kweris->row()->urut_loket;
            }

        }
        return $urut;
    }


    public function data_loket() {
        return $this->db->query('select * from m_loket  order by no_loket asc');
    }


    public function ambil_loket_baru() {

        $kweri= $this->db->query('select ifnull(max(no_loket)+1,1) as no_loket from m_loket')->row();
        return $kweri->no_loket;

    }

    public function data_loket_aktif() {

        return $this->db->query("select a.no_loket,a.urut_loket,a.berantai,a.nama_layanan,ifnull(max(b.no_antrian),'--') as no_antrian,b.tanggal from m_loket a 
                                    left join antrian_ptsp b on a.no_loket=b.display and tanggal=curdate() and  b.status is not null
                                    where a.aktif='1'
                                    group by a.no_loket");

    }

    public function data_loket_aktif_cetak() {

        return $this->db->query(" select a.urut_loket,GROUP_CONCAT(DISTINCT a.no_loket) as no_loket,a.berantai,a.nama_layanan,
                                    ifnull(max(b.no_antrian),'--') as no_antrian,b.tanggal 
                                    from m_loket a 
                                    left join antrian_ptsp b on  a.urut_loket=b.no_loket and tanggal=curdate() 
                                    where a.aktif='1'
                                    group by a.urut_loket");

    }

    public function tambah_loket($no_loket,$urut_loket,$nama_layanan,$username,$password,$aktif,$jenis) {
        $tanggal = date("Y-m-d H:i:s");
        $this->db->query("replace into m_loket (no_loket,urut_loket,nama_layanan,username,password,aktif,berantai,diinput) values ($no_loket,$urut_loket,'".$nama_layanan."','".$username."','".$password."','".$aktif."',$jenis,'".$tanggal."')");
    }

    public function hapus_loket($no_loket) {
        $this->db->query("delete from m_loket where no_loket=$no_loket");
    }


    public function input_panggilan($tgl,$no_loket,$urut_loket,$no_antrian,$suara,$status,$waktu) {
        $this->db->query("insert into panggilan_ptsp(tanggal,no_loket,urut_loket,no_antrian,suara,status,waktu)values('".$tgl."',$no_loket,$urut_loket,$no_antrian,'".$suara."',$status,'".$waktu."')");
        $this->db->query("update antrian_ptsp set status=0, tanggal_mulai='".$waktu."', display=$no_loket where no_loket=$urut_loket and no_antrian=$no_antrian and tanggal='".$tgl."'");
    }

    public function selesai($tgl,$no_loket,$no_antrian) {
        $waktu=date("Y-m-d H:i:s");
        $this->db->query("update antrian_sidang_terpadu.antrian_ptsp set  status=1, tanggal_selesai='".$waktu."' where tanggal='".$tgl."' and no_loket=$no_loket and no_antrian=$no_antrian");
    }

    public function ambil_suara() {
        $suara=[];
        $kweri=$this->db->query("select id,suara from antrian_sidang_terpadu.panggilan_ptsp where tanggal=curdate() and status=0");
        if ($kweri->num_rows() > 0) {

            foreach ($kweri->result() as $row) {
                $pesan=array(
                    "id_suara"=>$row->id,
                    "teks"=>$row->suara
                );
                $suara[]=$pesan;
            }

        } else {
            $pesan=array(
                "id_suara"=>0,
                "teks"=>0
            );
            $suara[]=$pesan;
        }
        return $suara;
    }

    public function update_panggilan($id) {
        $kweri=$this->db->query(" update antrian_sidang_terpadu.panggilan_ptsp set status=1 where id=$id");
    }

    public function get_antrian_status()
    {
        $strQuery = "SELECT urut_loket, no_loket,no_antrian,suara
                    FROM panggilan_ptsp
                     WHERE tanggal = CURDATE() AND status = 0 order by waktu asc  LIMIT 1";
        $query = $this->db->query($strQuery);
        $row =  $query->row();
        return $row;
    }

    public function get_antrian()
    {
        $data_antrian=[];
        $kweri = $this->db->query("SELECT suara,status
                                        FROM panggilan_ptsp 
                                         WHERE tanggal = CURDATE() AND status = 0 order by waktu asc  LIMIT 1");
        if ($kweri->num_rows() > 0) {
            $row =  $kweri->row();
            $hasil=array("hasil"=>1,"suara"=>str_replace('!','',$row->suara),"status"=>$row->status);
        } else {
            $hasil=array("hasil"=>0);
        }
        $data_antrian[]=$hasil;
        return $data_antrian;
    }


    public function check_status($tgl,$no_loket,$urut_loket,$berantai) {
        if ($berantai==0) {

            $kweri=$this->db->query("Select status from panggilan_ptsp  where tanggal='".$tgl."' and no_loket=$no_loket order by waktu desc limit 1");
            if ($kweri->num_rows() > 0) {
                $status=$kweri->row()->status;
            } else {
                $status=0;
            }
            $kweri=$this->db->query("select count(*) as jumlah from antrian_ptsp where tanggal='".$tgl."' and no_loket=$urut_loket and berantai=0")->row();
            $total_antrian=$kweri->jumlah;
            $kweris=$this->db->query("select count(*) as jumlah from antrian_ptsp where tanggal='".$tgl."' and no_loket=$urut_loket and berantai=0 and status is null")->row();
            $sisa=$kweris->jumlah;
            if($sisa <  0) {
                $sisa_antrian='-';
            } else {
                $sisa_antrian=$sisa;
            }

            $hasil=array("status_panggil"=>$status,"total_antrian"=>$total_antrian,"sisa_antrian"=>$sisa_antrian);

        } else if ($berantai==1) {

            $kwerid=$this->db->query("Select status from panggilan_ptsp  where tanggal='".$tgl."' and no_loket=$no_loket  order by waktu desc limit 1");
            if ($kwerid->num_rows() > 0) {
                $status=$kwerid->row()->status;
            } else {
                $status=0;
            }
            $kweri=$this->db->query("select count(*) as jumlah from antrian_ptsp where tanggal='".$tgl."' and berantai=1")->row();
            $total_antrian=$kweri->jumlah;
            $kweris=$this->db->query("select count(*) as jumlah from antrian_ptsp where tanggal='".$tgl."' and berantai=1 and status is null")->row();
            $sisa=$kweris->jumlah;
            if($sisa <  0) {
                $sisa_antrian='-';
            } else {
                $sisa_antrian=$sisa;
            }

            $hasil=array("status_panggil"=>$status,"total_antrian"=>$total_antrian,"sisa_antrian"=>$sisa_antrian);
        }

        return $hasil;
    }

    public function info_antrian($no_loket,$tanggal) {
        $kweri=$this->db->query("select max(no_antrian) as no_antrian from antrian_sidang_terpadu.antrian_ptsp where no_loket=$no_loket and tanggal='".$tanggal."'");
        return $kweri;
    }

    public function info_loket($no_loket) {
        $kweri=$this->db->query("select no_loket from antrian_sidang_terpadu.m_loket where urut_loket=$no_loket limit 1")->row();
        return $kweri->no_loket;
    }


    public function insert_antrian($no_loket,$nama_layanan,$no_antrian,$tanggal,$tgl_diambil,$berantai) {

        $this->db->query("insert into antrian_sidang_terpadu.antrian_ptsp(no_loket,nama_layanan,no_antrian,tanggal,berantai,tanggal_diambil) values ($no_loket,'".$nama_layanan."',$no_antrian,'".$tanggal."',$berantai,'".$tgl_diambil."')");

    }




    public function ambil_status($tgl_sidang) {
        //chek ruang sidang yang sudah dipanggil
        $status_ruang=[];
        $ruang=$this->db->query("select ruang from antrian_sidang_terpadu.panggilan_sidang where tgl_sidang='".$tgl_sidang."' and status<>2 group by ruang");
        if($ruang->num_rows() > 0) {
            //ambil sttatus
            foreach($ruang->result() as $rows) {
                $status=$this->db->query("Select status from antrian_sidang_terpadu.panggilan_sidang  where tgl_sidang='".$tgl_sidang."' and ruang=$rows->ruang  and status<>2 order by waktu desc limit 1");
                if($status->num_rows() > 0) {

                    switch ($status->row()->status) {
                        case 1 :
                            $stat="** Selesai **";
                            break;
                        case 2 :
                            $stat="** Dilewat **";
                            break;
                        case 3 :
                            $stat="** Sedang Sidang **";
                            break;
                        case 4 :
                            $stat="** Dipanggil **";
                            break;
                        default :
                            $stat="-";
                    }
                    $data=array("ruang" => $rows->ruang,
                        "status_ruang" => $stat
                    );
                    $status_ruang[]=$data;
                }
            }

            return $status_ruang;

        }


    }



    public function update_antrian_panggil($id='')
    {
        $this->db->where('id',$id);
        $this->db->update('antrian_sidang_terpadu.panggilan_sidang',array('st_panggil' => 1));
    }

    public function no_dipanggil($loket,$tgl) {
        //cek apakah berantai

            $kweri=$this->db->query("select min(no_antrian) as no_antrian from antrian_ptsp
                                    where tanggal='".$tgl."' and no_loket=$loket and  (status is null or status=0)");
            if(isset($kweri->row()->no_antrian)) {
                if ($kweri->num_rows() > 0) {
                    $no=$kweri->row()->no_antrian;
                } else {
                    $no=0;
                }
            } else {
                $no = 0;
            }


        return $no;
    }

    public function no_dipanggil_berantai($loket,$urut_loket,$tgl) {
        //cek apakah berantai

        $kweri=$this->db->query("select max(no_antrian) as no_antrian from antrian_ptsp
                                    where tanggal='".$tgl."' and no_loket=$urut_loket and display=$loket and status=0");
        if(isset($kweri->row()->no_antrian)) {
            if ($kweri->num_rows() > 0) {
                $no=$kweri->row()->no_antrian;
            } else {
                $no=0;
            }
        } else {
            $no = 0;
        }


        return $no;
    }



    public function status_dipanggil($ruang,$tgl,$no_antrian) {
        $kweri=$this->db->query("select status from antrian_ptsp where tanggal='".$tgl."' and no_loket=$ruang and no_antrian=$no_antrian");
        if ($kweri->num_rows() > 0) {
            $status=$kweri->row()->status;
        } else {
            $status="-";
        }
        return $status;
    }

    public function jumlah_antrian($urut_loket,$tgl) {
        $kweri=$this->db->query("select count(*) as jumlah from antrian_ptsp where tanggal='".$tgl."' and no_loket=$urut_loket")->row();
        $no=$kweri->jumlah;
        return $no;
    }

    public function jumlah_antrian_berantai($tgl) {
        $kweri=$this->db->query("select count(*) as jumlah from antrian_ptsp where tanggal='".$tgl."' and berantai=1")->row();
        $no=$kweri->jumlah;
        return $no;
    }

    public function jumlah_sisa_antrian($urut_loket,$tgl) {
        $kweri=$this->db->query("select count(*) as jumlah from antrian_ptsp where tanggal='".$tgl."' and no_loket=$urut_loket and status is null ")->row();
        $no=$kweri->jumlah;
        return $no;
    }

    public function jumlah_sisa_antrian_berantai($tgl) {
        $kweri=$this->db->query("select count(*) as jumlah from antrian_ptsp where tanggal='".$tgl."'  and berantai=1 and status is null")->row();
        $no=$kweri->jumlah;
        return $no;
    }


    public function update_antrian($tgl,$no_loket,$display_berantai,$no_antrian,$status_antrian)
    {
        $this->db->query("update antrian_ptsp set status=$status_antrian, display=$display_berantai where no_loket=$no_loket and no_antrian=$no_antrian and tanggal='".$tgl."'");
    }
    public function ambil_posisi_berantai($urut_loket,$no_loket,$tgl) {
        $this->db->query("update antrian_ptsp set status=1 where no_loket=$urut_loket and display=$no_loket");
        $kweri=$this->db->query("select min(no_antrian) as no_antrian from antrian_ptsp
                                    where tanggal='".$tgl."' and no_loket=$urut_loket and display is null and (status is null or status=0)");
        if(isset($kweri->row()->no_antrian)) {
            if ($kweri->num_rows() > 0) {
                $no=$kweri->row()->no_antrian;
            } else {
                $no=0;
            }
        } else {
            $no = 0;
        }
        return $no;
    }

    public function ambil_posisi($urut_loket,$no_loket,$tgl) {
        $this->db->query("update antrian_ptsp set status=1 where no_loket=$urut_loket and display=$no_loket");
        $kweri=$this->db->query("select min(no_antrian) as no_antrian from antrian_ptsp
                                    where tanggal='".$tgl."' and no_loket=$urut_loket and  (status is null or status=0)");
        if(isset($kweri->row()->no_antrian)) {
            if ($kweri->num_rows() > 0) {
                $no=$kweri->row()->no_antrian;
            } else {
                $no=0;
            }
        } else {
            $no = 0;
        }

        return $no;
    }

}