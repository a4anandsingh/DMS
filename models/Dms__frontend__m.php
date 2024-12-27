<?php date_default_timezone_set('Asia/Kolkata');
class Dms__frontend__m extends CI_Model
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
    public function get_section_data(){
        $arrFields = $this->getFields($this->dm__category);
        $this->db->select('*');
        $this->db->from($this->dm__category);
        /*$this->db->where("STATUS !=",2);*/
        $this->db->where(array('PARENT_CATE_ID'=>0,'STATUS !='=>2));
        $recs = $this->db->get();
        //echo $this->db->last_query();
        return $recs->result();
    }
    public function get_category_data($sectionId){
        $arrData =array();
        $recs = $this->db->select("ID,CATEGORY_ENG")
                    ->from("dm__category")
                    ->where($sectionId)
                    ->get();
        if($recs && $recs->num_rows()){
            foreach($recs->result() as $rec){
                array_push($arrData,$rec);
           }
        }
        return $arrData;
    }
    
    public function get_files($categoryId){
        $this->db->select('*');
        $this->db->from($this->dm__files);
        $this->db->where(array('CATEGORY_ID'=>$categoryId,"STATUS !="=>2));
        $recs = $this->db->get();
        //echo $this->db->last_query();
        return $recs->result();
    }
    //menu code starts here-----
    public function allct(){  
        $this->db->select('*');
        $this->db->where('PARENT_CATE_ID',"0"); 
        $this->db->from('dm__category');        
        $query = $this ->db->get();         
        return $query->result_array();
    }

    public function allct_in($id){   
        $this -> db -> select('*');
        $this -> db -> where('PARENT_CATE_ID',$id); 
        $this -> db -> from('dm__category');        
        $query = $this ->db->get();         
        return $query->result_array();
    }

    public function getmenu_master($ID=null){
        if($ID==null){
           return $this->db->select("*")->from("dm__menu_master")->get()->result_array();
        }else{
            return $this->db->select("*")->from("dm__menu_master")->where(["STATUS"=>$ID])->get()->row_array();
        }
    }

    public function get_categoryBYID($ID=null){       
        return $this->db->select("*")->from("dm__category")->where(["ID"=>$ID])->get()->row_array();
    }
    //menu code ends here-----

    //24 sept starts here
    public function get_category($ID=null){
        if($ID==null){
           return $this->db->select("*")->from("dm__category")->where(["PARENT_CATE_ID"=>'0'],["STATUS"=>'1'])->get()->result_array();
        }else{
            return $this->db->select("*")->from("dm__category")->where(["SLUG"=>$ID],["status"=>'1'])->get()->row_array();
        }

    }
    /*Start 27th April 2022*/
    public function get_categorytext($ID=null,$SECTION_ID=0){
       
       if($ID==null){
           return $this->db->select("*")->from("dm__category")->where(["PARENT_CATE_ID"=>'0'],["STATUS"=>'1'])->get()->result_array();
        }else{
            $this->db->where('SLUG',$ID);
            $this->db->where('STATUS',"1");
            //$this->db->where('SECTION_ID',$SECTION_ID);
        $this-> db->select('*');
        $this -> db -> from('dm__category');        
        $query = $this ->db->get();         
        return $query->row_array();
           // return $this->db->select("*")->from("dm__category")->where(["SLUG"=>$ID],["SECTION_ID"=>$SECTION_ID],["status"=>'1'])->get()->row_array();
        }

    }
    public function get_section($ID=null){
        if($ID==null){
           return $this->db->select("*")->from("dm__sections")->where(["SLUG"=>'0'],["STATUS"=>'1'])->get()->result_array();
        }else{
       return $this->db->select("*")->from("dm__sections")->where(["SLUG"=>$ID],["status"=>'1'])->get()->row_array();
   // return  $this->db->last_query(); 
      }

    }
    public function get_sectionfromcat($ID=null){
        if($ID==null){
           return $this->db->select("*")->from("dm__category")->where(["SLUG"=>'0'],["STATUS"=>'1'])->get()->result_array();
        }else{
       return      $this->db->select("*")->from("dm__category")->where(["HIERARCHY_SLUG"=>$ID],["status"=>'1'])->get()->row_array();
   // return  $this->db->last_query(); 
      }

    }
    public function get_categoryc($ID=null,$section_id=null){
        if($ID==null){
           return $this->db->select("*")->from("dm__category")->where(["PARENT_CATE_ID"=>'0'],["STATUS"=>'1'])->get()->result_array();
        }else{
            return $this->db->select("*")->from("dm__category")->where(["section_ID"=>$ID],["status"=>'1'])->get()->row_array();
        }

    }
    /*End 27th April 2022*/
    public function get_category_bysection($ID=null){
        if($ID ==null){
           return $this->db->select("*")->from("dm__category")->where(["PARENT_CATE_ID"=>'0'],["STATUS"=>'1'])->get()->result_array();
        }else{
            return $this->db->select("*")->from("dm__category")->where(["PARENT_CATE_ID"=>$ID],["status"=>'1'])->get()->row_array();
        }
    }
    public function get_subcategory($cat=null){
        if($cat !=null){
           return $this->db->select("*")->from("dm__category")->where(["PARENT_CATE_ID"=>$cat],["STATUS"=>'1'])->get()->result_array();
        }
    } 

    /* Start 09 feb 2022 to fetch section name from category id : for search module in frontend*/
    public function get_section_name($categoryId){
        $arrData ='';
        $recs = $this->db->select("CATEGORY_ENG")
                    ->from("dm__category")
                    ->where(array('PARENT_CATE_ID'=>0,'ID'=>$categoryId))
                    ->get();
        if($recs && $recs->num_rows()){
            foreach($recs->result() as $rec)
            $arrData=$rec->CATEGORY_ENG;
        }
        return $arrData;
    }
    public function searchResult($FETCH,$limit=null,$page=null){
        $search= $where ='';
        $where = '  STATUS = 1 AND ACCESS_LEVEL IN (1,3)  ';
        if ($FETCH['CHK_RADIO']==1){
            $where.= ($FETCH['FILE_NAME']=='')? '' : 'AND FILE_NAME_ENG LIKE "%'.$FETCH['FILE_NAME'].'%" OR FILE_NAME_HINDI LIKE "%'.$FETCH['FILE_NAME'].'%"';
            $where.= ($FETCH['SECTION']=='')? '' : ' AND `SECTION_ID`='.$FETCH['SECTION'].'';
        }elseif ($FETCH['CHK_RADIO']==2){
            $where.= ($FETCH['LETTER_NO']=='')? '' : 'AND LETTER_NO="'.$FETCH['LETTER_NO'].'"';
            $where.= ($FETCH['SECTION']=='')? '' : ' AND `SECTION_ID`='.$FETCH['SECTION'].'';
        }elseif ($FETCH['CHK_RADIO']==3){
            if(empty($FETCH['SESSION'])){
            $where.= "AND LETTER_DATE  BETWEEN '".$FETCH["START_DATE"] ."' and '". $FETCH["END_DATE"]."'";
            $where.= ($FETCH['SECTION']=='')? '' : ' AND `SECTION_ID`='.$FETCH['SECTION'].'';
        }else{
$dt=explode("-",$FETCH['SESSION']);
         $start_date=$dt["0"]."-4-1";
         $end_date=$dt["1"]."-3-31";
            $where.= "AND LETTER_DATE  BETWEEN '".$start_date ."' and '". $end_date."'";
            $where.= ($FETCH['SECTION']=='')? '' : ' AND `SECTION_ID`='.$FETCH['SECTION'].'';
        
        }
        }elseif (!empty($FETCH['SESSION'])){
         $dt=explode("-",$FETCH['SESSION']);
         $start_date=$dt["0"]."-4-1";
         $end_date=$dt["1"]."-3-31";
            $where.= "AND LETTER_DATE  BETWEEN '".$start_date ."' and '". $end_date."'";
            $where.= ($FETCH['SECTION']=='')? '' : ' AND `SECTION_ID`='.$FETCH['SECTION'].'';
        
        }else{
            $where.= ($FETCH['SECTION']=='')? '' : ' `SECTION_ID`='.$FETCH['SECTION'].'';
        }
        $where.= ($FETCH['CATEGORY']=='')? '' : ' AND CATEGORY_ID='.$FETCH['CATEGORY'].'';

        /*$this->db->select('*');
        $this->db->where($where);
        $this->db->where('STATUS',1); 
        $recs = $this->db->get('dm__files');
        //echo $this->db->last_query();//exit();
        if($recs && $recs->num_rows()){
            $recss = $recs->result();
             foreach ($recss  as $rec) {
              $search[]=$rec;
                }
            }
        return $search;*/

        $this-> db->select('*');
        $this -> db -> where($where);       
        $this -> db -> from('dm__files');
        //$this-> db->limit($limit, $page);
        $query = $this ->db->get(); 
       // $this->db->last_query();
        //print_r($q);        //exit();      
        return $query->result_array();
    }
    public function get_filesCountBySearch($FETCH){ 
        $search= $where ='';
        $where = ' STATUS = 1 AND ACCESS_LEVEL IN (1,3) AND ';
        if ($FETCH['CHK_RADIO']==1){
            $where.= ($FETCH['FILE_NAME']=='')? '' : 'FILE_NAME_ENG LIKE "%'.$FETCH['FILE_NAME'].'%" OR FILE_NAME_HINDI LIKE "%'.$FETCH['FILE_NAME'].'%"';
            $where.= ($FETCH['SECTION']=='')? '' : ' AND `SECTION_ID`='.$FETCH['SECTION'].'';
        }elseif ($FETCH['CHK_RADIO']==2){
            $where.= ($FETCH['LETTER_NO']=='')? '' : 'LETTER_NO="'.$FETCH['LETTER_NO'].'"';
            $where.= ($FETCH['SECTION']=='')? '' : ' AND `SECTION_ID`='.$FETCH['SECTION'].'';
        }elseif ($FETCH['CHK_RADIO']==3){
            $where.= "LETTER_DATE  BETWEEN '".$FETCH["START_DATE"] ."' and '". $FETCH["END_DATE"]."'";
            $where.= ($FETCH['SECTION']=='')? '' : ' AND `SECTION_ID`='.$FETCH['SECTION'].'';
        }else{
            $where.= ($FETCH['SECTION']==0)? '' : ' `SECTION_ID`='.$FETCH['SECTION'].'';
        }
        $where.= ($FETCH['CATEGORY']=='')? '' : ' AND CATEGORY_ID='.$FETCH['CATEGORY'].'';
        //$where.= ' AND STATUS = 1 AND ACCESS_LEVEL = 3';
        //$where.= ' AND STATUS != 2, AND ACCESS_LEVEL = 3'; wrong code not working with status
        //$where.= '  AND STATUS != 2';
        $this-> db->select('*');
        $this -> db -> from('dm__files');  
        $this -> db -> where($where);     
        $query = $this ->db->get();
        //echo $this->db->last_query();
        //print_r($q);      
        return $query->num_rows();
    }  
    /* End 09 feb 2022 to fetch section name from category id : for search module in frontend*/


    public function get_filesCountByCat($CATEGORY_ID){ 
        $this-> db->select('*');
        $this -> db -> where('CATEGORY_ID',$CATEGORY_ID);
        $this -> db -> where('STATUS',1); //Added by Pawan 11/12/2024 to show only published files
        $this -> db -> from('dm__files');       
        $query = $this ->db->get();
        //$q=$this->db->last_query();
        //print_r($q);      
        return $query->num_rows();
    }    

    /*Start 27th April 2022
    function get_filesByCat($CATEGORY_ID=null,$limit=null,$page=null){  
        $this-> db->select('*');
        $this -> db -> where(array('CATEGORY_ID'=>$CATEGORY_ID,"STATUS !="=>2));   //,'ACCESS_LEVEL'=>3    
        $this -> db -> where_in('ACCESS_LEVEL',array(1,3));       
        $this -> db -> from('dm__files');
        $this-> db->limit($limit, $page);
        $query = $this ->db->get(); 
        $q=$this->db->last_query();
        //print_r($q);        //exit();      
        return $query->result_array();
    } End 27th April 2022*/
    
    /*Start 27th April 2022*/
    function get_filesByCat($CATEGORY_ID=null,$section_ID=null){  
        $this-> db->select('*');
        $this -> db -> where(array('CATEGORY_ID'=>$CATEGORY_ID,"STATUS ="=>1));   //,'ACCESS_LEVEL'=>3    
        $this -> db -> where_in('ACCESS_LEVEL',array(1,3));  
        if($section_ID !=null || $section_ID !=""){
        $this -> db -> where('SECTION_ID',$section_ID);       
        }
        $this -> db -> from('dm__files');
       // $this-> db->limit($limit, $page);
        $query = $this ->db->get(); 
        $q=$this->db->last_query();
       // print_r($q);         exit();      
        return $query->result_array();
    }
    /*End 27th April 2022*/
     

    function getSingleCategoryBYname($name=null){    
        $this-> db->select('*');
        $this -> db -> where('status','1'); 
        $this -> db -> where('SLUG',$name);     
        $this -> db -> from('dm__category');        
        $query = $this ->db->get();         
        return $query->row_array();
    }
    function get_sections($CATEGORY_ID=null){    
        $this-> db->select('*');
        $this -> db -> where('status','1');     
        $this -> db -> from('dm__sections');        
        $query = $this ->db->get();         
        return $query->result_array();
    }
    function main_memucat(){
        $this -> db -> select('*');
        $this -> db -> from('dm__category');        
        $query = $this ->db->get();         
        return $query->result();
    }function sessionRange(){
        $this -> db -> select('*');
       $this -> db -> where('SESSION_START_YEAR <=',date("Y"));
       $this -> db -> where('SESSION_START_YEAR >=',date("2010"));// added on 22-07-2022 kaushik to restrict session dropdwon        

        $this -> db -> from('__sessions');        
        $query = $this ->db->get();         
        return $query->result_array();
    }
    
    function OfficeList(){
        $this -> db -> select('*');
        $this -> db -> from('__offices');        
        $query = $this ->db->get();         
        return $query->result();
    }
    
    // function get_categoryBYID($CATEGORY_ID=null){    
        // $this-> db->select('*');
        // $this -> db -> where('status','1');  
        // $this -> db -> where('ID',$CATEGORY_ID);     
        // $this -> db -> from('dm__category');        
        // $query = $this ->db->get();         
        // return $query->row_array();
    // }
    
     public function advance_searchResult($FETCH,$limit=null,$page=null){
        $search= $where ='';
        $where = '  STATUS = 1 AND ACCESS_LEVEL IN (1,3,2)  ';
        if ($FETCH['CHK_RADIO']==1){
            $where.= ($FETCH['FILE_NAME']=='')? '' : 'AND FILE_NAME_ENG LIKE "%'.$FETCH['FILE_NAME'].'%" OR FILE_NAME_HINDI LIKE "%'.$FETCH['FILE_NAME'].'%"';
            
        }elseif ($FETCH['CHK_RADIO']==2){
            $where.= ($FETCH['LETTER_NO']=='')? '' : 'AND LETTER_NO="'.$FETCH['LETTER_NO'].'"';
           
        }elseif ($FETCH['CHK_RADIO']==3){
            if(empty($FETCH['SESSION'])){
            $where.= "AND LETTER_DATE  BETWEEN '".$FETCH["START_DATE"] ."' and '". $FETCH["END_DATE"]."'";
           
        }else{
         $dt=explode("-",$FETCH['SESSION']);
         $start_date=$dt["0"]."-4-1";
         $end_date=$dt["1"]."-3-31";
            $where.= "AND LETTER_DATE  BETWEEN '".$start_date ."' and '". $end_date."'";
           
        
        }
        }elseif (!empty($FETCH['SESSION'])){
         $dt=explode("-",$FETCH['SESSION']);
         $start_date=$dt["0"]."-4-1";
         $end_date=$dt["1"]."-3-31";
            $where.= "AND LETTER_DATE  BETWEEN '".$start_date ."' and '". $end_date."'";
            
        
        }
        if(!empty($FETCH['CATEGORY']) && $FETCH['CATEGORY'] !="All"){
        $where.= ($FETCH['CATEGORY']=='')? '' : ' AND CATEGORY_ID='.$FETCH['CATEGORY'].'';
        }
        if(!empty($FETCH['SECTION_ID']) && $FETCH['SECTION_ID'] !="All"){
        $where.= ($FETCH['SECTION_ID']=='')? '' : ' AND `SECTION_ID`='.$FETCH['SECTION_ID'].'';
        }
        
        if(!empty($FETCH['SEARCH_CE_ID'] && $FETCH['SEARCH_CE_ID'] !="All")){
        $where.= ($FETCH['SEARCH_CE_ID']=='' )? '' : ' AND OFFICE_ID='.$FETCH['SEARCH_CE_ID'].'';
        }
        
        if(!empty($FETCH['SEARECH_KEYWORD'])){
        
        $where.=($FETCH['SEARECH_KEYWORD']=='')? '' : ' AND tags LIKE "%'.$FETCH['SEARECH_KEYWORD'].'%"';
        //$where.= ($FETCH['SEARECH_KEYWORD']=='')? '' : 'OR FILE_NAME_ENG LIKE "%'.$FETCH['SEARECH_KEYWORD'].'%" OR FILE_NAME_HINDI LIKE "%'.$FETCH['SEARECH_KEYWORD'].'%"';
        //$where.= ($FETCH['SEARECH_KEYWORD']=='')? '' : 'AND FILE_NAME_ENG="'.$FETCH['SEARECH_KEYWORD'].'%"';
        $where.= ($FETCH['SEARECH_KEYWORD']=='')? '' : ' OR FILE_NAME_ENG LIKE "'.$FETCH['SEARECH_KEYWORD'].'%" OR FILE_NAME_HINDI LIKE "'.$FETCH['SEARECH_KEYWORD'].'%"';
        }
        //die($where);
        $this-> db->select('*');
        $this -> db -> where($where);       
        $this -> db -> from('dm__files');
        $query = $this ->db->get();
        return $query->result_array();
    }
    
  function cateSubcatTable($parent = 0, $spacing = '&nbsp;&nbsp;', $user_tree_array = '') {
   
      
    $user_tree_array = array();
  
        $this->db->select('*');
            $this->db->from($this->dm__category);
            $this->db->where(array('PARENT_CATE_ID'=>$parent,'status '=>1));
         
            $recs = $this->db->get();   
            
    if($recs && $recs->num_rows()){
        foreach($recs->result() as $rec){
            
            $user_tree_array[] = array("id" => $rec->ID,"name" => $spacing . ' → '.$rec->CATEGORY_ENG);
           
        }
        $recs->free_result();
    }
  return $user_tree_array;
}
}
?>
