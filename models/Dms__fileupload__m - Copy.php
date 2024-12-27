<?php date_default_timezone_set('Asia/Kolkata');
class Dms__fileupload__m extends CI_Model
{
    var $message;
    var $catRows;
    var $catOptions;
    function __construct()
    {
        parent::__construct();
        //$this->setup = AGREEMENT_DB.'.new';
        $this->message = array();
        $this->dm__files = 'dm__files';
        $this->dm__sections = 'dm__sections';
        $this->dm__category = 'dm__category';
        $this->dm__user_permission = 'dm__user_permission';
        $this->tbl_user = 'usr__m_users';
        $this->catRows="";
        $this->catOptions="";

    }
    function saveData($id, $arrValues){
        
        if($id == 0){
            $editMode = 0;
            $this->db->insert($this->dm__files, $arrValues);
        }else{
            $editMode = 1;
            $this->db->update($this->dm__files, $arrValues, array('ID' => $id));
        }
        if($this->db->affected_rows()){
            array_push($this->message, getMyArray(true, 'File Details  ' . (($editMode) ? 'Updated' : 'Saved') . '...'));
        }
        return createJSONResponse($this->message);
    }
    function getFileUploadGrid($userId){
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        $selId = 0;
        $holdingPerson = getSessionDataByKey('HOLDING_PERSON');
        //$officeId = getSessionDataByKey('CURRENT_OFFICE_ID');
        $userclassId = $this->getUserbyclassId($userId);
        $officeId = $this->getOfficeIdbyUser($userId);
        $userPermission = $this->getUserPermission($userclassId);

        $selectedView= $this->getPublishedByUser($userId);
        $recUser = $userPermission->row();
        if($recUser){
            $selId = $recUser->CATEGORY_SELECTED_EDIT;
        }       
        //showArrayValues($recUser);
        $objFilter->SQL = 'SELECT file.*, sections.ID as SECTION_ID, sections.CATEGORY_ENG as SECTION_NAME,  category.CATEGORY_ENG
            FROM '. $this->dm__files .' file
            LEFT JOIN '.$this->dm__category.' sections ON sections.ID = file.SECTION_ID
            LEFT JOIN '.$this->dm__category.' category ON category.ID = file.CATEGORY_ID
            where file.SECTION_ID IN ('.$selId.') AND file.OFFICE_ID = '.$officeId.' ';
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL; //exit;
        $arr_accessLevel = array('1'=>'Public','2'=>'Private','3'=>'Both');
        if($objFilter->RESULT){
            foreach($objFilter->RESULT as $row){
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->ID) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_NAME_ENG) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_NAME_HINDI) . '"');
               /* array_push($fieldValues, '"' . addslashes($row->FILE_DESCRIPTION) . '"');*/
                array_push($fieldValues, '"' . addslashes($row->LETTER_NO) . '"');
                array_push($fieldValues, '"' . addslashes($row->LETTER_DATE) . '"');
                /*array_push($fieldValues, '"' . addslashes($row->FILE_TYPE) . '"');*/
                /*array_push($fieldValues, '"' . addslashes($row->FILE_URL) . '"');*/
                array_push($fieldValues, '"' . addslashes($row->SECTION_NAME) . '"');
                array_push($fieldValues, '"' . addslashes($row->CATEGORY_ENG) . '"');
                array_push($fieldValues, '"' . addslashes($arr_accessLevel[$row->ACCESS_LEVEL]) . '"');
                if(in_array($row->SECTION_ID,explode(",",$selectedView))){
                    array_push($fieldValues, '"' . addslashes( $this->showButton($row->ID,$row->STATUS) ) . '"');
                }else{
                    array_push($fieldValues, '"' . addslashes('') . '"');
                }
                /*if ($holdingPerson==2) {
                    array_push($fieldValues, '"' . addslashes( $this->showButton($row->ID,$row->STATUS) ) . '"');
                }else{
                    array_push($fieldValues, '"' . addslashes('') . '"');
                }*/
                array_push($objFilter->ROWS, '{"id":"' . $row->ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }
    private function showButton($id,$status){
        /*if($status==1){
            return getButton('Un-Publish', 'Active(2,' . $id . ')', 4, '');
        }else{
            return getButton('Published', 'Active(1,' . $id . ')', 4, '');
        }*/
        /*Start 09-02-2022*/
        if($status==1){
            return getButton('Published', 'Active(2,' . $id . ')', 4, '');
        }else{
            return getButton('Un-Publish', 'Active(1,' . $id . ')', 4, '');
        }
    /*End 09-02-2022*/
        
    }
    public function getPublishedByUser($userId){
        $rec='';
        $userClassId = $this->getUserbyclassId($userId);
        $this->db->select('CATEGORY_SELECTED_VIEW');
        $this->db->from($this->dm__user_permission);
        $this->db->where('USER_CLASS_ID',$userClassId);
        $recs = $this->db->get();
        if($recs && $recs->num_rows()) {
            $rec=$recs->row()->CATEGORY_SELECTED_VIEW;
            /*if($rec->CATEGORY_SELECTED_VIEW)// for publish rights 
                $status=1;*/
        }
        return $rec;
    }
    public function Active($data){
        return $this->db->update($this->dm__files,array('STATUS' => $data['STATUS']), array('ID' => $data['ID']));
    }
    public function getSectionData(){
        return $this->getFields($this->dm__files); //db table name 
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
    /*public function showEntryBox($id){
        //$arrFields = $this->getSectionData();
        $arrData = array();
        return $arrData;
    }*/
  public function showEntryBox($id){
        // echo " >>>>>>> ". $id; exit;
        $arrFields = $this->getSectionData();
        //showArrayValues($arrFields);
        $this->cateSubcatTable();
        //$category_tree=$this->cateSubcatTable();//Nested Menu
        //showArrayValues($var);//Nested Menu
        $arrData = array();
        if($id == 0){
            foreach ($arrFields as $val) {
                if ($val == 'ID'){
                    $arrData[$val] = 0;
                } else{
                    $arrData[$val] = '';        
                }                
            }
        }else{
            $this->db->select('*')
                ->from($this->dm__files)// ->from($this->dm__category)
                ->where('ID', $id);
            $recs = $this->db->get();
            if($recs && $recs->num_rows()){
                $rec = $recs->row();
                foreach($arrFields as $val){
                    $arrData[$val] = $rec->{$val};  
                    }
                $recs->free_result();
            }
            // $arrData['category_tree'] = $category_tree;            
        }
        //showArrayValues($arrData); exit;
        return $arrData;

  }
 /* public function section_pulldown($sectionId){
    $opt = '';
    $arrFields = $this->getFields($this->dm__sections);
    $this->db->select('*');
    $this->db->from($this->dm__sections);
    $this->db->where("STATUS !=",2);
    $recs = $this->db->get();
    //echo $this->db->last_query();
    $opt = '<option value="">Select Section</option>';
    foreach($recs->result() as $row ){
        $opt .= 
            '<option '. ($sectionId==$row->ID ? "selected ='selected'":"") .' value="'.$row->ID.'" title="'.$row->SECTION_NAME.' ('.$row->SECTION_NAME_HINDI.')">'.
        $row->SECTION_NAME.' ('.$row->SECTION_NAME_HINDI.') </option>';
    }
    return $opt;
}*/
public function getOfficeIdbyUser($userId){
    $rec='';
    $this->db->select('OFFICE_ID');
    $this->db->from($this->tbl_user);
    $this->db->where('USER_ID',$userId);
    $recs = $this->db->get();
    if($recs && $recs->num_rows()){
        $rec = $recs->row()->OFFICE_ID;
    }
    return $rec;
}
public function getcategoryItems($userId){
    $rec='';
    $this->db->select('CATEGORY_SELECTED_ALL');
    $this->db->from('dm__user_permission');
    //$this->db->where('USER_CLASS_ID',$userId); 26th April 2022
    $this->db->where('USER_ID',$userId); // 27th April 2022
    $recs = $this->db->get();
    if($recs && $recs->num_rows()){
        $rec = $recs->row()->CATEGORY_SELECTED_ALL;
    }
    return $rec;
}
public function getUserbyclassId($userId){
    $rec='';
    $this->db->select('USER_CLASS_ID');
    $this->db->from($this->tbl_user);
    $this->db->where('USER_ID',$userId);
    $recs = $this->db->get();
    if($recs && $recs->num_rows()){
        $rec = $recs->row()->USER_CLASS_ID;
    }
    return $rec;
}
public function getUserPermission($userclassId){
    $userPermission='';
    $this->db->select('*');
    $this->db->from($this->dm__user_permission);
    $this->db->where('USER_CLASS_ID',$userclassId);
    $userPermission = $this->db->get();
    return $userPermission;
}
//////Get Permission By user ///
public function getUserPermission_row($userclassId){
    $userPermission='';
    $this->db->select('*');
    $this->db->from($this->dm__user_permission);
    $this->db->where('USER_CLASS_ID',$userclassId);
    $userPermission = $this->db->get();
    return $userPermission->row_array();
}

public function section_pulldown($sectionId, $userclassId){
        $opt = '';
        $arrFields = $this->getFields($this->dm__category);
        $userPermission = $this->getUserPermission($userclassId);
        if($userPermission && $userPermission->num_rows()){
            $recUser = $userPermission->row();
            $selId = explode(',',$recUser->CATEGORY_SELECTED_EDIT);
            //showArrayValues($recUser->CATEGORY_SELECTED_EDIT);
            $this->db->select('*');
            $this->db->from($this->dm__category);
            $this->db->where(array('PARENT_CATE_ID'=>0,'STATUS !='=>2));
            $this->db->where_in('ID',$selId);
            $recs = $this->db->get();
            //echo $this->db->last_query();
            $opt = '<option value="">Select Section</option>';
            foreach($recs->result() as $row ){
                $opt .= '<option '. ($sectionId==$row->ID? "selected ='selected'":"") .' value="'.$row->ID.'" 
                title="'.$row->CATEGORY_ENG.' ('.$row->CATEGORY_HINDI.')">'.$row->CATEGORY_ENG.' ('.$row->CATEGORY_HINDI.') </option>';
            }
        }
        return $opt;
        /*$this->db->select('*');
        $this->db->from($this->dm__category);
        $this->db->where(array('PARENT_CATE_ID'=>0,'STATUS !='=>2));
        $recs = $this->db->get();
        //echo $this->db->last_query();
        $opt = '<option value="">Select Section</option>';
        foreach($recs->result() as $row ){
            $opt .= 
                '<option '. ($sectionId==$row->ID? "selected ='selected'":"") .' value="'.$row->ID.'" title="'.$row->CATEGORY_ENG.' ('.$row->CATEGORY_HINDI.')">'.
            $row->CATEGORY_ENG.' ('.$row->CATEGORY_HINDI.') </option>';
        }
        return $opt;*/
    }

function cateSubcatTable($parent = 0, $spacing = '&nbsp;&nbsp;', $user_tree_array = '') {
  if (!is_array($user_tree_array))
    $user_tree_array = array();
    $recs = $this->db->select('*')
            ->from($this->dm__category)
            //->where(array('PARENT_CATE_ID'=>$parent))
            ->where(array('PARENT_CATE_ID'=>$parent,"status"=>1))
            ->order_by('ID','ASC')
            ->get();
    if($recs && $recs->num_rows()){
        foreach($recs->result() as $rec){
			
            $user_tree_array[] = array("id" => $rec->ID,"name" => $spacing . ' → '.$rec->CATEGORY_ENG);
            $user_tree_array = $this->cateSubcatTable($rec->ID, $spacing. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $user_tree_array);
        }
        $recs->free_result();
    }
  return $user_tree_array;
}

/* Start Added on 27th April 2022*/
public function getUserFilesSetting(){
    
    $this->db->select('*');
    $this->db->from('dm__filetype_master');
    $this->db->where('TYPE',"EXT");
    $q = $this->db->get();
    return $q->row_array();
}
/* End - 27th April 2022*/
//old code
/*function getCategory($SECTION_ID){
    $opt = '';
    $recs = $this->db->select('ID,CATEGORY_ENG,CATEGORY_HINDI')
            ->from($this->dm__category)
            ->where(array('SECTION_ID'=>$SECTION_ID,'CATEGORY_ID'=>0))
            ->order_by('ID','ASC')
            ->get();
    foreach($recs->result() as $rec){
        
        $opt .= '<option value="'.$rec->ID.'" title="'.$rec->CATEGORY_ENG.' ('.$rec->CATEGORY_HINDI.')">'.
        $rec->CATEGORY_ENG.' ('.$rec->CATEGORY_HINDI.') </option>';
    }
  return $opt;
}*/


}

?>
