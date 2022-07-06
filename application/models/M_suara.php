<?php
class M_suara extends CI_Model
{

    public function ambil_suara() {
        $suara=[];
        $kweri=$this->db->query("select id,suara from panggilan_ptsp where tanggal=curdate() and status=0");
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
        $kweri=$this->db->query(" update panggilan_ptsp set status=1 where id=$id");
    }



}