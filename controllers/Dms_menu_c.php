<?php
//error_reporting(E_ALL);
/*require_once(APPPATH.'/libraries/csrf.class.php');
require_once(APPPATH.'/libraries/SaveImage.class.php');*/
class Dms_menu_c extends MX_Controller{
  private $message, $tableName;
  function __construct(){
    parent:: __construct();
    $this->message = array();
    $this->usertable = 'usr__m_users';
    $this->tableName = 'usr__m_user_class';
    $this->load->model('dms/Dms__menu__m');
  }
  
  function index(){
    $data = array();
    $data['page_heading'] =  pageHeading('Menu Master - XXXX');
    $data["menu_list"] =  $this->Dms__menu__m->getmenu_master();
    $data['grid'] = $this->createGrid() . $this->createUserGrid();
    $this->load->view('dms/dms_menu_index', $data);   
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
        if($permissions['ADD']){
     
            array_push($buttons, "{ caption:'', title:'Add New Record',position :'first', 
                buttonicon : 'ui-icon-plus', 
                onClickButton:function(){Operation(BUTTON_ADD_NEW,4);}, cursor: 'pointer'}");
        }
        array_push($mfunctions, "ondblClickRow: function(ids){Operation(BUTTON_MODIFY,0);}");
        $cols = array(
            array('label' => 'Menu Id',
                'name' => 'MENU_ID',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => true,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Menu Name',
                'name' => 'MENU_NAME',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Selected Menu Data',
                'name' => 'MENU_SELECTED',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Publication Status',
                'name' => 'STATUS',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => '')
             );
        $aData = array(
            'set_columns' => $cols,
            'custom' => array("button" => $buttons, "function" => $mfunctions),
            'div_name' => 'menuMasterGrid',
            'source' => 'getMenuMasterGrid',
            'postData' => '{}',
            'rowNum' => 10,
            'autowidth' => true,
            'width' => DEFAULT_GRID_WIDTH,
            'height' => '',
            'altRows' => true,
            'rownumbers' => true,
            'sort_name' => '',
            'sort_order' => '',
            'primary_key' => 'MENU_ID',
            'caption' => '<span class="cus-dam-1"></span> Created Menu Information',
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
        return getAccessPermissions('DMS_MENUMASTER', $this->session->userData('USER_ID'));
    }
    function getMenuMasterGrid(){
      echo $this->Dms__menu__m->getMenuMasterGrid();
    }
/**/
    private function createUserGrid(){
        $key = 'USER_CLASS_SETUP';
        $permission = array('MODIFY'=>TRUE);
        $buttons = array();
       
        if ($permission['MODIFY']){
            array_push(
                $buttons, 
                "{ caption:'', title:'Edit Record',position :'first', 
                buttonicon : 'ui-icon-pencil', 
                onClickButton:function(){operationUser(BUTTON_MODIFY,0);}, cursor: 'pointer'}"
            );
        }
        
        $mfunctions = array();
        array_push($mfunctions , "ondblClickRow: function(ids){operationUser(BUTTON_MODIFY,0);}");
        $aData = array(
            'set_columns' => array(
                array(
                    'label' => 'User Id',
                    'name' => 'USER_CLASS_ID',
                    'width' => 30,
                    'align' => "left",
                    'resizable' => false,
                    'sortable' => true,
                    'hidden' => true,
                    'view' => true,
                    'search' => true,
                    'formatter' => '',
                    'searchoptions' => ''
                ),
                array(
                    'label' => 'User Name',
                    'name' => 'USER_NAME',
                    'width' => 100,
                    'size' => 10,
                    'align' => "left",
                    'resizable'=>false,
                    'sortable'=>true,
                    'hidden'=>false,
                    'view'=>true,
                    'formatter'=> '',
                    'search'=>true,
                    'searchoptions'=>''
                ),
                array(
                    'label' => 'STATUS',
                    'name' => 'PUBLISHED',
                    'width' => 70,
                    'size' => 10,
                    'align' => "center",
                    'resizable'=>false,
                    'sortable'=>true,
                    'hidden'=>false,
                    'view'=>true,
                    'formatter'=> '',
                    'search'=>false,
                    'searchoptions'=>''
                )
            ),
            'custom' => array("button"=>$buttons, "function"=>$mfunctions),
            'div_name' => 'userClassGrid',
            'source' => 'getUserClassGridData',
            'postData' => '',
            'rowNum'=>10,
            'width'=>DEFAULT_GRID_WIDTH,
            'height' => '',
            'altRows'=> true,
            'rownumbers'=>true, 
            'sort_name' => 'USER_CLASS_ID',
            'sort_order' => 'asc', /*asc*/
            'add_url' => '',
            'edit_url' => '',
            'delete_url' => '',
            'caption' => 'User Class Management - उपयोक्ता वर्ग',
            'primary_key' => 'USER_CLASS_ID',
            'pager' => true,
            'showTotalRecords' => true,
            'toppager' =>false,
            'bottompager' =>true,
            'multiselect'=>false,
            'toolbar'=> true,
            'toolbarposition'=>'top',/*bottom*/
            'hiddengrid'=>false,
            'editable'=>false,
            'forceFit'=>true,
            'gridview'=>true,
            'footerrow'=>false, 
            'userDataOnFooter'=>true, 
            'treeGrid'=>false,
            'custom_button_position'=>'bottom' /*top*/
        );
        return buildGrid($aData);
    }

