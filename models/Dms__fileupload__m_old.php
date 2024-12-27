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
    function getFileUploadGrid(){
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        $objFilter->SQL = 
            'SELECT category.*, 
                sections.SECTION_NAME,  sections.SECTION_NAME_HINDI 
            FROM 
            '. $this->dm__files .' category
        LEFT JOIN '.$this->dm__sections.' sections ON sections.ID = category.SECTION_ID';
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL;
        //exit;
        if($objFilter->RESULT){
            foreach($objFilter->RESULT as $row){
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->ID) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_NAME_ENG) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_NAME_HINDI) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_DESCRIPTION) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_NO) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_TYPE) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_URL) . '"');
                array_push($fieldValues, '"' . addslashes($row->SECTION_ID) . '"');
                //array_push($fieldValues, '"' . addslashes($row->PARENT_CATE_ID) . '"');
                array_push($fieldValues, '"' . addslashes( ($row->STATUS ==1 ) ?" Active" :"InActive"  ) . '"');
                array_push($objFilter->ROWS, '{"id":"' . $row->ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }
    public function getSectionData(){
        return $this->getFields($this->dm__sections); //db table name 
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
                ->from($this->dm__category)
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
        return $arrData;

  }
  public function section_pulldown($sectionId){
    $opt = '';
    $arrFields = $this->getFields($this->dm__sections);
    $this->db->select('*');
    $this->db->from($this->dm__sections);
    $recs = $this->db->get();
    //echo $this->db->last_query();
    $opt = '<option value="">Select Section</option>';
    foreach($recs->result() as $row ){
        $opt .= 
            '<option '. ($sectionId==$row->ID? "selected ='selected'":"") .' value="'.$row->ID.'" title="'.$row->SECTION_NAME.' ('.$row->SECTION_NAME_HINDI.')">'.
        $row->SECTION_NAME.' ('.$row->SECTION_NAME_HINDI.') </option>';
    }
    return $opt;
}
function cateSubcatTable($parent = 0, $spacing = '', $user_tree_array = '') {
  if (!is_array($user_tree_array))
    $user_tree_array = array();
    $recs = $this->db->select('*')
            ->from($this->dm__category)
            ->where(array('PARENT_CATE_ID'=>$parent))
            ->order_by('ID','ASC')
            ->get();

    if($recs && $recs->num_rows()){
        foreach($recs->result() as $rec){
            $user_tree_array[] = array("id" => $rec->ID, "name" => $spacing . $rec->CATEGORY_ENG);
            $user_tree_array = $this->cateSubcatTable($rec->ID, $spacing . '--', $user_tree_array);
        }
        $recs->free_result();
    }
  return $user_tree_array;
}
function getCategory($SECTION_ID){
    $opt = '';
    $recs = $this->db->select('ID,CATEGORY_ENG,CATEGORY_HINDI')
            ->from($this->dm__category)
            ->where(array('SECTION_ID'=>$SECTION_ID,'PARENT_CATE_ID'=>0))
            ->order_by('ID','ASC')
            ->get();
    foreach($recs->result() as $rec){
        
        $opt .= '<option value="'.$rec->ID.'" title="'.$rec->CATEGORY_ENG.' ('.$rec->CATEGORY_HINDI.')">'.
        $rec->CATEGORY_ENG.' ('.$rec->CATEGORY_HINDI.') </option>';
    }
  return $opt;
}
function getSubCategory($PARENT_CATE_ID){
    $opt = '';
    $recs = $this->db->select('ID,CATEGORY_ENG,CATEGORY_HINDI')
            ->from($this->dm__category)
            ->where(array('PARENT_CATE_ID'=>$PARENT_CATE_ID))
            ->order_by('ID','ASC')
            ->get();
    foreach($recs->result() as $rec){
        
        $opt .= '<option value="'.$rec->ID.'" title="'.$rec->CATEGORY_ENG.' ('.$rec->CATEGORY_HINDI.')">'.
        $rec->CATEGORY_ENG.' ('.$rec->CATEGORY_HINDI.') </option>';
    }
  return $opt;
}

}
?>