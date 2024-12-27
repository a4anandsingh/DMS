<?php
//include_once("Hrm_library.php");
date_default_timezone_set("Asia/Calcutta");
error_reporting(E_ALL);
class Dms_frontend_c extends MX_Controller
{
  var $message;

  function __construct()
  {
    parent::__construct();
    $this->message = array();
    $this->dm__category = 'dm__category';


    $this->load->model('dms/Dms__frontend__m');
    $this->load->model('setup/__offices');
    //ini_set('display_errors', 1);
    /*$this->load->library("pagination");
      $this->load->model('dms/Dms__frontend__m');*/
  }
  function index()
  {
    $data['page_heading'] = pageHeading("Document Management System");
    $data['section'] = $this->Dms__frontend__m->get_sections();
    /*$data["selmenu"]=$this->Dms__frontend__m->getmenu_master(1); ; 
        $selval=explode(",",$data["selmenu"]["MENU_SELECTED"]);*/
    $data["selmenu"] = $this->Dms__frontend__m->getmenu_master(1);
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
  public function documents()
  {
    $id = '';
    $table = "dm__category";
    $data[''] = '';
    //   $data['sections']=$this->dms->get_sections();
    $url = $this->uri->segment(1);
    $data["selmenu"] = $this->Dms__frontend__m->getmenu_master(1);

    $data['singlesection'] = $this->Dms__frontend__m->getSingleCategoryBYname($url);
    $data["section_name"] = $data['singlesection']["HIERARCHY_PATH_TEXT"]; //$this->uri->segment(1); 
    // print_r($data['singlesection']);
    $config = [
      'base_url' => base_url($url),
      'per_page' => 5,
      'total_rows' => $this->Dms__frontend__m->count_table_cat($id, $table, $data['singlesection']['ID']),
      'full_tag_open' => "<ul class='pagination'>",
      'full_tag_close' => "</ul>",
      'first_tag_open' => "<li>",
      'first_tag_close' => "</li>",
      'last_tag_open' => "<li>",
      'uri_segment' => 2,
      'last_tag_close' => "</li>",
      'next_tag_open' => "<li  class='tg-prevpage'>",
      'next_tag_close' => "</li>",

      'prev_tag_open' => "<li class='tg-prevpage'>",
      'prev_tag_close' => "</li>",
      'num_tag_open' => "<li>",
      'num_tag_close' => "</li>",
      'cur_tag_open' => "<li class='tg-active'><a>",
      'cur_tag_close' => "</a></li>"
    ];

    $this->pagination->initialize($config);
    $data['category'] = $this->Dms__frontend__m->table_values_listing($config['per_page'], $this->uri->segment(2), $table, $data['singlesection']['ID']);
    $data['documents'] = $this->Dms__frontend__m->get_filesByCat($data['category']['ID']);
    //showArrayValues('aaaa');
    $this->load->view('dms_frontend_docs', $data);
  }


  public function documents_detail_1q()
  {
    $data['page_heading'] = pageHeading("Document Management System");
    $data[''] = '';
    $data["section_name"] = $this->uri->segment(2);
    $data['sections'] = $this->Dms__frontend__m->get_sections();
    $data['category'] = $this->Dms__frontend__m->get_category($url);
    // $data['category']['ID'];
    $data['subcat'] = $this->Dms__frontend__m->get_subcategory($data['category']['ID']);
    /// print_r( $data['subcat']);
    if (count($data['subcat']) > 0) {
      // print_r($data['subcat']);
      // print_r($data['subcat']);
      //$this->load->view('dms_frontend_docs_bysubcat',$data); 
      $this->load->view('dms_frontend_docs_bysubcat_1', $data);
    } else {
      $data['documents'] = $this->Dms__frontend__m->get_filesByCat($data['category']['ID']);
      //showArrayValues('bbbb');
      $this->load->view('dms_frontend_docs_bycat_1', $data);
    }
  }
  public function documents_details1($catName = '', $offSet = 0)
  {
    //$data['page_heading'] = pageHeading("Document Management System");





    $url = $this->uri->segment(1);
    $data["selmenu"] = $this->Dms__frontend__m->getmenu_master(1);
    if (!empty($url = $this->uri->segment(4))) {
      $url = $this->uri->segment(4);
    } elseif (!empty($url = $this->uri->segment(3))) {
      $url = $this->uri->segment(3);
    } else {
      $url = $this->uri->segment(2);
    }

    // echo " >> ".$url; exit;
    /* if(!empty($url=$this->uri->segment(4)))
       {
        showArrayValues('55');
        $url=$this->uri->segment(4);
       }elseif(!empty($url=$this->uri->segment(3))){
         showArrayValues('66');

        $url=$this->uri->segment(3);   
         
       }else{
        showArrayValues('77');
         $url=$this->uri->segment(2);   
       }*/

    //showArrayValues(base_url().$this->uri->segment(5));
    //showArrayValues($catName);
    $data['page_heading'] = "Document Management System";
    $data['category_ids'] = $this->Dms__frontend__m->get_category($url);

    $data['category'] = $this->Dms__frontend__m->get_category_bysection($data['category_ids']["ID"]);
    $data['section_name'] = $this->Dms__frontend__m->get_section_name($data['category_ids']["SECTION_ID"]); //09-02-2022

    $data['category_name'] = $catName;

    //print_r($data);
    $data['section_id'] = $data['category_ids']["SECTION_ID"];
    $data['category_id'] = $data['category_ids']["ID"];
    //$data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category']['ID']);
    $this->load->library("pagination");
    $config = array();
    // $config["base_url"] = $url;
    $config["base_url"] = base_url() . "cat_view/" . $catName . "/";
    //showArrayValues($data['category_ids']["ID"]);
    $config["total_rows"] = $this->Dms__frontend__m->get_filesCountByCat($data['category_ids']["ID"]);
    //showArrayValues($config["total_rows"]);
    $config["per_page"] = 10;
    $config["uri_segment"] = 3;
    // config code for paging css 24 jan 2022//
    $config['full_tag_open'] = "<ul class='pagination'>";
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous Page';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = 'Next Page<i class="fa fa-long-arrow-right"></i>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    //End//        
    $this->pagination->initialize($config);
    // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    $page = $offSet;
    $data['offSet'] = $page;
    $data["links"] = $this->pagination->create_links();
    //$data['authors'] = $this->authors_model->get_authors($config["per_page"], $page);
    $data['documents'] = $this->Dms__frontend__m->get_filesByCat($data['category_ids']['ID']);
    //showArrayValues($data['documents']);
    $data['subcat'] = $this->Dms__frontend__m->get_subcategory($data['category_ids']["ID"]);

    if (count($data['subcat']) > 0) {
      $data["section_name"] = $url;
      $data['category'] = $this->Dms__frontend__m->get_category($url);
      $data['last_cat'] = $url;
      $data['category_name'] = $data['category']["CATEGORY_ENG"];
      if (empty($this->uri->segment(3))) {

        $this->load->view('dms_frontend_docs_bysubcat_1', $data);
      } else {
        echo $url;
        $data['category_ids'] = $this->Dms__frontend__m->get_category($url);
        //$data['category_name']=$this->uri->segment(3);
        $data['category_root'] = $this->Dms__frontend__m->get_category($this->uri->segment(3));
        $data["baseroroot"] = $this->Dms__frontend__m->get_categoryBYID($data['category_root']["ID"]);
        //print_r($data['category_root']);
        $data['category_cat'] = $this->Dms__frontend__m->get_category($data['category_root']["ID"]);
        $data['documents'] = $this->Dms__frontend__m->get_filesByCat($data['category_ids']['ID']);
        $this->load->view('dms_frontend_docs_bycat_1', $data);
        //exit;
        // exit;
      }
    } else {

      $data['category_ids'] = $this->Dms__frontend__m->get_category($url);

      $data['category_name'] = $this->uri->segment(2);

      $data['category_root'] = $this->Dms__frontend__m->get_category($this->uri->segment(2));
      $data["baseroroot"] = $this->Dms__frontend__m->get_categoryBYID($data['category_root']["PARENT_CATE_ID"]);
      //print_r($data['category_root']['PARENT_CATE_ID']);
      $data['category_cat'] = $this->Dms__frontend__m->get_category($this->uri->segment(3));
      //$data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category_ids']['ID']);
      $this->load->view('dms_frontend_docs_bycat_1', $data);
    }
  }

  //bkkkkkkkkkkkkkkkkkk
  public function documents_details($catName = '', $offSet = 0)
  {
    $data = array();
    // $data = array();
    $data['START_DATE'] = '';
    $data['END_DATE'] = '';

    $url = $this->uri->segment(4);
    $data['sub_category_name'] = "";
    $data["selmenu"] = $this->Dms__frontend__m->getmenu_master(1);
    if (!empty($url = $this->uri->segment(4))) {
      $url = $this->uri->segment(4);

      $data["section_name"] = $this->uri->segment(2);
      $data['sub_category_name'] = $this->uri->segment(3);
      $data['category_name'] = $this->uri->segment(4);
      $full_url = $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4);
      $url = $this->uri->segment(4);
    } elseif (!empty($url = $this->uri->segment(3))) {
      $data["section_name"] = $this->uri->segment(2);
      $data['category_name'] = $this->uri->segment(3);
      $url = $this->uri->segment(3);

      $full_url = $this->uri->segment(2) . '/' . $this->uri->segment(3);
      //die("aa"); 	
    } else {
      $data["section_name"] = $this->uri->segment(2);
      $url = $this->uri->segment(2);
      $data['category_name'] = $this->uri->segment(2);
      $full_url = $this->uri->segment(2);
    }
    //print_r($data["section_name"]);
    $v = str_replace("-", " ", $data["section_name"]);

    $data['page_heading'] = "Document Management System";

    $data['section_ids'] = $this->Dms__frontend__m->get_sectionfromcat($full_url);
    //print_r($data['section_ids']);// die();
    $data['category_ids'] = $this->Dms__frontend__m->get_categorytext($url, $data['section_ids']['ID']);

    $data['category'] = $this->Dms__frontend__m->get_category_bysection($data['category_ids']["ID"]);


    $data['section_id'] = $data['section_ids']["PARENT_CATE_ID"]; // 15-07-2022 for searching issue 
    $data['category_id'] = $data['section_ids']["ID"];

    $data['documents'] = $this->Dms__frontend__m->get_filesByCat($data['section_ids']['ID'], $data['section_ids']['SECTION_ID']);
    // print_r($data['section_ids']['ID']); die();
    //showArrayValues($data['documents']);
    $data['subcat'] = $this->Dms__frontend__m->get_subcategory($data['section_ids']["ID"]);
    // print_r($data['section_ids']); 
    if (count($data['subcat']) > 0) {
      // $data["section_name"]=$url; 
      $data['category'] = $data['section_ids']['PARENT_CATE_ID']; //$this->Dms__frontend__m->get_category($url,$data['section_ids']['ID'],$data['section_ids']['ID']);
      $data['last_cat'] = $url;
      // $data['category_name']= $data['category']["CATEGORY_ENG"];
      if (empty($this->uri->segment(3))) {

        $this->load->view('dms_frontend_docs_bysubcat_1', $data);
      } else {
        $data['category_ids'] = $this->Dms__frontend__m->get_category($url);
        //$data['category_name']=$this->uri->segment(3);
        $data['category_root'] = $this->Dms__frontend__m->get_category($this->uri->segment(3));
        $data["baseroroot"] = $this->Dms__frontend__m->get_categoryBYID($data['category_root']["ID"]);

        $data['category_cat'] = $this->Dms__frontend__m->get_category($data['category_root']["ID"]);
        $data['documents'] = $this->Dms__frontend__m->get_filesByCat($data['section_ids']['ID']);
        //echo "<pre>"; print_r($data);
        $this->load->view('dms_frontend_docs_bycat_1', $data);
      }
    } else {

      $data['category_ids'] = $this->Dms__frontend__m->get_category($url);

      //$data['category_name']=$this->uri->segment(2);

      $data['category_root'] = $this->Dms__frontend__m->get_category($this->uri->segment(2));
      $data["baseroroot"] = $this->Dms__frontend__m->get_categoryBYID($data['category_root']["PARENT_CATE_ID"]);
      //print_r($data['category_root']['PARENT_CATE_ID']);
      $data['category_cat'] = $this->Dms__frontend__m->get_category($this->uri->segment(3));
      //$data['documents']=$this->Dms__frontend__m->get_filesByCat($data['category_ids']['ID']);
      //showArrayValues($data);
      $this->load->view('dms_frontend_docs_bycat_1', $data);
    }
  }