    public function getUserClassGridData(){
        echo $this->Dms__menu__m->getUserClassGridData();
    }
    private function getFields(){
        return array(
            'USER_CLASS_ID', 'USER_CLASS_NAME', 'PUBLISHED'
            //'USER_ID','USER_CLASS_ID', 'USER_NAME', 'ACTIVATED'// USER_ID BASED
        );
    }
     public function showUserEntryBox(){
        $userClassId = (int) $this->input->post('USER_CLASS_ID');//user_class_based
        //$userId = (int) $this->input->post('USER_ID');
        $id = (int) $this->input->post('PERMIT_ID');
        $arrFields = $this->getFields();
        $arrFieldValues = $result = array();
        if($userClassId){
            $recs = $this->db->get_where($this->tableName, array('USER_CLASS_ID'=>$userClassId));//user_class_based
            //$recs = $this->db->get_where($this->usertable, array('USER_ID'=>$userId));
            //echo $this->db->last_query();exit();
            if($recs && $recs->num_rows()){
                $rec = $recs->row();
                for($i=0; $i<count($arrFields); $i++)
                    $arrFieldValues[ $arrFields[$i] ] = $rec->{ $arrFields[$i] };
            }
        }else{
            for($i=0; $i<count($arrFields); $i++)
                $arrFieldValues[ $arrFields[$i] ] = '';
        }
        $data['arrFieldValues'] = $arrFieldValues;

        $data["selmenu"]=$this->Dms__menu__m->getUserClass_master($userClassId);//user_class_based
        //$data["selmenu"]=$this->Dms__menu__m->getUserClass_master($userId);

        $menu_info = $this->Dms__menu__m->main_memucat();
        foreach ($menu_info as $items) {
            $menu['parents'][$items->PARENT_CATE_ID][] = $items;
        }

        $data['result'] = $this->buildChild(0, $menu);
        $selval=explode(",",$data["selmenu"]["CATEGORY_SELECTED_ALL"]);
        for($i=0;$i<=count($selval);$i++){ 
            $result[$selval[$i]][] = $selval[$i];
        }
        $data['roll'] = $result;
        $access_info = $this->Dms__menu__m->get_access($selval);
        //showArrayValues($access_info);
        foreach ($access_info as $items) {
            $access[$items->PARENT_CATE_ID][] = $items;
        }
       // showArrayValues($access);

        $data['results'] = $access;
        //$data['results'] = $this->buildChild(0, $access);
        //showArrayValues($data['results']);
        $this->load->view('dms/dms_user_class_data_view', $data);
     }
     public function saveUserClass(){
        //showArrayValues($_POST);exit();
        $PERMIT_ID=$this->input->post('PERMIT_ID');
        
        $menu=$this->input->post('menu');
        $edit=$this->input->post('edit');
        $view=$this->input->post('view');

        $menu_ids= implode(",",$menu);
        $edit_ids= implode(",",$edit);
        $view_ids= implode(",",$view);

        $getIds= explode(",",$menu_ids);
        foreach($getIds as $ids){
            $getmenu =  $this->Dms__menu__m->get_parent_menu($ids);
            if(!in_array($getmenu["PARENT_CATE_ID"],$getIds))
            {
                $menu_ids = $getmenu["PARENT_CATE_ID"].",".$menu_ids;
            }                   
        }
        $menu_ids = implode(',', array_unique(explode(',', $menu_ids))); 
        
        $ENTRY_DATE_TIME = date("Y-m-d h:i:s");

        $arrParams = array(
            //'USER_ID'=>$this->input->post('USER_ID'),
            'USER_CLASS_ID'=>$this->input->post('USER_CLASS_ID'),
            'USER_CLASS_NAME'=>$this->input->post('USER_CLASS_NAME'),
            //'USER_NAME'=>$this->input->post('USER_NAME'),
            'PUBLISHED'=>$this->input->post('PUBLISHED'),
            //'ACTIVATED'=>$this->input->post('ACTIVATED'),
            'CATEGORY_SELECTED_ALL'=>$menu_ids,
            'CATEGORY_SELECTED_VIEW'=>$view_ids,
            'CATEGORY_SELECTED_EDIT'=>$edit_ids,
            'ENTRY_DATE_TIME'=>$ENTRY_DATE_TIME
        );
        $arrUpdateVal =array(
            //'USER_ID'=>$this->input->post('USER_ID'),
            'USER_CLASS_ID'=>$this->input->post('USER_CLASS_ID'),
            'USER_CLASS_NAME'=>$this->input->post('USER_CLASS_NAME'),
            //'USER_NAME'=>$this->input->post('USER_NAME'),
            'PUBLISHED'=>$this->input->post('PUBLISHED'),
            //'ACTIVATED'=>$this->input->post('ACTIVATED'),
            'CATEGORY_SELECTED_ALL'=>$menu_ids,
            'CATEGORY_SELECTED_VIEW'=>$view_ids,
            'CATEGORY_SELECTED_EDIT'=>$edit_ids,
            'UPDATE_DATE_TIME' => date("Y-m-d h:i:s")
        );
        //showArrayValues($_POST);
        
        echo $this->Dms__menu__m->saveUserClass($PERMIT_ID,$arrParams,$arrUpdateVal);
     }

