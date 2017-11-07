<?php
  Class M_user extends CI_Model
  {

   function login($username, $password)
   {
     $this -> db -> where('username', $username);
     //$this -> db -> where('password', MD5($password));
     $this -> db -> where('password', $password);
     $this -> db -> limit(1);
     $data = $this -> db -> get('user');
   
     return $data -> result_array();
   }

   function getuser($par)
   {
     $data = $this->db-> get_where('user', $par);
     return $data -> result_array();
   }

   function ubahuser($id_user, $par)
   {
      $this->db->where('id_user', $id_user);
      $data=$this->db->update('user', $par);
      return $data;
   }

    function hapususer($par)
    {
      $this->load->model('m_bobot','',TRUE);

      $this->db->trans_start();
      $parbobot['id_user_fk']=$par['id_user'];
      $this->m_bobot->hapusbobot($parbobot);
      $this->db->delete('user', $par);
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE)
      {
          return false;
      }else
      {
        return true;
      }

    }

    function tambahuser($par)
    {
      $data= $this->db->insert('user', $par);  
      $insert_id = $this->db->insert_id();  
      return $insert_id;
    }
  }
?>