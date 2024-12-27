<?php
error_reporting(E_ALL);
class Dms_searche_c extends MX_Controller
{
    var $message;
    function __construct()
    {
      parent:: __construct();
      $this->message = array();
      
      $this->load->model('dms/Dms__searche__m');
    }
    function index()
    {                
      $data['page_heading'] = pageHeading("Document Search System");      
      /*$data['grid'] = $this->createGrid();*/
      $data['section']=$this->Dms__searche__m->section_pulldown();
      $this->load->view('dms/dms_search_view', $data);
    }
    
    function changeCategory(){
        $SECTION_ID = $this->input->post('SECTION_ID');
        $CATEGORY_ID = $this->input->post('CATEGORY_ID');

       $getdata = $this->Dms__searche__m->cateSubcatTable($SECTION_ID);

       $opt ='<option value="">Select Category</option>';      
       foreach ($getdata as $key => $value) {
           $opt.='<option'. ($value['id'] == $CATEGORY_ID ? ' selected="selected"' :"")  .' value="'.$value['id'].'">'.$value['name'].'</option>';
       }
        echo $opt;
    }
    function showEntryBox(){
        $data = array();
        $id = (int) trim($this->input->post('id'));
        $arrData = array();
        $data['arrData'] = $arrData= $this->Dms__searche__m->showEntryBox($id); 
        //showArrayValues($data['arrData']);
        //get section
        $data['section'] = $this->Dms__searche__m->section_pulldown($data['arrData']['SECTION_ID']);
        showArrayValues($data['section']);
        //get category
        $data['category_tree'] = $this->Dms__searche__m->cateSubcatTable();
        
        //showArrayValues($data['category_tree']);
        //showArrayValues($data['arrData']); //exit;
        $this->load->view('dms/dms_search_view',$data);
    }
  
    function showSectionEntryBox(){
        $data['SECTION_NAME'] = $this->Dms__searche__m->section_pulldown();

        //load all of your view data
        $this->load->view('dms_search_view', $data);

    }

    public function getSectionName($sectionId){
        $recs = $this->db->select("SECTION_NAME")
                    ->from("dm__sections")
                    ->where("ID", $sectionId)
                    ->get();
        $sectionName ="";
        if($recs && $recs->num_rows()){
            $rec = $recs->row();
            $sectionName = $rec->SECTION_NAME;            

            $string = preg_replace("/[^a-zA-Z0-9]+/", "-", $sectionName);
            $string = strtolower($string);
            return $string;
        }
    }

    /*public function getInfo(){
        $FETCH= array( 'SECTION' => $this->input->post('SECTION_ID'), 'CATEGORY' => $this->input->post('CATEGORY_ID'));
        $data['dmsValue'] = $this->Dms__searche__m->searchResult($FETCH);
        /*showArrayValues($data);*/
        //echo $this->load->view('dms_search_view_data',$data,'true');
    //}

public function getInfo(){
    //showArrayValues($_POST);
        $FETCH= array( 
            'CHK_RADIO'=> $this->input->post('CHK_RADIO'),
            'SECTION' => $this->input->post('SECTION_ID'),
            'CATEGORY' => $this->input->post('CATEGORY_ID'),
            'FILE_NAME' => $this->input->post('FILE_NAME'),
            'LETTER_NO' => $this->input->post('LETTER_NO'),
            'START_DATE' => myDateFormat($this->input->post('START_DATE')),
            'END_DATE' => myDateFormat($this->input->post('END_DATE'))
        );

        $data['dmsValue'] = $this->Dms__searche__m->searchResult($FETCH);
        /*showArrayValues($data);*/
        echo $this->load->view('dms_search_view_data',$data,'true');
    }

}
?>