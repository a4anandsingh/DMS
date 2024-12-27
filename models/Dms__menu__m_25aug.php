<?php date_default_timezone_set('Asia/Kolkata');
class Dms__menu__m extends CI_Model
{
	var $message, $dm__user_class;
	function __construct()
	{
	  	parent::__construct();
	    $this->message = array();
	    $this->dm__files = 'dm__files';
        $this->dm__category = 'dm__category';
      	$this->dm__sections = 'dm__sections';
        $this->dm__menu_master = 'dm__menu_master';
        $this->dm__user_class='usr__m_user_class';
	}

    function getMenuMasterGrid(){
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        $objFilter->SQL = 'SELECT * FROM '. $this->dm__menu_master .' ';
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL;
        //exit;
        if($objFilter->RESULT){
            foreach($objFilter->RESULT as $row){
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->MENU_ID) . '"');
                array_push($fieldValues, '"' . addslashes($row->MENU_NAME) . '"');
                array_push($fieldValues, '"' . addslashes($row->MENU_SELECTED) . '"');
                //array_push($fieldValues, '"' . addslashes('') . '"');
                array_push($fieldValues, '"' . addslashes($this->showButton($row->MENU_ID,$row->STATUS) ) . '"');
                array_push($objFilter->ROWS, '{"id":"' . $row->MENU_ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }

    private function showButton($id,$status){
        if($status==1){
            return getButton('In-Active', 'Active(2,' . $id . ')', 4, '');
        }else{
            return getButton('Active', 'Active(1,' . $id . ')', 4, '');
        }
        
    }

    function main_memucat(){ 

        $this -> db -> select('*');
        $this -> db -> from('dm__category');        
        $query = $this ->db->get();  
        //$q=$this->db->last_query();
  //print_r($q);       
        return $query->result();
    }
    
    function insertmenu($param){  

    return  $this->db->insert('dm__menu_master', $param);   
    }

    function updateMENU($param,$MENU_ID) {
   
    $this->db->where('MENU_ID',$MENU_ID);
    return  $this->db->update('dm__menu_master', $param);
    }

    public function getmenu_master($ID=null){
        if($ID==null){
           return $this->db->select("*")->from("dm__menu_master")->get()->result_array();
        }else{
            return $this->db->select("*")->from("dm__menu_master")->where(["MENU_ID"=>$ID])->get()->row_array();
        }
    }

    public function get_categoryBYID($ID=null){
       
        return $this->db->select("*")->from("dm__category")->where(["ID"=>$ID])->get()->row_array();
    }

}
?>
