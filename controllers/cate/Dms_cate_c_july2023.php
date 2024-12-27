<?php
error_reporting(E_ALL);
class Dms_cate_c extends MX_Controller
{
    var $message;
    function __construct()
    {
      parent:: __construct();
      $this->message = array();
      
      $this->load->model('dms/Dms__cate__m');
    }
    function index()
    {
        $paths=$this->Dms__cate__m->getPath(12);
       //showArrayValues($paths);
       //exit();
      $data['page_heading'] = pageHeading("Document Management System");
      
      $data['grid'] = $this->createSectionGrid().$this->createCategoryGrid();
      $this->load->view('dms/dms_category_view', $data);
    }
    private function createSectionGrid(){
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
                onClickButton:function(){SectionOperation(BUTTON_MODIFY,0);}, cursor: 'pointer'}");
        }
        if($permissions['ADD']){
     
            array_push($buttons, "{ caption:'', title:'Add New Record',position :'first', 
                buttonicon : 'ui-icon-plus', 
                onClickButton:function(){SectionOperation(BUTTON_ADD_NEW,4);}, cursor: 'pointer'}");
        }
        array_push($mfunctions, "ondblClickRow: function(ids){SectionOperation(BUTTON_MODIFY,0);}");
        $cols = array(
            array('label' => 'Id',
                'name' => 'ID',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => true,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Section Name',
                'name' => 'CATEGORY_ENG',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Section Name Hindi',
                'name' => 'CATEGORY_HINDI',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Status',
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
            'div_name' => 'sectionGrid',
            'source' => 'getSectionGrid',
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
            'caption' => '<span class="cus-dam-1"></span> Manage Section',
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
    function getSectionGrid(){
      echo $this->Dms__cate__m->getSectionGrid();
    }
    private function createCategoryGrid(){
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
            array('label' => 'Id',
                'name' => 'ID',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => true,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Category Name',
                'name' => 'CATEGORY_ENG',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Category Name Hindi',
                'name' => 'CATEGORY_HINDI',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            /*array('label' => 'Parent Category Id ',
                'name' => 'PARENT_CATE_ID',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),*/
            array('label' => 'Linked Section ',
                'name' => 'SECTION_NAME',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),

            array('label' => 'Linked Category ',
                'name' => 'CATEGORY_NAME',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => false,
                'hidden' => false,
                'view' => true,
                'search' => false,
                'formatter' => '',
                'searchoptions' => ''),
            
            array('label' => 'Status',
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
            'div_name' => 'categoryGrid',
            'source' => 'getCategoryGrid',
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
            'caption' => '<span class="cus-dam-1"></span> Manage Category',
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
        return getAccessPermissions('DMS_CATEGORY', $this->session->userData('USER_ID'));
    }
    function getCategoryGrid(){
      echo $this->Dms__cate__m->getCategoryGrid();
    }
    function showEntryBox(){
        $data = array();
        $id = (int) trim($this->input->post('id'));
        $arrData = array();
        $data['arrData'] = $arrData= $this->Dms__cate__m->showEntryBox($id); 
        
        //get section
        $data['section'] = $this->Dms__cate__m->section_pulldown($arrData['SECTION_ID']);
        //get category
        $data['category_tree'] = $this->Dms__cate__m->cateSubcatTable();
        //showArrayValues($data['arrData']); //exit;
        $this->load->view('dms/dms_category',$data);
    }
    function saveData(){
      //print_r($_POST);exit();
        $id = $this->input->post('ID');
        //if($this->input->post('PARENT_CATE_ID')==0){
            $categoryId = $this->Dms__cate__m->getmaxcatId();
        /*}else{
            $categoryId = $this->Dms__cate__m->getCategoryId(array('SECTION_ID'=>$this->input->post('SECTION_ID'),'ID'=>$this->input->post('PARENT_CATE_ID')));
        }*/

        if($this->input->post('PARENT_CATE_ID')=="" AND $this->input->post('PARENT_CATE_ID')==0){
            $parent_cat_id = htmlspecialchars($this->input->post('SECTION_ID'));
        }else{
            $parent_cat_id = htmlspecialchars($this->input->post('PARENT_CATE_ID'));
        }
        $menu_section=  str_pad($this->input->post('SECTION_ID'),3,"0",STR_PAD_LEFT);
        $menu_parent_cat=  str_pad($this->input->post('PARENT_CATE_ID'),3,"0",STR_PAD_LEFT);
        $menu_cat_id=  str_pad($categoryId,3,"0",STR_PAD_LEFT);
		//$part1= str_replace(" ","-",$this->input->post('CATEGORY_ENG'));
        $section_slug= $this->Dms__cate__m->getsectionName($menu_section);
		//if(!empty($section_slug)){
		$HIERARCHY_PATH_SLUG=str_replace(" ","-",$section_slug);
		// }else{
		// $HIERARCHY_PATH_SLUG="";	
		// }
		$category_slug= $this->Dms__cate__m->getCategoryName($menu_parent_cat);
		if(!empty($category_slug)){
		$category_slug=str_replace(" ","-",strtolower($category_slug));
		 $HIERARCHY_PATH_SLUG=strtolower($HIERARCHY_PATH_SLUG).'/'.$category_slug;
		 }
		 
		
		if($_POST["CHK_RADIO"]==1)
		{
		$section_count=$this->Dms__cate__m->getsectionByname(ltrim($_POST['CATEGORY_ENG']));
		if($section_count ==0)
		{
			
		}else{ 
		echo 	$section_count;
		die();
		}
		}
		
		$arrValues = array(
        'CATEGORY_ENG'=>ltrim($_POST['CATEGORY_ENG']),
        'CATEGORY_HINDI'=>$this->input->post('CATEGORY_HINDI'),
        'SECTION_ID'=>htmlspecialchars($this->input->post('SECTION_ID')),
        'PARENT_CATE_ID'=> $parent_cat_id,
        'SLUG'=>$this->removeSpecialChars($this->input->post('CATEGORY_ENG')),     
        'MENU_CODE'=>$menu_section.'/'.$menu_parent_cat.'/'.$menu_cat_id,
        'STATUS'=>htmlspecialchars($this->input->post('STATUS')),
        'CHK_RADIO' => $this->input->post('CHK_RADIO')
      );
	  
        //showArrayValues($arrValues);exit();
      
	  echo $this->Dms__cate__m->saveData($id,$arrValues);
	  
	}
    /*function showSectionEntryBox(){
      $id = htmlspecialchars((int) $this->input->post('id'));
      $data['arrData'] = $this->HeadMaster__m->showSecEntryBox($id);
      //showArrayValues($data['arrData']);
      if(!$data['arrData']) {
        echo "<span class='label label-danger' style='font-size:15pt'> You Can't Edit. </span>";
        return;
      }
      $this->load->view('dms_category_view',$data);
    }*/
     function showSectionEntryBox(){
        $data['SECTION_NAME'] = $this->Dms__cate__m->section_pulldown();

    //load all of your view data
    $this->load->view('dms_category', $data);

    }
   /* function nestedDirectory($cateSubcatTable, $parent = 0, $spacing = '', $user_tree_array = ''){
    foreach($cateSubcatTable as $cateSubcatTable){
        return  "<option>". str_repeat("-", $level) . $cateSubcatTable->name . "</option>";
         if ( count($term->terms)){
             nestedDirectory($term->terms, $level+1);
         } 
    }
} */
/*function fetch_all_category($parent = 0, $spacing = '', $user_tree_array = ''){

    foreach($user_tree_array as $array){

        echo "<li>".$user_tree_array->CATEGORY_ENG."</li>";
        
        if(!empty($user_tree_array->$parent)){

            echo "<ul>";

            fetch_all_category();

            echo "</ul>";
        }       

    }

}*/

protected function removeSpecialChars($text){
    $string = preg_replace("/[^a-zA-Z0-9]+/", "-", $text);
    $string = strtolower($string);
    return $string;
}

    public function ActiveCategory(){
        $data = array('ID'=>$this->input->post('id'),'STATUS'=>$this->input->post('status'));
        echo $this->Dms__cate__m->ActiveCategory($data);
    }
    public function ActiveSection(){
        $data = array('ID'=>$this->input->post('id'),'STATUS'=>$this->input->post('status'));
        echo $this->Dms__cate__m->ActiveSection($data);
    }

public function changeCategory(){
        $SECTION_ID = $this->input->post('SECTION_ID');
        $CATEGORY_ID = $this->input->post('PARENT_CATE_ID');

       $getdata = $this->Dms__cate__m->cateSubcatTable($SECTION_ID);
       //showArrayValues($getdata);
       $opt ='<option value="">Select Parent Category</option>';
       /*$opt ='<option '. ($value['parent_id'] == 0 ? ' selected="selected"' :"")  .' value="'.$value['parent_id'].'">Root Category</option>';*/
       //(('.$value.'== '.$category_tree.')?" selected="selected"" :"" ) 
       foreach ($getdata as $key => $value) {
            //( '.$CATEGORY_ID.'=='.$value['id'].' ? "selected="selected"" : "")
            /*$opt ='<option '. ($value['parent_id'] == 0 ? ' selected="selected"' :"")  .' value="'.$value['parent_id'].'">Root Category</option>';*/
           $opt.='<option'. ($value['id'] == $CATEGORY_ID ? ' selected="selected"' :"")  .' value="'.$value['id'].'">'.$value['name'].'</option>';

       }
       //showArrayValues($CATEGORY_ID);
        echo $opt;
    }

/*public function getParentData(){
         $this->db->select('*')
                ->from($this->dm__category)
                ->where('ID', $id);
            $recs = $this->db->get();
            if($recs && $recs->num_rows()){
                $rec = $recs->explode(('-',row()));
                return ($rec->HIERARCHY_PATH);
                $recs->free_result();
            }else return('');
    }*/

}
?>