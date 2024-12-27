//Demand Entry Box
  public function showDEntryBox($id){  
    $ref = 0;
    $demand_type_id = 0;
    $arrFields = $this->getDemandFields();
    $arrData = array();
    $arr = array();
    if($id == 0){
      foreach($arrFields as $val){
        if($val == 'ID') {
          $arrData[$val] = 0;
        }else{
          $arrData[$val] = '';
        }
      }
      $arrData['BOTH_CHILD'] = 0;
      $arrData['STATUS'] = '';
      $arrData['CLICK'] = false;
      $refr_table = $this->demand_type;
      $condition = array('ID'=>$demand_type_id,'REF_ID'=>$ref,'ACTIVE !='=> 2);
      //$actual_data = $this->dropdown_type;
      //$cond1 = array('1' => 1,'TYPE'=> 'HEAD_TYPE'); 
      $actual_data = $this->head_type;
      $cond1 = array('1' => 1);
      $col = 'HEAD_TYPE';
      $col1 = 'PARENT_ID';
      $arrData['PARENT_ID'] = $this->DropDownValues($refr_table,$condition,$actual_data,$cond1,$col,$col1);
    }else{
      $ref_table = $this->demand_type;
      $cond = array('ID'=> $id);
      $act_table = $this->demand;
      $column = 'REF_ID';
      $arrData = $this->EntryBoxValues($ref_table,$cond,$act_table,$column,$arrFields); 
      $ref = $arrData['ID'];
      $arrData['ID'] = $id;
      $demand_type_id = $id;
      $refr_table = $this->demand;
      $condition = array('ID'=>$ref,'ACTIVE !='=> 2);
      $actual_table = $this->budget_type;
      $col = 'BUDGET_TYPE';
      $col1 = 'BUDGET_NONBUDGET';
      $cond2 = array('1' => 1);
      $arrData['BUDGET_NONBUDGET'] = $this->GetValueByEditMode($refr_table,$condition,$actual_table,$cond2,$col,$col1);
      $this->db->select('*');
      $this->db->from($this->demand_type);
      $this->db->where(array('ID ='=>$id,'ACTIVE !='=>2));
      $recs = $this->db->get();
      if($recs){
        $return1 = $this->checkEdited($recs->row()->ID,$this->major_demand);
        $return2 = $this->checkEdited($recs->row()->ID,$this->segment_demand);
        $return2 = $this->checkEdited($recs->row()->ID,$this->scheme_demand);
        if($return1 == '' && $return2 == ''){
          $arrData['BOTH_CHILD'] = 0;
          $arrData['STATUS'] = '';
          $arrData['CLICK'] = true;
        }else{
          $arrData['BOTH_CHILD'] = 1;
          $arrData['STATUS'] = "This Demand Head are Already Linked With Another Head.";
          $arrData['CLICK'] = true;
        }
      }
      $this->db->select('*');
      $this->db->from($this->demand_type);
      $this->db->where(array('REF_ID'=>$ref,'ACTIVE !='=>2));
      $r = $this->db->get();
      if($r->num_rows() >1){
        foreach($r->result() as $key){
          if($demand_type_id == $key->ID){
          }else{
            array_push($arr,$key->PARENT_ID);
          }
        }
      }else{
        array_push($arr,'NULL');
      }
      $refr_table = $this->demand_type;
      $condition = array('ID'=>$demand_type_id,'REF_ID'=>$ref,'ACTIVE !='=>2);
      //$actual_data = $this->dropdown_type;
      //$cond1 = array('1' => 1,'TYPE'=> 'HEAD_TYPE'); 
      $actual_data = $this->head_type;
      $cond1 = array('1' => 1);
      $col = 'HEAD_TYPE';
      $col1 = 'PARENT_ID';
      $arrData['PARENT_ID'] = $this->DropDownValues($refr_table,$condition,$actual_data,$cond1,$col,$col1,$arr);
    }
      $refr_table = $this->demand;
      $condition = array('ID'=>$ref,'ACTIVE !='=>2);
      //$actual_data = $this->dropdown_type;
      $actual_data = $this->budget_type;
      $col = 'BUDGET_TYPE';
      $col1 = 'BUDGET_NONBUDGET';
      $cond2 = array('1' => 1);
      //$cond2 = array('1' => 1,'TYPE'=> 'BUDGET_NONBUDGET');
      $opt = '<option value="">Select</option>';
      $arrData['BUDGET_NONBUDGET'] = $this->DropDownValues($refr_table,$condition,$actual_data,$cond2,$col,$col1,$opt);
    return $arrData;
  }