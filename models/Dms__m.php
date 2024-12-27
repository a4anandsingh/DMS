<?php date_default_timezone_set('Asia/Kolkata');
class Dms__m extends CI_Model
{
	var $message;
	function __construct()
	{
	  	parent::__construct();
	    $this->message = array();
	    $this->dm__files = 'dm__files';
        $this->dm__category = 'dm__category';
      	$this->dm__sections = 'dm__sections';
	}
	/*function saveData($arrValues){
		//showArrayValues($arrValues);
		$this->db->insert($this->dm__sections, $arrValues);
		//echo $this->db->last_query();is_unique[TABLENAME.COLUMNNAME]
	}*/
    function saveData($id, $arrValues){
        if($id == 0){
            $editMode = 0;
            $this->db->insert($this->dm__sections, $arrValues);
        }else{
            $editMode = 1;
            $this->db->update($this->dm__sections, $arrValues, array('ID' => $id));
        }
        if($this->db->affected_rows()){
            array_push($this->message, getMyArray(true, 'Section Name  ' . (($editMode) ? 'Updated' : 'Saved') . '...'));
        }
        return createJSONResponse($this->message);
    }
	function getGrid(){
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        $objFilter->SQL = 'SELECT * FROM '. $this->dm__category .' ';
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL;
        //exit;
        if($objFilter->RESULT){
            foreach($objFilter->RESULT as $row){
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->ID) . '"');
                array_push($fieldValues, '"' . addslashes($row->SECTION_NAME) . '"');
                array_push($fieldValues, '"' . addslashes($row->SECTION_NAME_HINDI) . '"');
              	// array_push($fieldValues, '"' . addslashes($row->STATUS) . '"');
                //array_push($fieldValues, '"' . addslashes( ($row->STATUS ==1 ) ?" Active" :"InActive"  ) . '"');
                array_push($fieldValues, '"' . addslashes( $this->showButton($row->ID,$row->STATUS) ) . '"');
                array_push($objFilter->ROWS, '{"id":"' . $row->ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
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

    public function Active($data){
        $update = $this->db->update($this->dm__sections,array('STATUS' => $data['STATUS']), array('ID' => $data['ID']));
        if($update)
        $this->db->update($this->dm__category,array('STATUS' => $data['STATUS']), array('SECTION_ID' => $data['ID']));
        $this->db->update($this->dm__files,array('STATUS' => $data['STATUS']), array('SECTION_ID' => $data['ID']));
        return $update;
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
        $arrFields = $this->getSectionData();
        //showArrayValues($arrFields);
        $arrData = array();
        if($id == 0){
            foreach($arrFields as $val){
                if ($val == 'id') 
                    $arrData[$val] = 0;
                }
        }else{
            $this->db->select('*')
                ->from($this->dm__sections)
                ->where('ID', $id);
            $recs = $this->db->get();
            if($recs && $recs->num_rows()){
                $rec = $recs->row();
                foreach($arrFields as $val){
                    $arrData[$val] = $rec->{$val};  
                    }
                $recs->free_result();
            }
            
        return $arrData;
    }  
  }

  public function getAllSections(){
    $arrSections = array();
    $recs = $this->db->select("*")
            ->from($this->dm__sections)
            ->get();
    if($recs && $recs->num_rows()){
        foreach($recs->result() as $rec){
            $arrSections[]= 
                array(
                        'ID'=>$rec->ID, 
                        'SECTION_NAME'=>$rec->SECTION_NAME, 
                        'SECTION_NAME_HINDI'=>$rec->SECTION_NAME_HINDI,
                        'CAT_TREE' => $this->cateSubcatTableMenu($rec->ID)
                );
        }
    }
    return $arrSections;
  }

  function cateSubcatTableMenu($sectionId=NULL, $parent = 0, $spacing = '&nbsp;&nbsp;', $user_tree_array = '') {
      if (!is_array($user_tree_array))
        $user_tree_array = array();
        $recs = $this->db->select('*')
                ->from($this->dm__category)
                ->where(array('SECTION_ID'=>$sectionId,'PARENT_CATE_ID'=>$parent))
                ->order_by('ID','ASC')
                ->get();

        if($recs && $recs->num_rows()){
            foreach($recs->result() as $rec){
                
                $user_tree_array[] = array("id" => $rec->ID,"name" => $spacing . 
                    '<input type="checkbox" name="menu[]" value="'.$rec->ID.'" >  '.$rec->CATEGORY_ENG);

                $user_tree_array = $this->cateSubcatTableMenu($rec->SECTION_ID,$rec->ID, $spacing. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $user_tree_array);
            }
            $recs->free_result();
        }
      return $user_tree_array;
    }
}
?>