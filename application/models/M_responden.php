<?php
  Class M_responden extends CI_Model
  {
    

    function getresponden($par)
    {
       $data = $this->db-> get_where('responden', $par);
       return $data -> result_array();
    }

    function tambahresponden($par)
    {
      $data= $this->db->insert('responden', $par);  
      $insert_id = $this->db->insert_id();  
      return $insert_id;
    }

    function ubahresponden($id_responden, $par)
    {
      $this->db->where('id_responden', $id_responden);
      $data=$this->db->update('responden', $par);
      return $data;
    }

    function hapusresponden($par)
    {
      return $this->db->delete('responden', $par);
    }

    function hapusresponden_transc($id_responden)
    {
      $this->load->model('m_jawaban','',TRUE);
      
      $this->db->trans_start();
      //trans start

      $parresp['id_responden']=$id_responden;
      $this->hapusresponden($parresp);

      $parjawaban['id_responden_fk']=$id_responden;
      $this->m_jawaban->hapusjawaban($parjawaban);

        //trans end
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE)
      {
          return false;
      }else
      {
        return true;
      }
    }

    
  }
?>