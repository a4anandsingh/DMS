<?php date_default_timezone_set('Asia/Kolkata');
//error_reporting(E_ALL);
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
        $this->dm__user_permission='dm__user_permission';
        $this->tableName = 'usr__m_user_class';
        $this->tbl_user = 'usr__m_users';

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
    // user_class_based Start
    function getUserClassGridData(){
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        $objFilter->SQL = 'SELECT * FROM '. $this->tableName .' WHERE 1';
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL;
        //exit;
        if($objFilter->RESULT){
            foreach($objFilter->RESULT as $row){
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->USER_CLASS_ID). '"');
                array_push($fieldValues, '"' . addslashes($row->USER_CLASS_NAME) . '"');
                array_push($fieldValues, '"' . addslashes(($row->PUBLISHED==1)? "ACTIVE":"IN-ACTIVE"). '"');
                array_push($objFilter->ROWS, '{"id":"' . $row->USER_CLASS_ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }
   // user_class_based End

    private function showButton($id,$status){
        if($status==1){
            return getButton('In-Active', 'Active(2,' . $id . ')', 4, '');
        }else{
            return getButton('Active', 'Active(1,' . $id . ')', 4, '');
        }
        
    }

   
    public function Active($data){
        return $this->db->update($this->dm__menu_master,array('STATUS' => $data['STATUS']), array('MENU_ID' => $data['ID']));
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
       //showArrayValues($ID);//exit();
        $recs= $this->db->select("CATEGORY_ENG")->from("dm__category")->where_in("ID",$ID)->get();
        //echo $this->db->last_query();
        $category_eng=array();
        if($recs && $recs->num_rows()){
            foreach($recs->result() as $rec){

                $category_eng[] = $rec->CATEGORY_ENG;
            }
            $recs->free_result();
        }
        return implode(",",$category_eng);
    }

    function saveData($id, $arrValues){
        //showArrayValues($arrValues);exit();
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

    protected function getFields($table){
        $strSQL = 'SHOW COLUMNS FROM ' . $table;
        $recs = $this->db->query($strSQL);
        $arrNames = array();
        if($recs && $recs->num_rows()){
          foreach($recs->result() as $rec){
            array_push($arrNames, $rec->Field);
            $recs->free_result();
          }
        }
        return $arrNames;
      }
      public function buildChild($parent, $menu){       

        if (isset($menu['parents'][$parent])) {
            foreach ($menu['parents'][$parent] as $ItemID) {
                //showArrayValues($ItemID);
                if (!isset($menu['parents'][$ItemID->ID])) {
                    $result[$ItemID->CATEGORY_ENG] = $ItemID->ID;
                }
                if (isset($menu['parents'][$ItemID->ID])) {
                    $result[$ItemID->CATEGORY_ENG][$ItemID->ID] = self::buildChild($ItemID->ID, $menu);
                }
            }
        }
        return $result;
    }
    public function showEntryBox($id){
        $arrFields=$this->getFields($this->dm__category);
        $arrData = array();
        // if($id == 0){
            $this -> db -> select('*');
            $this -> db -> from('dm__category');
            $recs = $this ->db->get();
            //echo $this->db->last_query();
            if($recs && $recs->num_rows()){
                foreach($recs->result() as $rec){
                    //$arrData[] = $rec;
                    $arrData['parents'][$rec->PARENT_CATE_ID][] = $rec;
                    $arrData['result'] = $this->buildChild(0, $arrData);
                }
            }
        // }
        //showArrayValues($arrData); exit;
        return $arrData;

  }

function get_parent_menu($ID){
		$this->db->where('ID',$ID);
		$this-> db->select('*');
        $this -> db -> from('dm__category'); 		
		$query = $this ->db->get();			
		return $query->row_array();
		
	}

    function saveUserClass($PERMIT_ID,$arrValues,$arrUpdateVal){
        //showArrayValues($arrValues);exit();
        if($PERMIT_ID == 0){
            $editMode = 0;
            $this->db->insert($this->dm__user_permission, $arrValues);
        }else{
            $editMode = 1;
            $this->db->update($this->dm__user_permission, $arrUpdateVal, array('PERMIT_ID' => $PERMIT_ID));
        }
        if($this->db->affected_rows()){
           //array_push($this->message, getMyArray(true, 'User Data  ' . (($editMode) ? 'Updated' : 'Saved') . '...'));
            array_push($this->message, getMyArray(true, 'User  Data  ' . (($editMode) ? 'Updated' : 'Saved') . '...'));
        }
        return createJSONResponse($this->message);
    }
    public function getUserClass_master($ID=null){
        if($ID==null){
           return $this->db->select("*")->from("dm__user_permission")->get()->result_array();
        }else{
            return $this->db->select("*")->from("dm__user_permission")->where(["USER_CLASS_ID"=>$ID])->get()->row_array();
            //return $this->db->select("*")->from("dm__user_permission")->where(["USER_ID"=>$ID])->get()->row_array();
        }
    }
    public function get_access($selval){
        $this->db->select('ID,CATEGORY_ENG,PARENT_CATE_ID');
        $this->db->from('dm__category');
        $this->db->where_in('ID',$selval);
        $recs = $this ->db->get();
        //echo $this->db->last_query();
        return $recs->result();
    }
}
?>
<?php //if ($tag_1 == 'yes') echo "checked='checked'"; ?>