  /* Start 09-02-2022 for searching mechanism*/
  public function getInfo()
  {
    //showArrayValues($_POST);

    $data = array();

    $data['START_DATE'] = $this->input->post('START_DATE');
    $data['END_DATE'] = $this->input->post('END_DATE');

    $catName = $this->input->post('CATEGORY_NAME');
    $offSet = 0;
    $FETCH = array(
      'CHK_RADIO' => $this->input->post('CHK_RADIO'),
      'SECTION' => $this->input->post('SECTION_ID'),
      'CATEGORY' => $this->input->post('CATEGORY_ID'),
      'FILE_NAME' => $this->input->post('FILE_NAME'),
      'LETTER_NO' => $this->input->post('LETTER_NO'),
      'SESSION' => $this->input->post('session'),
      'START_DATE' => myDateFormat($this->input->post('START_DATE')),
      'END_DATE' => myDateFormat($this->input->post('END_DATE'))
    );

    $url = $this->uri->segment(1);
    $data["selmenu"] = $this->Dms__frontend__m->getmenu_master(1);
    if (!empty($url = $this->uri->segment(4))) {
      $url = $this->uri->segment(4);
    } elseif (!empty($url = $this->uri->segment(3))) {
      $url = $this->uri->segment(3);
    } else {
      $url = $this->uri->segment(2);
    }
    $data['page_heading'] = "Document Management System";
    $data['category_ids'] = $this->Dms__frontend__m->get_category($catName);
    $data['category'] = $this->Dms__frontend__m->get_category_bysection($data['category_ids']["ID"]);
    $data['section_name'] = $this->Dms__frontend__m->get_section_name($data['category_ids']["SECTION_ID"]); //09-02-2022
    $data['category_name'] = $catName;
    $data['section_id'] = $data['category_ids']["SECTION_ID"];
    $data['category_id'] = $data['category_ids']["ID"];
    $this->load->library("pagination");
    $config = array();
    $config["base_url"] = base_url() . "cat_view/" . $catName . "/";
    $config["total_rows"] = $this->Dms__frontend__m->get_filesCountBySearch($FETCH);
    $config["per_page"] = 10;
    $config["uri_segment"] = 3;
    $config['full_tag_open'] = "<ul class='pagination'>";
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';
    $config['prev_link'] = '<i class="fa fa-long-arrow-left"></i>Previous Page';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = 'Next Page<i class="fa fa-long-arrow-right"></i>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $this->pagination->initialize($config);
    $page = $offSet;
    $data['offSet'] = $page;
    $data["links"] = $this->pagination->create_links();

    $data['documents'] = $this->Dms__frontend__m->searchResult($FETCH, $config["per_page"], $page);

    //showArrayvalues($data);
    //$data['documents'] = $this->Dms__frontend__m->get_filesByCat($data['category_ids']['ID'],$config["per_page"], $page);
    $data['subcat'] = $this->Dms__frontend__m->get_subcategory($data['category_ids']["ID"]);
    if (count($data['subcat']) > 0) {
      $data["section_name"] = $url;
      $data['category'] = $this->Dms__frontend__m->get_category($url);
      $data['last_cat'] = $url;
      $this->load->view('dms_frontend_docs_bysubcat_1', $data);
    } else {
      $data['category_ids'] = $this->Dms__frontend__m->get_category($url);
      //$data['category_name']=$this->uri->segment(2);
      $data['category_root'] = $this->Dms__frontend__m->get_category($this->uri->segment(2));
      //        $data["baseroroot"]=$this->Dms__frontend__m->get_categoryBYID($data['category_root']["PARENT_CATE_ID"]);
      $data['category_cat'] = $this->Dms__frontend__m->get_category($this->uri->segment(3));
      //showArrayValues($data);
      $this->load->view('search_result', $data);
    }
  }
  /* End 09-02-2022 for searching mechanism*/
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
  public function advance_search($catName = '', $offSet = 0)
  {
    $data = array();
    $data['visible_office'] = array('CE' => 1, 'SE' => 1, 'EE' => 1, 'SDO' => 0);
    $data['officelist'] = $this->__offices->getOffices($data['visible_office']);
    $this->load->library('office_filter');
    $data['office_list'] = $this->office_filter->office_list();
    $data['project_grid1'] = "";
    $data['project_grid'] = "";
    $data['myPrefix'] = 'SEARCH_';
    $data['default_value'] = array('CE' => 0, 'SE' => 0, 'EE' => 0, 'SDO' => 0);

    $data['arrCurrentOffice'] = $this->getCurrentOfficeRecord();
    $data['START_DATE'] = '';
    $data['END_DATE'] = '';
    $data["officeLists"] = $this->Dms__frontend__m->OfficeList();
    $data["allct"] = $this->cateSubcatTable();
    $url = $this->uri->segment(4);
    $data['sub_category_name'] = "";
    $data["selmenu"] = $this->Dms__frontend__m->getmenu_master(1);



    $data['page_heading'] = "Document Management System";

    $data['subcat'] = "";

    $data["documents"] = array();
    $this->load->view('dms_frontend_advancesearch', $data);
  }
  /** Called By showEmployeeEntryBox()*/
  public function getCurrentOfficeRecord()
  {

    $curOffice = array();
    $recs = $this->db->get_where(
      'hrm__t_service_history',
      array(
        'EMPLOYEE_ID' => 1,
        'CURRENT_OFFICE' => 1
      )
    );
    $found = false;
    if ($recs && $recs->num_rows()) {
      $rec = $recs->row();
      $curOffice = array(
        'DESIGNATION_ID' => $rec->DESIGNATION_ID,
        'CLASS' => $rec->CLASS,
        'OTHER_DEPARTMENT' => $rec->OTHER_DEPARTMENT,
        'REMARK' => $rec->REMARK,
        'DESIGNATION_NAME' => $this->getPostName($rec->DESIGNATION_ID),
        'CURRENT_HOLDING_DESIGNATION_ID' => $rec->CURRENT_HOLDING_DESIGNATION_ID,
        'HOLDING_DESIGNATION_NAME' => $this->getPostName($rec->CURRENT_HOLDING_DESIGNATION_ID),
        'HOLDING_CURRENT_DESIGNATION_LIST' => $this->disgnationForOfficeOptions($rec->CURRENT_HOLDING_DESIGNATION_ID, array(1, 2, 3, 4)),
        'OFFICE_ID' => $rec->OFFICE_ID,
        'OFFICE_NAME' => $this->getOfficeName($rec->OFFICE_ID),
        'CURRENT_DESIGNATION_LIST' => $this->disgnationForOfficeOptions($rec->DESIGNATION_ID, array(1, 2, 3, 4)),
        'OFFICE_LIST_CURRENT_OFFICE' => $this->currentOfficeOptions(
          $this->session->userData('CURRENT_OFFICE_ID'),
          $rec->OFFICE_ID,
          $rec->IS_DEPUTATION
        ),
        'CURRENT_CADRE' => $rec->CURRENT_CADRE,
        'SERVICE_FROM_DATE' => $rec->SERVICE_FROM_DATE,
        'SERVICE_ORDER_DATE' => $rec->SERVICE_ORDER_DATE,
        'SERVICE_ORDER_NO' => $rec->SERVICE_ORDER_NO,
        'OTHER_DESIGNATION_NAME' => $rec->OTHER_DESIGNATION_NAME,
        'OTHER_OFFICE_NAME' => $rec->OTHER_OFFICE_NAME,
        'IS_DEPUTATION' => $rec->IS_DEPUTATION,
        'EMP_STATUS' => $rec->EMP_STATUS
      );
      $found = true;
    }
    if (!$found) {
      $curOffice = array(
        'OFFICE_LIST_CURRENT_OFFICE' => $this->currentOfficeOptions(
          $this->session->userData('CURRENT_OFFICE_ID'),
          0
        ),
        'HOLDING_CURRENT_DESIGNATION_LIST' => $this->disgnationForOfficeOptions(0, array(1, 2, 3, 4)),
        'CURRENT_DESIGNATION_LIST' => $this->disgnationForOfficeOptions(0, array(1, 2, 3, 4)),
        'DESIGNATION_ID' => '',
        'CURRENT_CADRE' => '',
        'SERVICE_ORDER_DATE' => '',
        'SERVICE_ORDER_NO' => '',
        'SERVICE_FROM_DATE' => '',
        'OTHER_DESIGNATION_NAME' => '',
        'IS_DEPUTATION' => 0
      );
    }
    return $curOffice;
  }

