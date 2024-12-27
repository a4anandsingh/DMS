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
    function get_category_data($sectionId){
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
        $this -> db -> select('*');
        $this -> db -> where('PARENT_CATE_ID',"0"); 
            $this -> db -> from('dm__category');        
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
    function get_filesCountByCat($CATEGORY_ID){    
        $this-> db->select('*');
        $this -> db -> where('CATEGORY_ID',$CATEGORY_ID);       
        $this -> db -> from('dm__files');       
        $query = $this ->db->get();
        $q=$this->db->last_query();
        //print_r($q);      
        return $query->num_rows();
    }    
    function get_filesByCat($CATEGORY_ID=null){    
        $this-> db->select('*');
        $this -> db -> where('CATEGORY_ID',$CATEGORY_ID);       
        $this -> db -> from('dm__files');       
        $query = $this ->db->get(); 
        $q=$this->db->last_query();
        //print_r($q);      
        return $query->result_array();
    }
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
    }
    // 24 sept ends here!!!
}
?>