<?php
error_reporting(E_ALL);
class Dms_filetype_c extends MX_Controller
{
	var $message;
    function __construct()
    {
      parent:: __construct();
      $this->message = array();
      
      $this->load->model('dms/Dms__filetype__m');
    }
    function index()
    {
      $data['page_heading'] = pageHeading("Document Management System");
      
      $data['grid'] = $this->createGrid();
      $this->load->view('dms/dms_filetype_view', $data);
    }
    private function createGrid(){
        $permissions = $this->getPermissions();
        $buttons = array();
        $mfunctions = array();
       /*if($permissions['DELETE']){
            array_push($buttons, "{ caption:'', title:'Delete Record', position :'first',
                buttonicon : 'ui-icon-trash',
                onClickButton:function(){Operation(BUTTON_DELETE,0);}, cursor: 'pointer'}");
        }*/
        if($permissions['MODIFY']){
            array_push($buttons, "{ caption:'', title:'Edit Record',position :'first',
                buttonicon : 'ui-icon-pencil',
                onClickButton:function(){Operation(BUTTON_MODIFY,0);}, cursor: 'pointer'}");
        }
        array_push($mfunctions, "ondblClickRow: function(ids){Operation(BUTTON_MODIFY,0);}");
        $cols = array(
            array('label' => 'Id',
                'name' => 'ID',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => true,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),

            array('label' => 'File Type Name',
                'name' => 'FILETYPE_NAME',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Max File Size (Mb)',
                'name' => 'MAX_FILE_SIZE',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Max Upload Size (Mb)',
                'name' => 'MAX_UPLOAD_SIZE',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            
            /*array('label' => 'Status',
                'name' => 'STATUS',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => '')*/
             );
        $aData = array(
            'set_columns' => $cols,
            'custom' => array("button" => $buttons, "function" => $mfunctions),
            'div_name' => 'Grid',
            'source' => 'getGrid',
            'postData' => '{}',
            'rowNum' => 10,
            'autowidth' => true,
            'width' => DEFAULT_GRID_WIDTH,
            'height' => '',
            'altRows' => true,
            'rownumbers' => true,
            'sort_name' => '',
            'sort_order' => '',
            'primary_key' => 'ID',
            'caption' => '<span class="cus-dam-1"></span> FileType Information',
            'pager' => true,
            'showTotalRecords' => true,
            'toppager' => false,
            'bottompager' => true,
            'multiselect' => false,
            'toolbar' => true,
            'toolbarposition' => 'top',
            'hiddengrid' => false,
            'editable' => false,
            'forceFit' => true,
            'gridview' => true,
            'footerrow' => false,
            'userDataOnFooter' => true,
            'custom_button_position' => 'bottom'
        );
        return buildGrid($aData);
    }
    private function getPermissions(){
        return getAccessPermissions('FILETYPE_SETUP', $this->session->userData('USER_ID'));
    }
    function getGrid(){
      echo $this->Dms__filetype__m->getGrid();
    }
    function showEntryBox(){
      $data = array();
      $id = (int) trim($this->input->post('id'));
      /*$data['arrData'] = array(
        'name'=>$this->session->userdata('SECTION_NAME'),
        'name_hindi' => $this->session->userdata('SECTION_NAME_HINDI'),
        //'session_id' => getCurrentSessionId();
        'user_id' => $this->session->userData('USER_ID'),
        'id' => (int) trim($this->input->post('id'))
        
      );*/
      $data['arrData'] = $this->Dms__filetype__m->showEntryBox($id);      
      $this->load->view('dms/dms_filetype',$data);
    }
    function saveData(){     
    //showArrayValues($_POST);
    //exit();
        $id = $this->input->post('ID');
        $arrValues = array(
            'FILETYPE_NAME'=>implode(',',$this->input->post('FILETYPE_NAME')),
            'MAX_FILE_SIZE'=>$this->input->post('MAX_FILE_SIZE'),
            'MAX_UPLOAD_SIZE '=>$this->input->post('MAX_UPLOAD_SIZE')
            /*'STATUS'=>$this->input->post('STATUS')*/
        );
      echo $this->Dms__filetype__m->saveData($id,$arrValues);
    }   
}
?>