  public function currentOfficeOptions($officeid, $sel = 0, $isDeputation = 0)
  {
    //get parents and childrens of $officeid
    //search office code of $officeid
    $OFFICE_CODE = '';
    //if($isDeputation) $sel=1;
    $this->db->select('OFFICE_CODE');
    $recs = $this->db->get_where('__offices', array('OFFICE_ID' => $officeid));
    if ($recs && $recs->num_rows()) {
      $rec = $recs->row();
      $OFFICE_CODE = $rec->OFFICE_CODE;
    }
    //SPLIT $OFFICE_CODE
    $arrOfficeCodes = array();
    $lengthOC = strlen($OFFICE_CODE);
    $countLoop = (int)($lengthOC / 3);
    for ($i = 0; $i < $countLoop; $i++) {
      array_push($arrOfficeCodes, "'" . substr($OFFICE_CODE, 0, (($i + 1) * 3)) . "'");
    }
    array_push($arrOfficeCodes, "'" . $OFFICE_CODE . "'");
    $arrOfficeID1 = array();
    $strSQL = "SELECT OFFICE_ID, OFFICE_NAME, HOLDING_PERSON, OFFICE_NAME_HINDI FROM __offices 
			WHERE ( 
				OFFICE_CODE IN (" . implode(',', $arrOfficeCodes) . ") 
				OR (
					OFFICE_CODE LIKE '" . $OFFICE_CODE . "%'
					AND OFFICE_CODE != '" . $OFFICE_CODE . "'
					)
				)
			ORDER BY OFFICE_CODE";
    $recs = $this->db->query($strSQL);
    //echo $strSQL;
    $opt = array();
    array_push($opt, '<option value="0">Select Office</option>');
    //echo 'BB:'.count($optData).';BB';
    foreach ($recs->result() as $rec) {
      $selected = ($rec->OFFICE_ID == $sel) ? 'selected="selected"' : '';
      if ($rec->HOLDING_PERSON - 1 > 0) { //check condition added by Pawan 26/11/24
        array_push(
          $opt,
          '<option value="' . $rec->OFFICE_ID . '" ' .
            $selected .
            ' >' . str_repeat('---', ($rec->HOLDING_PERSON - 1)) .
            $rec->OFFICE_NAME . ' [' . $rec->OFFICE_NAME_HINDI .
            ' ]</option>'
        );
      }
    }
    return implode('', $opt);
  }
  public function disgnationForOfficeOptions($sel = 0, $showClass = array())
  {
    $this->db->order_by('DESIGNATION_CLASS');
    $this->db->order_by('CLASS_DESIGNATION_NAME');
    if (count($showClass) == 0) $showClass = array(1, 2);
    $this->db->where_in('DESIGNATION_CLASS', $showClass);
    $recs = $this->db->get('__class_designations');
    //echo $this->db->last_query();exit;
    $opt = '<option value="0">Select</option>';
    $arrDesig = array();
    $arrDesig[0][] = '';
    foreach ($recs->result() as $rec) {
      //if(!in_array(5, $showClass)){
      if ($rec->CLASS_DESIGNATION_ID == 81) continue;
      //}
      /*if($rec->DESIGNATION_CLASS==3){
				if( in_array($rec->CLASS_DESIGNATION_ID, array(33, 34)) ){
					//go ahead
				}else
					continue;
			}*/
      //if($rec->DESIGNATION_CLASS>2) continue;
      $arrDesig[$rec->DESIGNATION_CLASS][] = '<option value="' . $rec->CLASS_DESIGNATION_ID .
        '" ' .
        (($rec->CLASS_DESIGNATION_ID == $sel) ? 'selected="selected"' : '') .
        ' >' .
        $rec->CLASS_DESIGNATION_NAME .
        ' [ ' . $rec->CLASS_DESIGNATION_NAME_HINDI .
        ' ]</option>';
    }

    $arrClass = array('', 'Class - I', 'Class - II', 'Class - III', 'Class - IV', 'Any Other');


    for ($i = 0; $i < count($showClass); $i++) {

      $opt  .= '<optgroup label="' . $arrClass[$showClass[$i]] . '">' . implode('', $arrDesig[$showClass[$i]]) . '</optgroup>';
    }

    return $opt;
  }
  public function showOfficeFilterBox()
  {

    $data = array();
    $data['prefix'] = 'SEARCH_';
    $data['show_sdo'] = FALSE;
    $data['row'] = '';
    $this->load->view('setup/office_filter_view_advance', $data);
  }
  function showOffices()
  {
    $this->load->model('setup/__offices');
    $data['visible_office'] = array('CE' => 1, 'SE' => 1, 'EE' => 1, 'SDO' => 0);
    $data['officelist'] = $this->__offices->getOffices($data['visible_office']);
    $data['myPrefix'] = 'SEARCH_';
    $data['default_value'] = array('CE' => 0, 'SE' => 0, 'EE' => 0, 'SDO' => 0);
    $this->load->view('setup/office_view', $data);
  }
  function cateSubcatTable($parent = 0, $spacing = '&nbsp;&nbsp;', $user_tree_array = '')
  {


    $user_tree_array = array();

    $this->db->select('*');
    $this->db->from($this->dm__category);
    $this->db->where(array('PARENT_CATE_ID' => $parent, 'status ' => 1));
    // $this->db->where_in('ID',$selId);
    $recs = $this->db->get();

    if ($recs && $recs->num_rows()) {
      foreach ($recs->result() as $rec) {

        $user_tree_array[] = array("id" => $rec->ID, "name" => $rec->CATEGORY_ENG);
        //$user_tree_array[] = $this->cateSubcatTable($rec->ID, $spacing. '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $user_tree_array);
      }
      $recs->free_result();
    }
    return $user_tree_array;
  }

