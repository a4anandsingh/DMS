<?php
error_reporting(E_ALL);
class Dms_search_c extends MX_Controller
{
    var $message;
    function __construct()
    {
      parent:: __construct();
      $this->message = array();
      
      /*$this->load->model('dms/Dms__search__m');*/
    }
    function index()
    {                
      $data['page_heading'] = pageHeading("Document Management System");      
      $data['grid'] = $this->createGrid();
      $this->load->view('dms/search/dms_search_index_view', $data);
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
            array('label' => 'File Name',
                'name' => 'FILE_NAME_ENG',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'File Name Hindi',
                'name' => 'FILE_NAME_HINDI',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Letter No ',
                'name' => 'LETTER_NO',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Letter Date ',
                'name' => 'LETTER_DATE',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Linked Section Name',
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
            array('label' => 'Category Name',
                'name' => 'CATEGORY_ID',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''),
            array('label' => 'Access Level',
                'name' => 'ACCESS_LEVEL',
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
            'div_name' => 'fileUploadGrid',
            'source' => 'getFileUploadGrid',
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
            'caption' => '<span class="cus-dam-1"></span> Upload Files Information',
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
        return getAccessPermissions('DMS_FILEUPLOAD', $this->session->userData('USER_ID'));
    }
    function getFileUploadGrid(){
      echo $this->Dms__fileupload__m->getFileUploadGrid();
    }
    function changeCategory(){
        $SECTION_ID = $this->input->post('SECTION_ID');
        $CATEGORY_ID = $this->input->post('CATEGORY_ID');

       $getdata = $this->Dms__fileupload__m->cateSubcatTable($SECTION_ID);

       $opt ='<option value="">Select Category</option>';
       //(('.$value.'== '.$category_tree.')?" selected="selected"" :"" ) 
       foreach ($getdata as $key => $value) {
            //( '.$CATEGORY_ID.'=='.$value['id'].' ? "selected="selected"" : "")

           $opt.='<option'. ($value['id'] == $CATEGORY_ID ? ' selected="selected"' :"")  .' value="'.$value['id'].'">'.$value['name'].'</option>';
       }
        echo $opt;
    }
    function showEntryBox(){
        $data = array();
        $id = (int) trim($this->input->post('id'));
        $arrData = array();
        $data['arrData'] = $arrData= $this->Dms__fileupload__m->showEntryBox($id); 
        //showArrayValues($data['arrData']);
        //get section
        $data['section'] = $this->Dms__fileupload__m->section_pulldown($data['arrData']['SECTION_ID']);
        //get category
        $data['category_tree'] = $this->Dms__fileupload__m->cateSubcatTable();
        
        //showArrayValues($data['category_tree']);
        //showArrayValues($data['arrData']); //exit;
        $this->load->view('dms/dms_fileupload',$data);
    }
  
    function showSectionEntryBox(){
        $data['SECTION_NAME'] = $this->Dms__fileupload__m->section_pulldown();

        //load all of your view data
        $this->load->view('dms_fileupload', $data);

    }

    
    function savedata(){
        $id= $this->input->post('ID');
        $FILE_NAME_ENG = $this->input->post('FILE_NAME_ENG');
        $FILE_NAME_HINDI = $this->input->post('FILE_NAME_HINDI');
        $FILE_DESCRIPTION = $this->input->post('FILE_DESCRIPTION');
        $FILE_DESCRIPTION_HINDI = $this->input->post('FILE_DESCRIPTION_HINDI');
        $LETTER_NO = $this->input->post('LETTER_NO');  
        $LETTER_DATE = $this->input->post('LETTER_DATE');      

        $UPLOAD_FILE_PATH="";
        $USER_FILE="";
        $UPLOAD_FILE_PATH ="";
        $UPLOADED_FILE ="";
        $sectionId = trim($this->input->post('SECTION_ID'));
        $categoryId = trim($this->input->post('CATEGORY_ID'));

        $insert_data = array(
            'FILE_NAME_ENG'=>$this->input->post('FILE_NAME_ENG'),
            'FILE_NAME_HINDI'=>$this->input->post('FILE_NAME_HINDI'),
            'FILE_DESCRIPTION'=>$this->input->post('FILE_DESCRIPTION'),
            'FILE_DESCRIPTION_HINDI'=>$this->input->post('FILE_DESCRIPTION_HINDI'),
            'LETTER_NO'=>$this->input->post('LETTER_NO'),
            'LETTER_DATE'=>$this->input->post('LETTER_DATE'),
            'SECTION_ID'=>$sectionId,
            'CATEGORY_ID'=>$categoryId ,
            //'FILE_PATH'=> $UPLOAD_FILE_PATH,
            //'USER_FILE'=>$UPLOADED_FILE,
            'ACCESS_LEVEL'=>htmlspecialchars($this->input->post('ACCESS_LEVEL')),
            'STATUS'=>htmlspecialchars($this->input->post('STATUS')),
            'UPLOAD_DATE_TIME'=>date("Y-m-d H:i:s")
        );
        $insertId = 0;
        if($id == 0){            
            $this->db->insert('dm__files', $insert_data);
            $insertId = $this->db->insert_id();            
        }else{
            $result =$this->db->update('dm__files', $insert_data, array('ID' => $id));
            $insertId = $id;
        }        

        if($this->db->affected_rows()){
            array_push($this->message, getMyArray(true, "Data updated successfully."));
        }else{
            array_push($this->message, getMyArray(false, "Data Inserted successfully."));         
        }
        $error = false;
        //if file uploaded true
        if($_FILES['UPLOAD_FILE']['error']==0){
            // Get section name
            $sectionName = $this->getSectionName($sectionId);            
            // get Category hierarchy path //array type
            $this->load->model('dms/Dms__cate__m');
            $arrCategoryPath = $this->Dms__cate__m->getPath($categoryId);
            //$error = false;

            $this->load->model('dms/Dms__cate__m');
            $arrCategoryPath = $this->Dms__cate__m->getPath($categoryId);
            $arrCategoryName = array();
            foreach ($arrCategoryPath as $key => $value) {
                if($value == ''){
                    continue ;
                }
                $arrCategoryName[] = $this->getCategoryName($value);
            }
            $filePath = FCPATH.'dms_uploads'.DIRECTORY_SEPARATOR.$sectionName.DIRECTORY_SEPARATOR.(implode('/', $arrCategoryName)); 
            $directoryStructure = 'dms_uploads'."/".$sectionName."/".(implode('/', $arrCategoryName));
            if(is_dir($filePath)){                
            }else{
                if (!mkdir($filePath, 0777, true)){
                    die('1-Failed to create folders...');
                }
            }
            chmod($filePath, 0777);
            $config['upload_path']          = $filePath.DIRECTORY_SEPARATOR;
            $config['allowed_types']        = 'jpg|zip|pdf'; //()
            $config['encrypt_name']         = 'TRUE';
            $config['max_filename']         = '35';
            $config['remove_spaces']        = 'TRUE';
            //$config['max_size']           = (MAX_UPLOAD_SIZE*1024);
            $this->load->library('upload', $config);        
            $field_name = "UPLOAD_FILE";
            if ( ! $this->upload->do_upload($field_name)){
                array_push($this->message, getMyArray(false, "Upload File -".$this->upload->display_errors()));
                $error=true;
            } else {
                array_push($this->message, getMyArray(true, "File Uploaded Successfully"));
                $UPLOAD_FILE_ARRAY = $this->upload->data();
                $UPLOAD_FILE_PATH = $UPLOAD_FILE_ARRAY['file_name'];
                $UPLOADED_FILE = $UPLOAD_FILE_ARRAY['client_name'];
                $UPLOAD_FILE_PATH =  $directoryStructure."/".$UPLOAD_FILE_PATH;

                //here file is uploaded // now we find if other file is uploaded before
                $fileTobeDeleted ='';
                if($id > 0){
                    $recs = $this->db->select("FILE_PATH")
                                ->from("dm__files")
                                ->where("ID", $id)
                                ->get();
                    if($recs && $recs->num_rows()){
                        $rec = $recs->row();
                        $fileTobeDeleted =  $rec->FILE_PATH;                        
                        if($fileTobeDeleted!="" && file_exists(FCPATH.$fileTobeDeleted)){
                            unlink(FCPATH.$fileTobeDeleted);
                        }
                    }
                }
                $fileData = array(
                    'FILE_PATH'=> $UPLOAD_FILE_PATH,
                    'USER_FILE'=>$UPLOADED_FILE
                );                
                $result =$this->db->update('dm__files', $fileData, array('ID' => $insertId));
            }
        }

        if(!$error){
            array_push($this->message, getMyArray(true, "File has been uploaded successfully."));
        }else{
            array_push($this->message, getMyArray(false, "Some thing went wrong please try again after some time."));
        }

        echo $this->createJSONResponse($error,$id,$this->message);
    }

    function createJSONResponse($error=false,$id,$arr){
        return json_encode(array('responseCount'=> count($arr), 'error'=>"$error", 'fileId'=>$id, 'responses'=>$arr));
    }

    function show_sucess(){
        $fileId = trim($this->input->post('fileId'));
        $FIELD_NAMES = $this->getFields();
        $FIELD_VALUES = array();
        $recs = $this->db->get_where('dm__files', array('ID' => $fileId), 1);
        
        if($recs && $recs->num_rows()){
            $rec = $recs->row();            
            for($i=0; $i<count($FIELD_NAMES); $i++){
                $FIELD_VALUES[ $FIELD_NAMES[$i] ] = $rec->{ $FIELD_NAMES[$i] };
            }
        }else{
            for($i=0; $i<count($FIELD_NAMES); $i++){
                $FIELD_VALUES[ $FIELD_NAMES[$i] ] = '';
            }
        }
        $data['FIELD_VALUES'] = $FIELD_VALUES;
        $arrButtons = array();            
        array_push(
            $arrButtons,
            getButton('Close', 'closeDialog();', 4, 'icon-remove-sign')
        );
            
        $data['buttons'] = implode('&nbsp;', $arrButtons);
        $this->load->view('dms/dms_fileupload_view', $data);        
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
    
    protected function getCategoryName($categoryId){
        $recs = $this->db->select("SLUG")
                    ->from("dm__category")
                    ->where("ID", $categoryId)
                    ->get();
        if($recs && $recs->num_rows()){
            $rec = $recs->row();
            return $rec->SLUG;
        }
    }

    public function Active(){
        $data = array('ID'=>$this->input->post('id'),'STATUS'=>$this->input->post('status'));
        echo $this->Dms__fileupload__m->Active($data);
    }
}
?>