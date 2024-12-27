<?php
class Dms_m extends CI_Model{
	var $table = 'veh__m_vehicles';
	var $id_col='ID';
	function __construct(){
      	
      	 $this->dm_files = AGREEMENT_DB . '.dm_files';
      	 $this->dm_users = AGREEMENT_DB . '.dm_users';
      	 $this->dm_folders = AGREEMENT_DB .'.dm_folders';

	}

function saverecords($user_id,$name,$parent_id)
  {
    $query="INSERT INTO `dm_folders`( `user_id`, `name`, `parent_id`) 
    VALUES ('$user_id','$name','$parent_id')";
    $this->db->query($query);
  }

}
?>