    public function menu_add(){

        $id= $this->input->post('id');

        $data["selmenu"]=$this->Dms__menu__m->getmenu_master($id);
        //showArrayValues($data["selmenu"]);exit();

        //$data = array();
        $menu_info = $this->Dms__menu__m->main_memucat();
       // $data["selmenu"]="";
         foreach ($menu_info as $items) {
            $menu['parents'][$items->PARENT_CATE_ID][] = $items;
        }
        $data['result'] = $this->buildChild(0, $menu);

        $selval=explode(",",$data["selmenu"]["MENU_SELECTED"]);
        
     for($i=0;$i<=count($selval);$i++){ 
        $result[$selval[$i]][] = $selval[$i];
                }
                $data['roll'] = $result;
                //showArrayValues($data);
        //showArrayValues($data);
        $this->load->view('dms/dms_menu_data_view',$data);    


/*
        $menu_info = $this->Dms__menu__m->main_memucat();
        $data["selmenu"]=$this->Dms__menu__m->getmenu_master($url);
         foreach ($menu_info as $items) {
            $menu['parents'][$items->PARENT_CATE_ID][] = $items;
        }
        $data['result'] = $this->buildChild(0, $menu);
        
        $selval=explode(",",$data["selmenu"]["MENU_SELECTED"]);
        
     for($i=0;$i<=count($selval);$i++){ 
        $result[$selval[$i]][] = $selval[$i];
                }
                $data['roll'] = $result;
                showArrayValues($data);
        $this->load->view('dms/dms_menu_data_view',$data);   */
    }
    public function show_menu_edit()
    {
        //showArrayValues($this->input->post('id'));
    }
    public function menu_edit($url){ 
        //echo $url=$this->uri->segment(4);
        $menu_info = $this->Dms__menu__m->main_memucat();
        $data["selmenu"]=$this->Dms__menu__m->getmenu_master($url);
         foreach ($menu_info as $items) {
            $menu['parents'][$items->PARENT_CATE_ID][] = $items;
        }
        $data['result'] = $this->buildChild(0, $menu);
        
        $selval=explode(",",$data["selmenu"]["MENU_SELECTED"]);
        
     for($i=0;$i<=count($selval);$i++){ 
        $result[$selval[$i]][] = $selval[$i];
                }
                $data['roll'] = $result;
                //showArrayValues($data);
        $this->load->view('dms/dms_menu_data_view',$data);        
    } 

