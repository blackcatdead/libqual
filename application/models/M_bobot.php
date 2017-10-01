<?php
  Class M_bobot extends CI_Model
  {

    function getbobot($par)
    {
      	$data = $this->db-> get_where('bobot', $par);
      	return $data -> result_array(); 
    }

    function ubahbobot_transc($bobots, $id_user, $type)
    {
    	// echo '<pre>';
    	// print_r($bobots);
    	// echo '<pre>';
    	// print_r($bobots['bobot']);
    	// break 1;
    	$this->db->trans_start();
		//trans start

		// $parhapus['type']=$type;
  //   	$parhapus['id_user_fk']=$id_user;
        $datahapus=[];
        foreach ($bobots['bobot'] as $key => $value1) {
            if (!in_array($key,  $datahapus)) {
                $datahapus[]=$key;
            }
            foreach ($value1 as $key2 => $bob) {
                if (!in_array($key2,  $datahapus)) {
                    $datahapus[]=$key2;
                }
            }
        }

    	$this->hapusbobotwherein($datahapus,$type,$id_user);

    	foreach ($bobots['bobot'] as $key1 => $value1) {
    		foreach ($value1 as $key2 => $bob) {
    			$parins['id_user_fk']=$id_user;
    			$parins['type']=$type;
    			$parins['id_target_1']=$key1;
    			$parins['id_target_2']=$key2;
    			$parins['bobot']=$bob['nilai'];
                $parins['lebihpenting']=($bob['lebihpenting']==3) ? 1 : $bob['lebihpenting'];
    			$parins['status_bobot']=1;

    			$this->tambahbobot($parins);
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

    function hapusbobotwherein($data,$type, $id_user_fk)
    {
    	if (!empty($data)) {
           
            $this->db->where('type', $type);
            $this->db->where('id_user_fk', $id_user_fk);
            $this->db->where_in('id_target_1', $data);
            $this->db->delete('bobot');
        }
    }

    function hapusbobot($par)
    {
        return $this->db->delete('bobot', $par);
    }

    function tambahbobot($par)
    {
      $data= $this->db->insert('bobot', $par);  
      $insert_id = $this->db->insert_id();  
      return $insert_id;
    }

  }
?>