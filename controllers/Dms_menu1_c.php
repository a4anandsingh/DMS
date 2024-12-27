<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Dms_menu1_c extends MX_Controller {
  
    public function __construct() {
       parent::__construct();
       
    }
  
    public function index()
    {
        //showArrayValues($this->getItem());
        $this->load->view('dms_menu1_view');
    }
  
   /* public function getItem()
    {
          $data = [];
          $parent_key = '0';
          $row = $this->db->query('SELECT PARENT_CATE_ID, CATEGORY_ENG from dm__category');
            
          if($row->num_rows() > 0)
          {
              $data = $this->membersTree($parent_key);
          }else{
              $data=["PARENT_CATE_ID"=>"0","CATEGORY_ENG"=>"No Members presnt in list","text"=>"No Members is presnt in list","nodes"=>[]];
          }
   
          echo json_encode(array_values($data));
    }*/
   
   
    /*public function membersTree($parent_key)
    {
        $row1 = [];
        $row = $this->db->query('SELECT ID, CATEGORY_ENG from dm__category WHERE PARENT_CATE_ID="'.$parent_key.'"')->result_array();
    
        foreach($row as $key => $value)
        {
           $ID = $value['ID'];
           $row1[$key]['ID'] = $value['ID'];
           $row1[$key]['CATEGORY_ENG'] = $value['CATEGORY_ENG'];
           $row1[$key]['text'] = $value['CATEGORY_ENG'];
           $row1[$key]['nodes'] = array_values($this->membersTree($value['ID']));
        }
  
        return $row1;
    }*/
     
    public function getItem()
    {
          $data = [];
          $parent_key = '0';
          $row = $this->db->query('SELECT * from dm__sections');
            
          if($row->num_rows() > 0)
          {            
              $data = $this->membersTree();
          }else{
              $data=["PARENT_CATE_ID"=>"0","CATEGORY_ENG"=>"No Members presnt in list","text"=>"No Members is presnt in list","nodes"=>[]];
          }
   
          echo json_encode(array_values($data));
    }
    public function membersTree($params=array())
    {
        $row1 = [];
        if(!$params){
            $row = $this->db->query('SELECT ID as SECTION_ID, "" as CATEGORY_ENG, SECTION_NAME, 0 as ID, SECTION_NAME as myText from dm__sections')->result_array();
        }else{
            if($params['section_id']!=0)
        $row = $this->db->query('SELECT ID, CATEGORY_ENG, "" as SECTION_NAME, 0 as SECTION_ID, CATEGORY_ENG as myText from dm__category WHERE SECTION_ID="'.$params['section_id'].'"')->result_array();
        else
            $row = $this->db->query('SELECT ID, CATEGORY_ENG, "" as SECTION_NAME, 0 as SECTION_ID, CATEGORY_ENG as myText from dm__category WHERE PARENT_CATE_ID="'.$params['primary_key'].'"')->result_array();
        }
        

    
        foreach($row as $key => $value)
        {
            $arrData['section_id'] = $value['SECTION_ID'];
            $arrData['primary_key'] = $value['ID'];
           $ID = $value['ID'];
           /*$row1[$key]['ID'] = $value['ID'];
           $row1[$key]['CATEGORY_ENG'] = $value['CATEGORY_ENG'];*/
           //$row1[$key]['text'] =((!$params) ? $value['SECTION_NAME'] : $value['CATEGORY_ENG']) ;
           $row1[$key]['text'] =$value['myText'];
           $row1[$key]['nodes'] = array_values($this->membersTree($arrData));
        }
  
        return $row1;
    }
}