  function changeCategory()
  {
    $SECTION_ID = $this->input->post('SECTION_ID');
    $CATEGORY_ID = $SECTION_ID; // $this->input->post('CATEGORY_ID');
    $CATEGORY_ID_SEL = $this->input->post('CATEGORY_ID');
    $getdata = $this->cateSubcatTable($CATEGORY_ID);

    $opt = '<option value="All">All</option>';


    foreach ($getdata as $key => $value) {

      if (empty($_POST["subcat_ID"])) {
        $opt .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
      }
    }
    echo $opt;
  }



  public function advance_searchResult()
  {


    $data = array();
    $data['SEARECH_KEYWORD'] = $this->input->post('SEARECH_KEYWORD');
    $data['CATEGORY_ID'] = $this->input->post('CATEGORY_ID');
    $data['OFFICE_ID'] = $this->input->post('OFFICE_ID');
    $data['START_DATE'] = $this->input->post('START_DATE');
    $data['END_DATE'] = $this->input->post('END_DATE');

    $catName = $this->input->post('CATEGORY_NAME');
    $offSet = 0;
    $FETCH = array(
      'CHK_RADIO' => $this->input->post('CHK_RADIO'),
      'CATEGORY' => $this->input->post('CATEGORY_ID'),
      'SECTION_ID' => $this->input->post('SECTION_ID'),
      'SEARCH_CE_ID' => $this->input->post('SEARCH_CE_ID'),
      'SEARCH_SE_ID' => $this->input->post('SEARCH_SE_ID'),
      'SEARCH_EE_ID' => $this->input->post('SEARCH_EE_ID'),
      'SEARECH_KEYWORD' => $this->input->post('SEARECH_KEYWORD'),
      'FILE_NAME' => $this->input->post('FILE_NAME'),
      'LETTER_NO' => $this->input->post('LETTER_NO'),
      'SESSION' => $this->input->post('session'),
      'START_DATE' => myDateFormat($this->input->post('START_DATE')),
      'END_DATE' => myDateFormat($this->input->post('END_DATE'))
    );

    $data['page_heading'] = "Document Management System";
    $data["documents"] = $this->Dms__frontend__m->advance_searchResult($FETCH);
    $this->load->view('advance_search_result', $data);
    $document = array();
  }
}
