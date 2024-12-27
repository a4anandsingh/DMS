<?php date_default_timezone_set('Asia/Kolkata');
class Dms__searche__m extends CI_Model
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
  /*public function section_pulldown($sectionId=null){
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
    public function section_pulldown($sectionId=null){
        $opt = '';
        $arrFields = $this->getFields($this->dm__category);
        $this->db->select('*');
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
        return $opt;
    }
function cateSubcatTable( $parent = 0, $spacing = '&nbsp;&nbsp;', $user_tree_array = '') {
  if (!is_array($user_tree_array))
    $user_tree_array = array();
    $recs = $this->db->select('*')
            ->from($this->dm__category)
            ->where(array('PARENT_CATE_ID'=>$parent))
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

/*function searchResult($FETCH){
    $search='';
    $this->db->select('*');
    $this->db->where(array('SECTION_ID'=>$FETCH['SECTION'],'CATEGORY_ID'=>$FETCH['CATEGORY']));
    $recs = $this->db->get('dm__files');
    if($recs && $recs->num_rows()){
        $recss = $recs->result();
         foreach ($recss  as $rec) {
          $search[]=$rec;
            }
        
        }
    return $search;

    }*/

/*
$where = ($FETCH['SECTION']==0)? '' : ( ($FETCH['SECTION']=='') ? '':' ').'SECTION_ID='.$FETCH['SECTION'];
$where.= ($FETCH['CATEGORY']==0)? '' : ( ($FETCH['CATEGORY']=='') ? '':' AND ').'CATEGORY_ID='.$FETCH['CATEGORY'];
$where.= ($FETCH['FILE_NAME_ENG']=='')? '' : ( ($FETCH['FILE_NAME_ENG']=='') ? '':' AND ').'FILE_NAME_ENG="'.$FETCH['FILE_NAME_ENG'].'"';
*/

function searchResult($FETCH){
    /*$this->db->select('*');
        $this->db->from('dm__files');
        $this->db->where("LETTER_DATE  BETWEEN '".$FETCH["START_DATE"] ."' and '". $FETCH["END_DATE"]."'");
        $query = $this->db->get(); 
        echo $this->db->last_query();
        exit();*/
    $search= $where ='';

    if ($FETCH['CHK_RADIO']==1){
        $where = ($FETCH['FILE_NAME']=='')? '' : 'FILE_NAME_ENG LIKE "%'.$FETCH['FILE_NAME'].'%" OR FILE_NAME_HINDI LIKE "%'.$FETCH['FILE_NAME'].'%"';
    }elseif ($FETCH['CHK_RADIO']==2){
        $where = ($FETCH['LETTER_NO']=='')? '' : 'LETTER_NO="'.$FETCH['LETTER_NO'].'"';
    }elseif ($FETCH['CHK_RADIO']==3){
        $where = "LETTER_DATE  BETWEEN '".$FETCH["START_DATE"] ."' and '". $FETCH["END_DATE"]."'";
    }
    $where.= ($FETCH['SECTION']==0)? '' : ' AND `SECTION_ID`='.$FETCH['SECTION'].'';
    $where.= ($FETCH['CATEGORY']==0)? '' : ' AND CATEGORY_ID='.$FETCH['CATEGORY'].'';

    /*if ($FETCH['SECTION']==0 && $FETCH['CATEGORY']==0 && $FETCH['FILE_NAME_ENG'] !=''){
        //$where = ($FETCH['FILE_NAME_ENG']=='')? '' : 'FILE_NAME_ENG="'.$FETCH['FILE_NAME_ENG'].'"';
        $where = ($FETCH['FILE_NAME_ENG']=='')? '' : 'FILE_NAME_ENG LIKE "%'.$FETCH['FILE_NAME_ENG'].'%"';
    }elseif($FETCH['SECTION']==0 && $FETCH['CATEGORY']==0 && $FETCH['LETTER_NO'] !=''){
        $where = ($FETCH['LETTER_NO']=='')? '' : 'LETTER_NO="'.$FETCH['LETTER_NO'].'"';
    }elseif($FETCH['SECTION']==0 && $FETCH['CATEGORY']==0 && $FETCH['START_DATE'] !='' && $FETCH['END_DATE'] !=''){
        $where = "LETTER_DATE  BETWEEN '".$FETCH["START_DATE"] ."' and '". $FETCH["END_DATE"]."'";
    }else{
        $where = ($FETCH['SECTION']==0)? '' : 'SECTION_ID='.$FETCH['SECTION'];
        $where.= ($FETCH['CATEGORY']==0)? '' : ' AND CATEGORY_ID='.$FETCH['CATEGORY'];
        //$where.= ($FETCH['FILE_NAME_ENG']=='')? '' : ' AND FILE_NAME_ENG="'.$FETCH['FILE_NAME_ENG'].'"';
        $where.= ($FETCH['FILE_NAME_ENG']=='')? '' : ' AND FILE_NAME_ENG LIKE "%'.$FETCH['FILE_NAME_ENG'].'%"';
        $where.= ($FETCH['LETTER_NO']=='')? '' : ' AND LETTER_NO="'.$FETCH['LETTER_NO'].'"';
        $where.= ($FETCH['START_DATE']=='' || $FETCH["END_DATE"]=='')? '' : ' AND LETTER_DATE  BETWEEN "'.$FETCH["START_DATE"] .'" and "'.$FETCH["END_DATE"].'"';
        //$where.= " AND LETTER_DATE  BETWEEN '".$FETCH["START_DATE"] ."' and '". $FETCH["END_DATE"]."'";
    }*/
    /*if ($FETCH['SECTION']>0 || $FETCH['CATEGORY']>0 || $FETCH['FILE_NAME_ENG'] !='' || $FETCH['LETTER_NO'] !='' || $FETCH['START_DATE'] !='' || $FETCH['END_DATE'] !=''){
        $where = ($FETCH['SECTION']==0)? '' : 'SECTION_ID='.$FETCH['SECTION'];
        $where.= ($FETCH['CATEGORY']==0)? '' : ' AND CATEGORY_ID='.$FETCH['CATEGORY'];
        $where.= ($FETCH['FILE_NAME_ENG']=='')? '' : ' AND FILE_NAME_ENG LIKE "%'.$FETCH['FILE_NAME_ENG'].'%"';
        $where.= ($FETCH['LETTER_NO']=='')? '' : ' AND LETTER_NO="'.$FETCH['LETTER_NO'].'"';
        $where.= " AND LETTER_DATE  BETWEEN '".$FETCH["START_DATE"] ."' and '". $FETCH["END_DATE"]."'";
    }*/
    $this->db->select('*');
    //$this->db->where(array('SECTION_ID'=>$FETCH['SECTION'],'CATEGORY_ID'=>$FETCH['CATEGORY'], 'FILE_NAME_ENG'=>$FETCH['FILE_NAME_ENG']));
    $this->db->where($where);
    $this->db->where('STATUS',1); 
    $recs = $this->db->get('dm__files');
    //echo $this->db->last_query();exit();
    if($recs && $recs->num_rows()){
        $recss = $recs->result();
         foreach ($recss  as $rec) {
          $search[]=$rec;
            }
        
        }
    return $search;

    }
}

?>
