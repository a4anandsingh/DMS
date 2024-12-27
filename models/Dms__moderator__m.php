<?php date_default_timezone_set('Asia/Kolkata');
class Dms__moderator__m extends CI_Model
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
        //        showArrayValues($recUser);
        $objFilter->SQL = 'SELECT file.*, sections.ID as SECTION_ID, sections.CATEGORY_ENG as SECTION_NAME,  category.CATEGORY_ENG
            FROM ' . $this->dm__files . ' file
            LEFT JOIN ' . $this->dm__category . ' sections ON sections.ID = file.SECTION_ID
            LEFT JOIN ' . $this->dm__category . ' category ON category.ID = file.CATEGORY_ID
            WHERE file.STATUS != 1
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

              //  array_push($fieldValues, '"' . addslashes(date('F j, Y', strtotime($row->UPDATED_AT))) . '"');
                array_push($fieldValues, '"' . addslashes($this->formatDateTime($row->UPDATED_AT)) . '"');

                array_push($objFilter->ROWS, '{"id":"' . $row->ID . '", "cell":[' . implode(',', $fieldValues) . ']}');
            }
        }
        return $objFilter->getJSONCodeByRow();
    }
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
    private function showButton($id, $status)
    {
        $fileStatus = $this->getWebsiteStatus(0);
        if (array_key_exists($status, $fileStatus)) {
            return getButton($fileStatus[$status], 'Active(1,' . $fileStatus[$status] . ')', 4, '');
        }
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

    public function Active($data)
    {
        return $this->db->update($this->dm__files, array('STATUS' => $data['STATUS']), array('ID' => $data['ID']));
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
    public function showEntryBox($id)
    {
        $arrFields = $this->getSectionData();
        // $colloumn = array("sections.CATEGORY_ENG as SECTION_NAME", "category.CATEGORY_ENG as CATEGORY_NAME");
        // $arrFields = array_merge($arrFields, $colloumn);

        // showArrayValues($arrFields);
        //        echo " >>>>>>> ". $id; exit;
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
            $this->db->select('dm__files.*, sections.CATEGORY_ENG as SECTION_NAME, category.CATEGORY_ENG as CATEGORY_NAME')->from($this->dm__files);
            $this->db->join('dm__category sections', 'sections ON sections.ID = dm__files.SECTION_ID', 'left');
            $this->db->join('dm__category category', 'category ON category.ID = dm__files.CATEGORY_ID', 'left');
            $this->db->where('dm__files.ID', $id);
            $recs = $this->db->get();
            $rec = $recs->row();
            $addCol = [];
            $addCol['SECTION_NAME'] = $rec->SECTION_NAME;
            $addCol['CATEGORY_NAME'] = $rec->CATEGORY_NAME;

            if ($recs && $recs->num_rows()) {
                foreach ($arrFields as $val) {
                    $fieldValues = array();
                    $arrData[$val] = $rec->{$val};
                }
                array_push($arrData, $addCol);

                $recs->free_result();
            }
        }
        // showArrayValues($arrData);
        //  exit;
        return $arrData;
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
    }

    public function getUserFilesSetting()
    {
        $this->db->select('*');
        $this->db->from('dm__filetype_master');
        $this->db->where('TYPE', "EXT");
        $q = $this->db->get();
        return $q->row_array();
    }
    public function getWebsiteStatus($userId)
    {
        /* 
        // Created by Pawan 10/12/2024 
        //  file publish in website status 
        */
        $rec = '';
        $this->db->select('*');
        /*   if ($this->session->USER_NAME != "misopt") {
            $this->db->where('PERMISSION',2);
        }
        if ($this->session->USER_NAME == "misopt") {
            $this->db->where('PERMISSION',1);
        } */

        $this->db->from('dm__files_status');
        $this->db->where('PERMISSION', 1);
        $recs = $this->db->get();
        $rec = [];
        if ($recs && $recs->num_rows()) {
            foreach ($recs->result() as $row) {
                $rec[$row->ID] = $row->STATUS_NAME;
            }
        }
        return $rec;
    }
    /*
        // Created by Pawan 10/12/2024 
        // This function insert data into dm__trigger__log to manage log 
    */
    function insertLog($tableName, $id, $old_value)
    {
        $log_data = [
            'UPDATED_TABLE_NAME' => $tableName,
            'OPERATION_TYPE' => 'UPDATE',
            'UPDATED_DATA_ID' => $id,
            'OLD_VALUE' => $old_value,
            'USER_IP' => $this->input->ip_address(),
            'USER_ID' => getSessionDataByKey('USER_ID'),
            'UPDATED_AT' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('dm__trigger__log', $log_data);
    }

    public function getSectionItemsById($id)
    {
        $rec = '';
        $this->db->select('CATEGORY_ENG');
        $this->db->where('ID', $id);
        $this->db->from('dm__category');
        $recs = $this->db->get();
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row()->CATEGORY_ENG;
        }
        echo $rec;
    }

    public function getCategoryItemsById($id)
    {
        $rec = '';
        $this->db->select('CATEGORY_ENG');
        $this->db->where('ID', $id);
        $this->db->from('dm__category');
        $recs = $this->db->get();
        if ($recs && $recs->num_rows()) {
            $rec = $recs->row()->CATEGORY_ENG;
        }
        echo $rec;
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

    private function showOption($id, $status)
    {
        $fileStatus = $this->getWebsiteStatus(0);

        /* 
        $opt = '<select><option value="">Select Section</option>';
        foreach ($fileStatus as $status)
        {
             $opt .= '<option value='.$status.' ' . ($status == $status ? "selected ='selected'" : "") . ' >'.$status.'</option>';
        }
      return  $opt .= ' </select>';

         exit; */


        if (array_key_exists($status, $fileStatus)) {
            return getButton($fileStatus[$status], 'setRowColor(1,' . $fileStatus[$status] . ')', 4, '');
        }
    }


    function formatDateTime($updatedAt) {
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
