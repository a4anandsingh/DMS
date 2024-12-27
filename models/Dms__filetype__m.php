<?php date_default_timezone_set('Asia/Kolkata');
class Dms__filetype__m extends CI_Model
{
	var $message;
	function __construct()
	{
	  	parent::__construct();
	    $this->message = array();
	    $this->dm_files = 'dm__files';
      	$this->dm__sections = 'dm__sections';
        $this->dm__sections = 'dm__category';
        $this->dm__filetype = 'dm__filetype';
        $this->dm__filetype_master = 'dm__filetype_master';
	}
	/*function saveData($arrValues){
		//showArrayValues($arrValues);
		$this->db->insert($this->dm__sections, $arrValues);
		//echo $this->db->last_query();
	}*/
    function saveData($id, $arrValues){
        //showArrayValues($arrValues);exit();
        if($id == 0){
            $editMode = 0;
            $this->db->insert($this->dm__filetype, $arrValues);
        }else{
            $editMode = 1;
            $this->db->update($this->dm__filetype, $arrValues, array('ID' => $id));
        }
        if($this->db->affected_rows()){
            array_push($this->message, getMyArray(true, 'Filetype Data ' . (($editMode) ? 'Updated' : 'Saved') . '...'));
        }
        return createJSONResponse($this->message);
    }
	function getGrid(){
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        $objFilter->SQL = 'SELECT * FROM '. $this->dm__filetype .' ';
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL;
        //exit;
        if($objFilter->RESULT){
            foreach($objFilter->RESULT as $row){
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->ID) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILETYPE_NAME) . '"');
                array_push($fieldValues, '"' . addslashes($row->MAX_FILE_SIZE) . '"');
                array_push($fieldValues, '"' . addslashes($row->MAX_UPLOAD_SIZE) . '"');
                //array_push($fieldValues, '"' . addslashes($row->STATUS) . '"');
                array_push($objFilter->ROWS, '{"id":"' . $row->ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }
    public function getFiletypeData(){
        return $this->getFields($this->dm__filetype); //db table name 
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
        $arrFields = $this->getFiletypeData();
        //showArrayValues($arrFields);
        $arrData = array();
        if($id == 0){
            foreach($arrFields as $val){
                if ($val == 'ID') {
                    $arrData[$val] = 0;
                }else{
                    $arrData[$val] = "";
                }
            }
        }else{
            $this->db->select('*')
                ->from($this->dm__filetype)
                ->where('ID', $id);
            $recs = $this->db->get();
            if($recs && $recs->num_rows()){
                $rec = $recs->row();
                foreach($arrFields as $val){
                    $arrData[$val] = $rec->{$val};  
                }
                $recs->free_result();
            }

        $arrData['allFileTypes'] = $this->getAllFilesTypes();
        //showArrayValues($arrData['allFileTypes']); exit;
        // showArrayValues($arrData); exit;
       
    }  
     return $arrData;
  }

  protected function getAllFilesTypes(){
    $recs = $this->db->select("*")
                ->from($this->dm__filetype_master)
                ->where("status",1)
                ->get();
    $arrNames = array();
    if($recs && $recs->num_rows()){
      foreach($recs->result() as $rec){
        $arrNames[$rec->ID] = array(
                "ID"=>$rec->ID,
                "EXTENSION"=>$rec->EXTENSION,
                "DOCUMENT_TYPE"=>$rec->DOCUMENT_TYPE,
                "MIME_TYPE"=>$rec->MIME_TYPE
            );
        $recs->free_result();
      }
    }
    return $arrNames;  
  }
}
?>