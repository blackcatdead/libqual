<?php
  Class M_diskretisasi extends CI_Model
  {

     function getdiskretisasi($par)
     {
       $data = $this->db-> get_where('diskretisasi', $par);
       return $data -> result_array();
     }

    function tambahdiskretisasi($par)
    {
      $data= $this->db->insert('diskretisasi', $par);  
      $insert_id = $this->db->insert_id();  
      return $insert_id;
    }

    function ubahdiskretisasi($id_diskretisasi, $par)
   {
      $this->db->where('id_diskretisasi', $id_diskretisasi);
      $data=$this->db->update('diskretisasi', $par);
      return $data;
   }

   function hapusdiskretisasi($par)
    {
      return $this->db->delete('diskretisasi', $par);
    }

    
  }
?>