    public function showEntryBox(){
        $id= $this->input->post('id');
        $menu_info = $this->Dms__menu__m->showEntryBox($id);
        //showArrayValues($menu_info);
         /*foreach ($menu_info as $items) {
            $menu['parents'][$items->PARENT_CATE_ID][] = $items;
        }
        $data['result'] = $this->buildChild(0, $menu);*/
        $this->load->view('dms/dms_menu_data_view',$data);
    }

    public function menu_list(){
        $data["menu_list"] =  $this->Dms__menu__m->getmenu_master();
        //print_r($data["menu_list"]);
        //$this->load->view('dms_menu_index',$data);       
    }
    
    public function add_menu(){
        $menu_name=$this->input->post('menu_name'); 
        $status=$this->input->post('status');
        $menu=$this->input->post('menu');
        $id=$this->input->post('hfid');
               $menu_ids= implode(",",$menu);
       $pram_array=array("MENU_NAME"=>$menu_name,
                                  "STATUS"=>$status,
                                  "MENU_SELECTED"=>$menu_ids,'CREATE_DATE_TIME'=>date("Y-m-d h:i:s"));
             
/*echo "<pre>"; print_r($pram_array); die();*/
                if(!empty($id)){
                    $this->Dms__menu__m->updateMENU($pram_array,$id);
                }else{
                $this->Dms__menu__m->insertmenu($pram_array);
                }                
                redirect("dms/Dms_menu_c");         
    }

   public function buildChild($parent, $menu) {

        if (isset($menu['parents'][$parent])) {

            foreach ($menu['parents'][$parent] as $ItemID) {

                if (!isset($menu['parents'][$ItemID->ID])) {
                    $result[$ItemID->CATEGORY_ENG] = $ItemID->ID;
                }
                if (isset($menu['parents'][$ItemID->ID])) {
                    $result[$ItemID->CATEGORY_ENG][$ItemID->ID] = self::buildChild($ItemID->ID, $menu);
                }
            }
        }
        return $result;
    }
    
    public function del_menu($id) {
        $id=$this->uri->segment(3);  
        $this->db->where('MENU_ID', $id);
        $this->db->delete('dm__menu_master');
        $this->session->set_flashdata('message', 'Your data deleted Successfully..');
        redirect('dms/dms_menu_index');
    }

    public function saveData(){
        //showArrayValues($_POST);EXIT();
        $id = $this->input->post('MENU_ID');
     
        
             $menu=$this->input->post('menu');
             $menu_ids= implode(",",$menu);
             $getIds= explode(",",$menu_ids);
             
             foreach($getIds as $ids)
             {
            $getmenu =  $this->Dms__menu__m->get_parent_menu($ids);
        
                if(!in_array($getmenu["PARENT_CATE_ID"],$getIds))
                {
                     $menu_ids = $getmenu["PARENT_CATE_ID"].",".$menu_ids;
                }                   
             }
            $menu_ids = implode(',', array_unique(explode(',', $menu_ids))); 
            //$menu_ids=    str_replace(",Array","",$menu_ids);
                $pram_array=array("MENU_NAME"=>$this->input->post('menu_name'),
                                  "STATUS"=>htmlspecialchars($this->input->post('status')),
                                  "MENU_SELECTED"=>$menu_ids,'CREATE_DATE_TIME'=>date("Y-m-d h:i:s"));
            

        //showArrayValues($arrValues);
        //exit();
       $this->Dms__menu__m->saveData($id,$pram_array);
    }   
    public function Active(){
        $data = array('ID'=>$this->input->post('ID'),'STATUS'=>$this->input->post('STATUS'));
        showArrayValues($data);
        echo $this->Dms__menu__m->Active($data);
    }
}
?> 