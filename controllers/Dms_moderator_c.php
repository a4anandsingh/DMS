<?php
error_reporting(E_ALL);
class Dms_moderator_c extends MX_Controller
{
    var $message;
    function __construct()
    {
        parent::__construct();
        $this->message = array();

        $this->load->model('dms/Dms__moderator__m');
    }

    function index()
    {
        $data['page_heading'] = pageHeading("Document Management System - Moderator");
        $data['userId'] = getSessionDataByKey('USER_ID');
        $data['grid'] = $this->createGrid();
        $data['gridPublished'] = $this->createGridPublished();

        //  print_r($data['gridPublished']); exit;
        $this->load->view('dms/dms_moderator_view', $data);
    }
    private function getPermissions()
    {
        return getAccessPermissions('DMS_FILEUPLOAD', $this->session->userData('USER_ID'));
    }
    function getFileUploadGrid()
    {
        $userId = getSessionDataByKey('USER_ID');
        echo $this->Dms__moderator__m->getFileUploadGrid($userId);
    }
    private function createGrid()
    {
        $permissions = $this->getPermissions();
        $buttons = array();
        $mfunctions = array();
        if ($permissions['MODIFY']) {
            array_push($buttons, "{ caption:'', title:'Edit Record',position :'first',
                buttonicon : 'ui-icon-pencil',
                onClickButton:function(){Operation(BUTTON_MODIFY,0);}, cursor: 'pointer'}");
        }
        if ($permissions['ADD']) {
            array_push($buttons, "{ caption:'', title:'Add New Record',position :'first', 
                buttonicon : 'ui-icon-plus', 
                onClickButton:function(){Operation(BUTTON_ADD_NEW,4);}, cursor: 'pointer'}");
        }
        array_push($mfunctions, "ondblClickRow: function(ids){Operation(BUTTON_MODIFY,0);}");
        $cols = array(
            array(
                'label' => 'Id',
                'name' => 'ID',
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
                'label' => 'File Name',
                'name' => 'FILE_NAME_ENG',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'File Name Hindi',
                'name' => 'FILE_NAME_HINDI',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Letter No ',
                'name' => 'LETTER_NO',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Letter Date ',
                'name' => 'LETTER_DATE',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Linked Section Name',
                'name' => 'SECTION_NAME',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Linked Category Name',
                'name' => 'CATEGORY_ID',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Access Level',
                'name' => 'ACCESS_LEVEL',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Publication Status',
                'name' => 'STATUS',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            )
        );
        array_push($cols, array(
            'label' => 'Last Updated Date',
            'name' => 'UPDATED_AT',
            'width' => 30,
            'align' => "center",
            'resizable' => false,
            'sortable' => true,
            'hidden' => false,
            'view' => true,
            'search' => true,
            'formatter' => '',
            'searchoptions' => ''
        ));

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

    public function Active()
    {
        $data = array('ID' => $this->input->post('id'), 'STATUS' => $this->input->post('status'));
        echo $this->Dms__moderator__m->Active($data);
    }
    function showEntryBox()
    {
        $data = $arrData = array();
        $id = (int) trim($this->input->post('id'));
        $userId = (int) trim($this->input->post('userId'));
        $data['status'] = $this->Dms__moderator__m->getPublishedByUser($userId);
        // $userclassId = $this->Dms__moderator__m->getUserbyclassId($userId);
        // $data['userSelcat'] = $this->Dms__moderator__m->getcategoryItems($userId);
        $data['arrData'] = $arrData = $this->Dms__moderator__m->showEntryBox($id);
        $data['requestedStatus'] = '';
        if ($this->input->post('reqStatus') == md5("PUBLISHED")) {
            $data['requestedStatus'] = 'PUBLISHED';
        }

        $data['getWebsiteStatus'] = $this->Dms__moderator__m->getWebsiteStatus($userId);
        /* 
        showArrayValues($data);
        exit; */
        $this->load->view('dms/dms_moderator_publication', $data);
    }

    function changeCategory()
    {
        $SECTION_ID = $this->input->post('SECTION_ID');
        $CATEGORY_ID = $SECTION_ID; // $this->input->post('CATEGORY_ID');
        $CATEGORY_ID_SEL = $this->input->post('CATEGORY_ID');
        $getdata = $this->Dms__moderator__m->cateSubcatTable($CATEGORY_ID);

        $opt = '<option value="">Select Category</option>';
        //(('.$value.'== '.$category_tree.')?" selected="selected"" :"" ) 
        $getsuncat = explode(",", $_POST["subcat_ID"]);
        $userclassId = $this->Dms__moderator__m->getUserbyclassId(getSessionDataByKey('USER_ID'));
        $Permission_row = $this->Dms__moderator__m->getUserPermission_row($userclassId);

        $info = explode(",", $Permission_row["CATEGORY_SELECTED_ALL"]);
        //exit;
        foreach ($getdata as $key => $value) {
            //( '.$CATEGORY_ID.'=='.$value['id'].' ? "selected="selected"" : "")
            if (empty($_POST["subcat_ID"])) {
                $opt .= '<option' . ($value['id'] == $CATEGORY_ID_SEL ? ' selected="selected"' : "")  . ' value="' . $value['id'] . '">' . $value['name'] . '</option>';
            } else {

                //if(in_array($value['id'],$getsuncat)){
                if (in_array($value['id'], $info)) {
                    // $opt.='<option'. ($value['id'] == $CATEGORY_ID ? ' selected="selected"' :"")  .' value="'.$value['id'].'">'.$value['name'].'</option>';
                }
                //}
            }
        }
        echo $opt;
    }

    function savedata()
    {
        $id = $this->input->post('ID');
        $error = 0;
        $userclassId = $this->Dms__moderator__m->getUserbyclassId(getSessionDataByKey('USER_ID'));
        $officeId = $this->Dms__moderator__m->getOfficeIdbyUser(getSessionDataByKey('USER_ID'));

        $recs = $this->db->select("*")
            ->from("dm__files")
            ->where("ID", $_POST["ID"])
            ->get();
        $rec = $recs->row();
        $old_value = $rec->STATUS;

        $fileData = array(
            'STATUS' => htmlspecialchars($this->input->post('STATUS')),
        );

        $result = $this->db->update('dm__files', $fileData, array('ID' => $id));

        // Log the update into the trigger log table
        if ($result) {
            $this->Dms__moderator__m->insertLog('dm_files', $id, $old_value);
        }


        if (!$error) {
            array_push($this->message, getMyArray(true, "File status has been updated successfully."));
        } else {
            array_push($this->message, getMyArray(false, "Some thing went wrong please try again after some time."));
        }

        echo $this->createJSONResponse($error, $id, $this->message);
    }

    function createJSONResponse($error, $id, $arr)
    {
        return json_encode(array('responseCount' => count($arr), 'error' => "$error", 'fileId' => $id, 'responses' => $arr));
    }
    private function createGridPublished()
    {
        $permissions = $this->getPermissions();
        $buttons = array();
        $mfunctions = array();
        if ($permissions['MODIFY']) {
            array_push($buttons, "{ caption:'', title:'Edit Record',position :'first',
                buttonicon : 'ui-icon-pencil',
                onClickButton:function(){OperationPublished(BUTTON_MODIFY,0);}, cursor: 'pointer'}");
        }
        if ($permissions['ADD']) {
            array_push($buttons, "{ caption:'', title:'Add New Record',position :'first', 
                buttonicon : 'ui-icon-plus', 
                onClickButton:function(){OperationPublished(BUTTON_ADD_NEW,4);}, cursor: 'pointer'}");
        }
        array_push($mfunctions, "ondblClickRow: function(ids){OperationPublished(BUTTON_MODIFY,0);}");
        $cols = array(
            array(
                'label' => 'Id',
                'name' => 'ID',
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
                'label' => 'File Name',
                'name' => 'FILE_NAME_ENG',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'File Name Hindi',
                'name' => 'FILE_NAME_HINDI',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Letter No ',
                'name' => 'LETTER_NO',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Letter Date ',
                'name' => 'LETTER_DATE',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Linked Section Name',
                'name' => 'SECTION_NAME',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Linked Category Name',
                'name' => 'CATEGORY_ID',
                'width' => 30,
                'align' => "left",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Access Level',
                'name' => 'ACCESS_LEVEL',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            ),
            array(
                'label' => 'Publication Status',
                'name' => 'STATUS',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''
            )
        );
        array_push($cols, array(
            'label' => 'Published Date',
            'name' => 'UPDATED_AT',
            'width' => 30,
            'align' => "center",
            'resizable' => false,
            'sortable' => true,
            'hidden' => false,
            'view' => true,
            'search' => true,
            'formatter' => '',
            'searchoptions' => ''
        ));
        /*if($status==1){
            array_push($cols,array('label' => 'Publication Status',
                'name' => 'STATUS',
                'width' => 30,
                'align' => "center",
                'resizable' => false,
                'sortable' => true,
                'hidden' => false,
                'view' => true,
                'search' => true,
                'formatter' => '',
                'searchoptions' => ''));
        }*/
        $aData = array(
            'set_columns' => $cols,
            'custom' => array("button" => $buttons, "function" => $mfunctions),
            'div_name' => 'fileUploadedGrid',
            'source' => 'getFileUploadedGrid',
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
            'caption' => '<span class="cus-dam-1"></span> Published Files Information',
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
    function getFileUploadedGrid()
    {
        $userId = getSessionDataByKey('USER_ID');
        echo $this->Dms__moderator__m->getFileUploadedGrid($userId);
    }
    /* 
    function getSectionItemsById()
    {
        $SECTION_ID = $this->input->post('SECTION_ID');
        echo  $opt = $this->Dms__moderator__m->getSectionItemsById($SECTION_ID);
    }

    function getCategoryItemsById()
    {
        $SECTION_ID = $this->input->post('SECTION_ID');
        $CATEGORY_ID = $SECTION_ID; // $this->input->post('CATEGORY_ID');
        $CATEGORY_ID_SEL = $this->input->post('SECTION_ID');
        $opt = $this->Dms__moderator__m->getCategoryItemsById($CATEGORY_ID_SEL);
        echo $opt;
     } */
      
}
