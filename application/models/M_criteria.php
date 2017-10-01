<?php
  Class M_criteria extends CI_Model
  {


    function getcriteria_subcriteria($par)
    {
    	 $this->db->join('subcriteria','criteria.id_criteria=subcriteria.id_criteria_fk');
      	$data = $this->db-> get_where('criteria', $par);
      	return $data -> result_array(); 
    }

    function getcriteria($par)
    {
      	$data = $this->db-> get_where('criteria', $par);
      	return $data -> result_array(); 
    }

    function getsubcriteria($par)
    {
        $data = $this->db-> get_where('subcriteria', $par);
        return $data -> result_array(); 
    }

    function tambahsubcriteria($par)
    {
      $data= $this->db->insert('subcriteria', $par);  
      $insert_id = $this->db->insert_id();  
      return $insert_id;
    }

    function ubahsubcriteria($id_subcriteria, $par)
   {
      $this->db->where('id_subcriteria', $id_subcriteria);
      $data=$this->db->update('subcriteria', $par);
      return $data;
   }

   function hapussubcriteria($par)
    {
      return $this->db->delete('subcriteria', $par);
    }

  }
?>