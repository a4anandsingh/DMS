<?php date_default_timezone_set('Asia/Kolkata');
class Dms__cate__m extends CI_Model
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
        //showArrayValues($arrValues);//exit();
        if($id == 0){
            $editMode = 0;
            $this->db->insert($this->dm__category, $arrValues);
            $id=$this->db->insert_id();
        }else{
            $editMode = 1;
            $this->db->update($this->dm__category, $arrValues, array('ID' => $id));
        }
        // get path in ID (int)
        $parentPath=$this->getParentPath($arrValues['PARENT_CATE_ID']);
    
        //get path in text format
        $arrPath= explode('/', $parentPath);
        $arrPathReverse= array_reverse($arrPath);

        $arrCategoryName = array();
        foreach ($arrPathReverse as $key => $value) {
            if($value == ''){
                continue ;
            }
            $arrCategoryName[] = $this->getCategoryName($value);
        }
        $HIERARCHY_PATH_TEXT = implode('/', $arrCategoryName);

        $arr=array(
            "HIERARCHY_PATH"=>$id.'/'.$parentPath,
            "HIERARCHY_PATH_TEXT" => $HIERARCHY_PATH_TEXT
        );

        $this->db->update($this->dm__category, $arr, array('ID' => $id));

        if($this->db->affected_rows()){
            array_push($this->message, getMyArray(true, 'Category Name  ' . (($editMode) ? 'Updated' : 'Saved') . '...'));
        }
        return createJSONResponse($this->message);
    }
    function getSectionGrid(){
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        $objFilter->SQL = 
            'SELECT * FROM '. $this->dm__category .' where PARENT_CATE_ID=0';
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL;
        //exit;
        if($objFilter->RESULT){
            foreach($objFilter->RESULT as $row){
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->ID) . '"');
                array_push($fieldValues, '"' . addslashes($row->CATEGORY_ENG) . '"');
                array_push($fieldValues, '"' . addslashes($row->CATEGORY_HINDI) . '"');
                array_push($fieldValues, '"' . addslashes( $this->showButton($row->ID,$row->STATUS,0) ) . '"');
                array_push($objFilter->ROWS, '{"id":"' . $row->ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }
    function getCategoryGrid(){
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        /*$objFilter->SQL = 
            'SELECT category.*, 
                sections.SECTION_NAME,  sections.SECTION_NAME_HINDI 
            FROM 
            '. $this->dm__category .' category
        LEFT JOIN '.$this->dm__sections.' sections ON sections.ID = category.SECTION_ID';*/
        $objFilter->SQL = 
            'SELECT cat.*,cat2.CATEGORY_ENG as SECTION_NAME FROM '. $this->dm__category .' cat
            INNER JOIN '.$this->dm__category.' cat2 ON cat2.ID = cat.SECTION_ID
            where cat.PARENT_CATE_ID!=0';
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL;
        //exit;
        if($objFilter->RESULT){
            foreach($objFilter->RESULT as $row){
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->ID) . '"');
                array_push($fieldValues, '"' . addslashes($row->CATEGORY_ENG) . '"');
                array_push($fieldValues, '"' . addslashes($row->CATEGORY_HINDI) . '"');
                array_push($fieldValues, '"' . addslashes($row->SECTION_NAME) . '"');
                array_push($fieldValues, '"' . str_replace("/", " >> ",$row->HIERARCHY_PATH_TEXT) . '"');
                array_push($fieldValues, '"' . addslashes( $this->showButton($row->ID,$row->STATUS,1) ) . '"');
                array_push($objFilter->ROWS, '{"id":"' . $row->ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }
    private function showButton($id,$status,$type){
        if($status==1){
            return getButton('In-Active', 'Active(2,' . $id . ','.$type.')', 4, '');
        }else{
            return getButton('Active', 'Active(1,' . $id . ','.$type.')', 4, '');
        }
        
    }
    
    public function ActiveCategory($data){
        return $this->db->update($this->dm__category,array('STATUS' => $data['STATUS']), array('ID' => $data['ID']));
    }
    public function ActiveSection($data){
       // return $this->db->update($this->dm__category,array('STATUS' => $data['STATUS']), array('ID' => $data['ID']));
        $update = $this->db->update($this->
            array('STATUS' => $data['STATUS']), array('ID' => $data['ID']));
        if($update)
        $this->db->update($this->dm__category,array('STATUS' => $data['STATUS']), array('SECTION_ID' => $data['ID']));
        $this->db->update($this->dm__files,array('STATUS' => $data['STATUS']), array('SECTION_ID' => $data['ID']));
        return $update;
    }
    public function getSectionData(){
        return $this->getFields($this->dm__category); //db table name 
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
        // showArrayValues($arrData); exit;
        return $arrData;
    }

    public function section_pulldown($sectionId){
        $opt = '';
        $arrFields = $this->getFields($this->dm__category);
        $this->db->select('*');
        $this->db->from($this->dm__category);
        $this->db->where(array('PARENT_CATE_ID'=>0,'STATUS !='=>2));
        $recs = $this->db->get();
        //echo $this->db->last_query();
        $opt = '<option value="">Select Section</option>';
        foreach($recs->result() as $row ){
            $opt .= '<option '. ($sectionId==$row->ID? "selected ='selected'":"") .' value="'.$row->ID.'" title="'.$row->CATEGORY_ENG.' ('.$row->CATEGORY_HINDI.')">'.
            $row->CATEGORY_ENG.' ('.$row->CATEGORY_HINDI.') </option>';
        }
        return $opt;
    }

    function cateSubcatTable($parent = 0, $spacing = '&nbsp;&nbsp;', $user_tree_array = '') {
        if (!is_array($user_tree_array))
        $user_tree_array = array();
        $recs = $this->db->select('*')
                ->from($this->dm__category)
                ->where(array('PARENT_CATE_ID'=>$parent))
                ->order_by('ID','ASC')
                ->get();
                //echo $this->db->last_query();
        if($recs && $recs->num_rows()){
            foreach($recs->result() as $rec){
                $user_tree_array[] = array("id" => $rec->ID, "name" => $spacing . ' → '.$rec->CATEGORY_ENG,"parent_id"=>$rec->PARENT_CATE_ID);
                $user_tree_array = $this->cateSubcatTable($rec->ID, $spacing. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $user_tree_array);
            }
            $recs->free_result();
        }
      return $user_tree_array;
    }

    public function getCategoryId($where){
        $menu_cat_id=0;
        $recs = $this->db->select('ID')
                ->from($this->dm__category)
                ->where($where)
                ->get();
        if($recs && $recs->num_rows()){
            $menu_cat_id=$recs->row()->ID;
        }
        return $menu_cat_id;
    }
    public function getmaxcatId(){
        $this->db->select('MAX(ID) as ID')
            ->from($this->dm__category);
        $recs = $this->db->get();
        $count=0;
        if($recs && $recs->num_rows()){
            $rec = $recs->row();
            $count = $rec->ID;
            $recs->free_result();
        }
        return $count+1;
    }


protected function getParentPath($id){
    $this->db->select('*')
        ->from($this->dm__category)
        ->where('ID', $id);
    $recs = $this->db->get();
    if($recs && $recs->num_rows()){
        $rec = $recs->row();
        return ($rec->HIERARCHY_PATH);
        $recs->free_result();
    }else return('');
}
public function getPath($id){
    $path='';
     $this->db->select('HIERARCHY_PATH')
            ->from($this->dm__category)
            ->where('ID', $id);
        $recs = $this->db->get();
        //echo $this->db->last_query();
        //exit();
        if($recs && $recs->num_rows()){
            $rec = $recs->row();
            $path=$rec->HIERARCHY_PATH;
            $recs->free_result();
        }
        $arrPath= explode('/', $path);
        //echo "string";
        return array_reverse($arrPath);
}
public function getSlug($id){
         $this->db->select('SLUG')
                ->from($this->dm__category)
                ->where('ID', $id);
            $recs = $this->db->get();
            $slug='';
            if($recs && $recs->num_rows()){
                $rec = $recs->row();
                $slug=$rec->SLUG;
                $recs->free_result();
            }
            return $slug;
}

    protected function getCategoryName($categoryId){
        $recs = $this->db->select("CATEGORY_ENG")
                    ->from("dm__category")
                    ->where("ID", $categoryId)              
                    ->get();
        if($recs && $recs->num_rows()){
            $rec = $recs->row();
            return $rec->CATEGORY_ENG;
        }
    }

}
?>