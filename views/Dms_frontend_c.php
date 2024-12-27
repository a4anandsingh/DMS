<?php
error_reporting(E_ALL);
class Dms_frontend_c extends MX_Controller
{
	var $message;
    function __construct()
    {
      parent:: __construct();
      $this->message = array();
      
      $this->load->model('dms/Dms__frontend__m');

      /*$this->load->library("pagination");
      $this->load->model('dms/Dms__frontend__m');*/
    }
    function index()
    {
      $data['page_heading'] = pageHeading("Document Management System");
      $data['section'] = $this->Dms__frontend__m->get_sections();
      /*$data["selmenu"]=$this->Dms__frontend__m->getmenu_master(1); ; 
      $selval=explode(",",$data["selmenu"]["MENU_SELECTED"]);*/
         $data["selmenu"]=$this->Dms__frontend__m->getmenu_master(1);
      $this->load->view('dms_frontend_index_view', $data);

     /* {
        $config = array();
        /*$config["base_url"] = base_url() . "index.php/StudentPagination_Controller/index";*/
        //$config["total_rows"] = $this->Dms__frontend__m->get_count();
        //$config["per_page"] = 10;
        //$config["uri_segment"] = 3;

        //$this->pagination->initialize($config);

    
    //$page = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
    
        //$data["links"] = $this->pagination->create_links();

        //$data['files'] = $this->Dms__frontend__m->get_filecount($config["per_page"], $page);

        //$this->load->view('dms/dms_frontend_sub_category_view', $data);}
    
    }
    //24 sept
    public function documents(){
        $id='';$table="dm__category";
      $data[''] ='';
       //   $data['sections']=$this->dms->get_sections();
      $url=$this->uri->segment(1); 
      $data["selmenu"]=$this->Dms__frontend__m->getmenu_master(1);
    
      $data['singlesection']=$this->Dms__frontend__m->getSingleCategoryBYname($url);
          $data["section_name"]=$data['singlesection']["HIERARCHY_PATH_TEXT"];//$this->uri->segment(1); 
        // print_r($data['singlesection']);
        $config = [
                'base_url'=> base_url($url),
                'per_page'=>5,
                'total_rows'=>$this->Dms__frontend__m->count_table_cat($id,$table,$data['singlesection']['ID']),
                'full_tag_open'=>"<ul class='pagination'>",
                'full_tag_close'=>"</ul>",
                'first_tag_open'=>"<li>",
                'first_tag_close'=>"</li>",
                'last_tag_open'=>"<li>",
                'uri_segment'=>2,
                'last_tag_close'=>"</li>",
                'next_tag_open'=>"<li  class='tg-prevpage'>",
                'next_tag_close'=>"</li>",
              
                'prev_tag_open'=>"<li class='tg-prevpage'>",
                'prev_tag_close'=>"</li>",
                'num_tag_open'=>"<li>",
                'num_tag_close'=>"</li>",
                'cur_tag_open'=>"<li class='tg-active'><a>",
                'cur_tag_close'=>"</a></li>"
              ]; 
           $this->pagination->initialize($config);
           $data['category']=$this->Dms__frontend__m->table_values_listing($config['per_page'], $this->uri->segment(2),$table,$data['singlesection']['ID']);      
       $data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category']['ID']);
           $this->load->view('dms_frontend_docs',$data);  
    
    } 
    public function documents_detail(){
     $data['page_heading'] = pageHeading("Document Management System");
     $data[''] ='';
          $data["section_name"]=$this->uri->segment(2);
     $data['sections']=$this->Dms__frontend__m->get_sections();
      $data['category']=$this->Dms__frontend__m->get_category($url); 
          // $data['category']['ID'];
       $data['subcat']=$this->Dms__frontend__m->get_subcategory($data['category']['ID']);
    /// print_r( $data['subcat']);
     if(count($data['subcat'])>0){  // print_r($data['subcat']);
     
    // print_r($data['subcat']);
     $this->load->view('dms_frontend_docs_bysubcat',$data); 
       }else{
       $data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category']['ID']);
     $this->load->view('dms_frontend_docs_bycat',$data); 
     }     
  }
    public function documents_details(){
      $data['page_heading'] = pageHeading("Document Management System");
      $data[''] ='';
      $url=$this->uri->segment(1); 
      $data["selmenu"]=$this->Dms__frontend__m->getmenu_master(1);
    
       if(!empty($url=$this->uri->segment(4)))
       {
        $url=$this->uri->segment(4);
       }elseif(!empty($url=$this->uri->segment(3))){
         
      $url=$this->uri->segment(3);   
         
       }else{
         $url=$this->uri->segment(2);   
       }
      $data['category_ids']=$this->Dms__frontend__m->get_category($url);
     // print_r($data['category_ids']);
      $data['category']=$this->Dms__frontend__m->get_category_bysection($data['category_ids']["ID"]);
      $data['category_name']=$this->uri->segment(3);   
      $data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category']['ID']);
          
       $data['subcat']=$this->Dms__frontend__m->get_subcategory($data['category_ids']["ID"]);
    
     if(count($data['subcat'])>0){
       
    $data["section_name"]=$url; 
    $data['category']=$this->Dms__frontend__m->get_category($url);
    $data['last_cat']=$url;
    $data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category']['ID']);
    $this->load->view('dms_frontend_docs_bysubcat',$data); 
    
       }else{
      $data['category_ids']=$this->Dms__frontend__m->get_category($url); 
          $data['category_name']=$this->uri->segment(2);
      $data['category_root']=$this->Dms__frontend__m->get_category($this->uri->segment(2));
      $data["baseroroot"]=$this->Dms__frontend__m->get_categoryBYID($data['category_root']["PARENT_CATE_ID"]);
      //print_r($data['category_root']['PARENT_CATE_ID']);
      $data['category_cat']=$this->Dms__frontend__m->get_category($this->uri->segment(3));
      $data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category_ids']['ID']);
      $this->load->view('dms_frontend_docs_bycat',$data); 
     }
  }   
  
  
  
  
   public function advance_search(){ 
      $data['page_heading'] = pageHeading("Document Management System");
      $data[''] ='';
      $url=$this->uri->segment(1); 
      $data["selmenu"]=$this->Dms__frontend__m->getmenu_master(1);
    
       if(!empty($url=$this->uri->segment(4)))
       {
        $url=$this->uri->segment(4);
       }elseif(!empty($url=$this->uri->segment(3))){
         
      $url=$this->uri->segment(3);   
         
       }else{
         $url=$this->uri->segment(2);   
       }
      $data['category_ids']=$this->Dms__frontend__m->get_category($url);
     // print_r($data['category_ids']);
      $data['category']=$this->Dms__frontend__m->get_category_bysection($data['category_ids']["ID"]);
      $data['category_name']=$this->uri->segment(3);   
      $data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category']['ID']);
          
       $data['subcat']=$this->Dms__frontend__m->get_subcategory($data['category_ids']["ID"]);
    
     if(count($data['subcat'])>0){
       
    $data["section_name"]=$url; 
    $data['category']=$this->Dms__frontend__m->get_category($url);
    $data['last_cat']=$url;
    $data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category']['ID']);
    $this->load->view('dms_frontend_docs_bysubcat',$data); 
    
       }else{
      $data['category_ids']=$this->Dms__frontend__m->get_category($url); 
          $data['category_name']=$this->uri->segment(2);
      $data['category_root']=$this->Dms__frontend__m->get_category($this->uri->segment(2));
      $data["baseroroot"]=$this->Dms__frontend__m->get_categoryBYID($data['category_root']["PARENT_CATE_ID"]);
      //print_r($data['category_root']['PARENT_CATE_ID']);
      $data['category_cat']=$this->Dms__frontend__m->get_category($this->uri->segment(3));
      $data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category_ids']['ID']);
      $this->load->view('dms_frontend_docs_bycat',$data); 
     }
  } 
  /*public function menu_add(){     
    $menu_info = $this->Dms__frontend__m->main_memucat();
    foreach ($menu_info as $items) {
      $menu['parents'][$items->PARENT_CATE_ID][] = $items;
        }
    $data['result'] = $this->buildChild(0, $menu);
  //echo "<pre>"; print_r($data['result']);
       $this->load->view('menu',$data);    
  }*
  function allct(){  
    $this -> db -> select('*');
    $this -> db -> where('PARENT_CATE_ID',"0"); 
    $this -> db -> from('dm__category');    
    $query = $this ->db->get();     
    return $query->result_array();
  }
  function allct_in($id){
    $this -> db -> select('*');
    $this -> db -> where('PARENT_CATE_ID',$id); 
    $this -> db -> from('dm__category');    
    $query = $this ->db->get();     
    return $query->result_array();
  }
  // 24 sept ends
    function get_category_data(){
      $root_category= array('SECTION_ID'=>$this->input->post('section_id'),'PARENT_CATE_ID!='=>0);
      $data['category'] = $this->Dms__frontend__m->get_category_data($root_category);
      //showArrayValues($data['category']);
      return $this->load->view('dms_frontend_category_view', $data);
    }
    function get_sub_category_data(){
      $root_category= array('PARENT_CATE_ID'=>$this->input->post('category_id'));
      $data['sub_category'] = $this->Dms__frontend__m->get_category_data($root_category);
      $data['files'] = $this->Dms__frontend__m->get_files($this->input->post('category_id'));
      //showArrayValues($data['files']);
      return $this->load->view('dms_frontend_sub_category_view', $data);
    }
   /*function get_files(){
      $data['files'] = $this->Dms__frontend__m->get_files($sub_category);
      //showArrayValues($data['category']);
      return $this->load->view('dms/dms_frontend_sub_category_view', $data);
    }*/

}
?>