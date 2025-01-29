<?php date_default_timezone_set('Asia/Kolkata');
class Dms__fileupload__m extends CI_Model
{
    var $message;
    var $catRows;
    var $catOptions;
    function __construct()
    {
        parent::__construct();
        //$this->setup = AGREEMENT_DB.'.new';
        $this->message = array();
        $this->dm__files = 'dm__files';
        $this->dm__sections = 'dm__sections';
        $this->dm__category = 'dm__category';
        $this->dm__user_permission = 'dm__user_permission';
        $this->tbl_user = 'usr__m_users';
        $this->catRows = "";
        $this->catOptions = "";
    }
    function saveData($id, $arrValues)
    {

        if ($id == 0) {
            $editMode = 0;
            $this->db->insert($this->dm__files, $arrValues);
        } else {
            $editMode = 1;
            $this->db->update($this->dm__files, $arrValues, array('ID' => $id));
        }
        if ($this->db->affected_rows()) {
            array_push($this->message, getMyArray(true, 'File Details  ' . (($editMode) ? 'Updated' : 'Saved') . '...'));
        }
        return createJSONResponse($this->message);
    }
    function getFileUploadGrid($userId)
    {
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        $selId = 0;
        $holdingPerson = getSessionDataByKey('HOLDING_PERSON');
        //$officeId = getSessionDataByKey('CURRENT_OFFICE_ID');
        $userclassId = $this->getUserbyclassId($userId);
        $officeId = $this->getOfficeIdbyUser($userId);
        $userPermission = $this->getUserPermission($userclassId);

        $selectedView = $this->getPublishedByUser($userId);
        $recUser = $userPermission->row();
        if ($recUser) {
            $selId = $recUser->CATEGORY_SELECTED_EDIT;
        }
        //showArrayValues($recUser);
        $objFilter->SQL = 'SELECT file.*, sections.ID as SECTION_ID, sections.CATEGORY_ENG as SECTION_NAME,  category.CATEGORY_ENG
            FROM ' . $this->dm__files . ' file
            LEFT JOIN ' . $this->dm__category . ' sections ON sections.ID = file.SECTION_ID
            LEFT JOIN ' . $this->dm__category . ' category ON category.ID = file.CATEGORY_ID
            where file.STATUS <> 1 AND file.SECTION_ID IN (' . $selId . ') AND file.OFFICE_ID = ' . $officeId . ' ORDER BY file.ID DESC ';
        $objFilter->executeMyQuery();
        //echo $objFilter->PREPARED_SQL; //exit;
        $arr_accessLevel = array('1' => 'Public', '2' => 'Private', '3' => 'Both');
        if ($objFilter->RESULT) {
            foreach ($objFilter->RESULT as $row) {
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->ID) . '"');
                array_push($fieldValues, '"' . addslashes(cleanDataForGrid($row->FILE_NAME_ENG)) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_NAME_HINDI) . '"');
                /*array_push($fieldValues, '"' . addslashes(clearDataForGrid($row->FILE_NAME_ENG)) . '"');
                array_push($fieldValues, '"' . addslashes(clearDataForGrid($row->FILE_NAME_HINDI)) . '"'); 22 Aug 2022*/
                /* array_push($fieldValues, '"' . addslashes($row->FILE_DESCRIPTION) . '"');*/
                array_push($fieldValues, '"' . addslashes($row->LETTER_NO) . '"');
                array_push($fieldValues, '"' . addslashes($row->LETTER_DATE) . '"');
                /*array_push($fieldValues, '"' . addslashes($row->FILE_TYPE) . '"');*/
                /*array_push($fieldValues, '"' . addslashes($row->FILE_URL) . '"');*/
                array_push($fieldValues, '"' . addslashes($row->SECTION_NAME) . '"');
                array_push($fieldValues, '"' . addslashes($row->CATEGORY_ENG) . '"');
                array_push($fieldValues, '"' . addslashes($arr_accessLevel[$row->ACCESS_LEVEL]) . '"');
                if (in_array($row->SECTION_ID, explode(",", $selectedView))) {
                    array_push($fieldValues, '"' . addslashes($this->showButton($row->ID, $row->STATUS)) . '"');
                } else {
                    array_push($fieldValues, '"' . addslashes('') . '"');
                }
                /*if ($holdingPerson==2) {
                    array_push($fieldValues, '"' . addslashes( $this->showButton($row->ID,$row->STATUS) ) . '"');
                }else{
                    array_push($fieldValues, '"' . addslashes('') . '"');
                }*/
                array_push($objFilter->ROWS, '{"id":"' . $row->ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }
    private function showButton($id, $status)
    {
        $fileStatus = $this->getWebsiteStatus(0);
        if (array_key_exists($status, $fileStatus)) {
            return getButton($fileStatus[$status], 'Active(2,' . $id . ')', 4, '');
        }
        exit;
        /*Start 09-02-2022*/
        /*         if ($status == 1) {
            return getButton('Published', '');
        }
        if ($status == 3) {
            return getButton('Draft', 'Active(4,' . $id . ')', 4, '');
        }
        if ($status == 4) {
            return getButton('Under Review', 'Active(4,' . $id . ')', 4, '');
        } if ($status == 5) {
            return getButton('Reverted by Moderator', 'Active(4,' . $id . ')', 4, '');
        } else {
            return getButton('UnPublished', 'Active(4,' . $id . ')', 4, '');
        } */
        /*End 09-02-2022*/
    }
    public function getPublishedByUser($userId)
    {
        $rec = '';
        $userClassId = $this->getUserbyclassId($userId);
        $this->db->select('CATEGORY_SELECTED_VIEW');
        $this->db->from($this->dm__user_permission);
        $this->db->where('USER_CLASS_ID', $userClassId);
        $recs = $this->db->get();
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row()->CATEGORY_SELECTED_VIEW;
            /*if($rec->CATEGORY_SELECTED_VIEW)// for publish rights 
                $status=1;*/
        }
        return $rec;
    }
    public function Active($data)
    {

        $currentStatus = $this->db->get_where(
            $this->dm__files,
            ['ID' => $data['ID']],
            1
        )
            ->row_array()['STATUS'];
        // Check if the requested status is the same as the current status
        if ($currentStatus === $data['STATUS']) {
            return false; // No update needed, restrict the operation
        }


        $isUpdated = $this->db->update(
            $this->dm__files,
            ['STATUS' => $data['STATUS']],
            ['ID' => $data['ID']]
        );

        if ($isUpdated) {
            // Log the update
            $this->Dms__moderator__m->insertLog('dm_files', $data['ID'], $data['STATUS']);
        }

        return $isUpdated;
    }


    public function getSectionData()
    {
        return $this->getFields($this->dm__files); //db table name 
    }
    protected function getFields($table)
    {
        $strSQL = 'SHOW COLUMNS FROM ' . $table;
        $recs = $this->db->query($strSQL);
        $arrNames = array();
        if ($recs && $recs->num_rows()) {
            foreach ($recs->result() as $rec) {
                array_push($arrNames, $rec->Field);
                $recs->free_result();
            }
        }
        return $arrNames;
    }
    /*public function showEntryBox($id){
        //$arrFields = $this->getSectionData();
        $arrData = array();
        return $arrData;
    }*/
    public function showEntryBox($id)
    {
        // echo " >>>>>>> ". $id; exit;
        $arrFields = $this->getSectionData();
        //showArrayValues($arrFields);
        $this->cateSubcatTable();
        //$category_tree=$this->cateSubcatTable();//Nested Menu
        //showArrayValues($var);//Nested Menu
        $arrData = array();
        if ($id == 0) {
            foreach ($arrFields as $val) {
                if ($val == 'ID') {
                    $arrData[$val] = 0;
                } else {
                    $arrData[$val] = '';
                }
            }
        } else {
            $this->db->select('*')
                ->from($this->dm__files) // ->from($this->dm__category)
                ->where('ID', $id);
            $recs = $this->db->get();
            if ($recs && $recs->num_rows()) {
                $rec = $recs->row();
                foreach ($arrFields as $val) {
                    $arrData[$val] = $rec->{$val};
                }
                $recs->free_result();
            }
            // $arrData['category_tree'] = $category_tree;            
        }
        //showArrayValues($arrData); exit;
        return $arrData;
    }
    /* public function section_pulldown($sectionId){
    $opt = '';
    $arrFields = $this->getFields($this->dm__sections);
    $this->db->select('*');
    $this->db->from($this->dm__sections);
    $this->db->where("STATUS !=",2);
    $recs = $this->db->get();
    //echo $this->db->last_query();
    $opt = '<option value="">Select Section</option>';
    foreach($recs->result() as $row ){
        $opt .= 
            '<option '. ($sectionId==$row->ID ? "selected ='selected'":"") .' value="'.$row->ID.'" title="'.$row->SECTION_NAME.' ('.$row->SECTION_NAME_HINDI.')">'.
        $row->SECTION_NAME.' ('.$row->SECTION_NAME_HINDI.') </option>';
    }
    return $opt;
}*/
    public function getOfficeIdbyUser($userId)
    {
        $rec = '';
        $this->db->select('OFFICE_ID');
        $this->db->from($this->tbl_user);
        $this->db->where('USER_ID', $userId);
        $recs = $this->db->get();
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row()->OFFICE_ID;
        }
        return $rec;
    }
    public function getcategoryItems($userId)
    {
        $rec = '';
        $this->db->select('CATEGORY_SELECTED_ALL');
        $this->db->from('dm__user_permission');
        //$this->db->where('USER_CLASS_ID',$userId); 26th April 2022
        $this->db->where('USER_ID', $userId); // 27th April 2022
        $recs = $this->db->get();
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row()->CATEGORY_SELECTED_ALL;
        }
        return $rec;
    }
    public function getUserbyclassId($userId)
    {
        $rec = '';
        $this->db->select('*');
        $this->db->from($this->tbl_user);
        $this->db->where('USER_ID', $userId);
        $recs = $this->db->get();
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row()->USER_CLASS_ID;
        }
        return $rec;
    }
    public function getUserPermission($userclassId)
    {
        $userPermission = '';
        $this->db->select('*');
        $this->db->from($this->dm__user_permission);
        $this->db->where('USER_CLASS_ID', $userclassId);
        $userPermission = $this->db->get();
        return $userPermission;
    }
    //////Get Permission By user ///
    public function getUserPermission_row($userclassId)
    {
        $userPermission = '';
        $this->db->select('*');
        $this->db->from($this->dm__user_permission);
        $this->db->where('USER_CLASS_ID', $userclassId);
        $userPermission = $this->db->get();
        return $userPermission->row_array();
    }

    public function section_pulldown($sectionId, $userclassId)
    {
        $opt = '';
        $arrFields = $this->getFields($this->dm__category);
        $userPermission = $this->getUserPermission($userclassId);
        //  print_r($userclassId);

        if ($userPermission && $userPermission->num_rows()) {
            $recUser = $userPermission->row();
            $selId = explode(',', $recUser->CATEGORY_SELECTED_EDIT);
            //showArrayValues($recUser->CATEGORY_SELECTED_EDIT);
            $this->db->select('*');
            $this->db->from($this->dm__category);
            $this->db->where(array('PARENT_CATE_ID' => 0, 'STATUS !=' => 2));
            $this->db->where_in('ID', $selId);
            $recs = $this->db->get();
            //echo $this->db->last_query();
            $opt = '<option value="">Select Section</option>';
            foreach ($recs->result() as $row) {
                $opt .= '<option ' . ($sectionId == $row->ID ? "selected ='selected'" : "") . ' value="' . $row->ID . '" 
                title="' . $row->CATEGORY_ENG . ' (' . $row->CATEGORY_HINDI . ')">' . $row->CATEGORY_ENG . ' (' . $row->CATEGORY_HINDI . ') </option>';
            }
        }
        return $opt;
        /*$this->db->select('*');
        $this->db->from($this->dm__category);
        $this->db->where(array('PARENT_CATE_ID'=>0,'STATUS !='=>2));
        $recs = $this->db->get();
        //echo $this->db->last_query();
        $opt = '<option value="">Select Section</option>';
        foreach($recs->result() as $row ){
            $opt .= 
                '<option '. ($sectionId==$row->ID? "selected ='selected'":"") .' value="'.$row->ID.'" title="'.$row->CATEGORY_ENG.' ('.$row->CATEGORY_HINDI.')">'.
            $row->CATEGORY_ENG.' ('.$row->CATEGORY_HINDI.') </option>';
        }
        return $opt;*/
    }

    function cateSubcatTable($parent = 0, $spacing = '&nbsp;&nbsp;', $user_tree_array = '')
    {
        $userclassId = $this->getUserbyclassId(getSessionDataByKey('USER_ID'));
        $userPermission = $this->getUserPermission($userclassId);

        //print_r($userPermission);

        $recUser = $userPermission->row();
        $selId = explode(',', $recUser->CATEGORY_SELECTED_ALL);

        if (!is_array($user_tree_array))

            $user_tree_array = array();
        // $recs = $this->db->select('*')
        // ->from($this->dm__category)
        // ->where_in(array('PARENT_CATE_ID'=>$parent))
        // ->where(array('PARENT_CATE_ID'=>$parent,"status"=>1))
        // ->order_by('ID','ASC')
        // ->get();
        $this->db->select('*');
        $this->db->from($this->dm__category);
        $this->db->where(array('PARENT_CATE_ID' => $parent, 'status ' => 1));
        $this->db->where_in('ID', $selId);
        $recs = $this->db->get();

        if ($recs && $recs->num_rows()) {
            foreach ($recs->result() as $rec) {

                $user_tree_array[] = array("id" => $rec->ID, "name" => $spacing . ' → ' . $rec->CATEGORY_ENG);
                $user_tree_array = $this->cateSubcatTable($rec->ID, $spacing . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $user_tree_array);
            }
            $recs->free_result();
        }
        return $user_tree_array;
    }

    /* Start Added on 27th April 2022*/
    public function getUserFilesSetting()
    {

        $this->db->select('*');
        $this->db->from('dm__filetype_master');
        $this->db->where('TYPE', "EXT");
        $q = $this->db->get();
        return $q->row_array();
    }
    /* End - 27th April 2022*/
    //old code
    /*function getCategory($SECTION_ID){
    $opt = '';
    $recs = $this->db->select('ID,CATEGORY_ENG,CATEGORY_HINDI')
            ->from($this->dm__category)
            ->where(array('SECTION_ID'=>$SECTION_ID,'CATEGORY_ID'=>0))
            ->order_by('ID','ASC')
            ->get();
    foreach($recs->result() as $rec){
        
        $opt .= '<option value="'.$rec->ID.'" title="'.$rec->CATEGORY_ENG.' ('.$rec->CATEGORY_HINDI.')">'.
        $rec->CATEGORY_ENG.' ('.$rec->CATEGORY_HINDI.') </option>';
    }
  return $opt;
}*/
    /////////24/07/22//




    public function section_pulldownCategory($sectionId, $userclassId)
    {
        $opt = '';
        $arrFields = $this->getFields($this->dm__category);
        $userPermission = $this->getUserPermission($userclassId);
        if ($userPermission && $userPermission->num_rows()) {
            $recUser = $userPermission->row();
            $selId = explode(',', $recUser->CATEGORY_SELECTED_ALL);
            $this->db->select('*');
            $this->db->from($this->dm__category);
            $this->db->where(array('PARENT_CATE_ID' => 0, 'STATUS !=' => 2));
            $this->db->where_in('ID', $selId);
            $recs = $this->db->get();
            //echo $this->db->last_query();
            $opt = '<option value="">Select Section</option>';
            foreach ($recs->result() as $row) {
                $opt .= '<option ' . ($sectionId == $row->ID ? "selected ='selected'" : "") . ' value="' . $row->ID . '" 
                title="' . $row->CATEGORY_ENG . ' (' . $row->CATEGORY_HINDI . ')">' . $row->CATEGORY_ENG . ' (' . $row->CATEGORY_HINDI . ') </option>';
            }
        }
        return $opt;
    }

    public function getWebsiteStatus($userId)
    {
        $this->db->from('dm__files_status');
        $recs = $this->db->get();
        $rec = [];
        if ($recs && $recs->num_rows()) {
            foreach ($recs->result() as $row) {
                $rec[$row->ID] = $row->STATUS_NAME;
            }
        }
        return $rec;
    }

    function getFileUploadedGrid($userId)
    {
        $objFilter = new clsFilterData();
        $objFilter->assignCommonPara($_POST);
        $selId = 0;
        $holdingPerson = getSessionDataByKey('HOLDING_PERSON');
        //$officeId = getSessionDataByKey('CURRENT_OFFICE_ID');
        $userclassId = $this->getUserbyclassId($userId);
        $officeId = $this->getOfficeIdbyUser($userId);
        $userPermission = $this->getUserPermission($userclassId);

        $selectedView = $this->getPublishedByUser($userId);
        $recUser = $userPermission->row();
        if ($recUser) {
            $selId = $recUser->CATEGORY_SELECTED_EDIT;
        }
        //        showArrayValues($recUser);
        $objFilter->SQL = 'SELECT file.*, sections.ID as SECTION_ID, sections.CATEGORY_ENG as SECTION_NAME,  category.CATEGORY_ENG
            FROM ' . $this->dm__files . ' file
            LEFT JOIN ' . $this->dm__category . ' sections ON sections.ID = file.SECTION_ID
            LEFT JOIN ' . $this->dm__category . ' category ON category.ID = file.CATEGORY_ID
            WHERE file.STATUS = 1
            ORDER BY file.ID DESC';
        $objFilter->executeMyQuery();
        //  echo $objFilter->PREPARED_SQL; //exit;
        $arr_accessLevel = array('1' => 'Public', '2' => 'Private', '3' => 'Both');
        if ($objFilter->RESULT) {
            foreach ($objFilter->RESULT as $row) {
                $fieldValues = array();
                array_push($fieldValues, '"' . addslashes($row->ID) . '"');
                array_push($fieldValues, '"' . addslashes(cleanDataForGrid($row->FILE_NAME_ENG)) . '"');
                array_push($fieldValues, '"' . addslashes($row->FILE_NAME_HINDI) . '"');
                array_push($fieldValues, '"' . addslashes($row->LETTER_NO) . '"');
                array_push($fieldValues, '"' . addslashes($row->LETTER_DATE) . '"');
                array_push($fieldValues, '"' . addslashes($row->SECTION_NAME) . '"');
                array_push($fieldValues, '"' . addslashes($row->CATEGORY_ENG) . '"');
                array_push($fieldValues, '"' . addslashes($arr_accessLevel[$row->ACCESS_LEVEL]) . '"');
                if (in_array($row->SECTION_ID, explode(",", $selectedView))) {
                    array_push($fieldValues, '"' . addslashes($this->showButton($row->ID, $row->STATUS)) . '"');
                } else {
                    array_push($fieldValues, '"' . addslashes('') . '"');
                }
                array_push($fieldValues, '"' . addslashes($this->formatDateTime($row->UPDATED_AT)) . '"');
                array_push($objFilter->ROWS, '{"id":"' . $row->ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }

    function formatDateTime($updatedAt)
    {
        // Get current time and the time of the updated post
        $currentTime = new DateTime();
        $postTime = new DateTime($updatedAt);

        // Calculate the time difference
        $interval = $currentTime->diff($postTime);

        // Convert the time difference into total minutes and hours
        $totalMinutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

        if ($totalMinutes < 60) {
            // If less than 1 hour, show minutes ago
            return $totalMinutes . ' minutes ago';
        } elseif ($totalMinutes < 1440) {
            // If less than 24 hours, show hours ago
            $hours = floor($totalMinutes / 60);
            return $hours . ' hours ago';
        } else {
            // If more than 24 hours, show the date and time
            return $postTime->format('F j, Y, H:i'); // e.g., "2024-06-17 14:30"
        }
    }
}
