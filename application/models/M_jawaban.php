<?php
  Class M_jawaban extends CI_Model
  {

    function getjawaban($par)
    {
       $data = $this->db-> get_where('jawaban', $par);
       return $data -> result_array();
    }

    function tambahjawaban($par)
    {
      $data= $this->db->insert('jawaban', $par);  
      $insert_id = $this->db->insert_id();  
      return $insert_id;
    }

    function ubahjawaban($id_responden, $id_subcriteria_fk, $par)
	{
	  $this->db->where('id_responden_fk', $id_responden);
	  $this->db->where('id_subcriteria_fk', $id_subcriteria_fk);
	  $data=$this->db->update('jawaban', $par);
	  return $data;
	}

	function hapusjawaban($par)
	{
	  return $this->db->delete('jawaban', $par);
	}

	function tambah_jawaban_transc($id_responden, $jawabans)
	{
		$this->db->trans_start();
		//trans start

		foreach ($jawabans as $keytipe => $pertipe) {
			foreach ($pertipe as $keyidsubc => $value) {
				$par['id_responden_fk']=$id_responden;
				$par['id_subcriteria_fk']=$keyidsubc;
				$par['tipe']= ($keytipe == 'persepsi') ? 1 : 2 ;
				$par['jawaban']=$value;
				$this->tambahjawaban($par);
			}
		}


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