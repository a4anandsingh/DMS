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
	
    function display_records()
    {
        $query=$this->db->get("dm__category");
        return $query->result();
    }

    function tree_all() {
        $result = $this->db->query("SELECT  ID, CATEGORY_ENG,CATEGORY_ENG as text, PARENT_CATE_ID FROM dm__category  ")->result_array();
            foreach ($result as $row) {
                $data[] = $row;
            }
            return $data;
    }
    
  /*  function getCategory($where)
    {
        $arrVal=array();
        $this->db->select("*");
        $this->db->from($this->dm__category);
        //$this->db->where("SECTION_ID",$sectionId);
        $this->db->where($where);
        $query=$this->db->get();
        foreach($query->result() as $rec){
            array_push($arrVal,array('CATEGORY_ID'=>$rec->ID,'CATEGORY_NAME'=>$rec->CATEGORY_ENG));
        }
        return json_encode($arrVal);
    }*/
    
    function saveData($id, $arrValues){
        if($id == 0){
            $editMode = 0;
            $this->db->insert($this->dm__menu_master, $arrValues);
        }else{
            $editMode = 1;
            $this->db->update($this->dm__menu_master, $arrValues, array('MENU_ID' => $id));
        }
        if($this->db->affected_rows()){
            array_push($this->message, getMyArray(true, 'Menu Data  ' . (($editMode) ? 'Updated' : 'Saved') . '...'));
        }
        return createJSONResponse($this->message);
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
}
?>
