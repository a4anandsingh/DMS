<style type="text/css">
 .k-checkbox input{
   display: block !important;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/kendo.default.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/kendo.common.min.css" />
<form name="frmUserClass" id="frmUserClass" onsubmit="return false;">
	<input type="hidden" id="USER_CLASS_ID" name="USER_CLASS_ID" value="<?php echo $arrFieldValues['USER_CLASS_ID'];?>" />
	<input type="hidden" id="PERMIT_ID" name="PERMIT_ID" value="<?php if(isset($selmenu)) {echo $selmenu["PERMIT_ID"];} ?>" />
	<input type="hidden" id="USER_CLASS_NAME" name="USER_CLASS_NAME" value="<?php echo $arrFieldValues['USER_CLASS_NAME'];?>" />
	<input type="hidden" id="PUBLISHED" name="PUBLISHED" value="<?php echo $arrFieldValues['PUBLISHED'];?>" />
    <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1">
     <tr>
            <td class="ui-state-default" nowrap="nowrap"><strong>User Class : <?php echo getRequiredSign('right');?></strong></td>
            <td class="ui-widget-content">
            	<strong><?php echo $arrFieldValues['USER_CLASS_NAME'];?></strong>
            </td>
            <td class="ui-state-default"><strong>Published :</strong></td>
            <td class="ui-widget-content">
            	<strong><?php echo ($arrFieldValues['PUBLISHED']==1)? 'YES':'NO' ;?></strong>
            </td>
        </tr>
     </table>
     
	<fieldset><legend><strong>Permissions</strong></legend>
	<div id="user_class_tabs">
        <ul>
            <li><a href="#user_class_tab_1">Category</a></li>
            <li><a href="#user_class_tab_2">Category Access Level</a></li>
        </ul>
        <div id="user_class_tab_1">
	        <fieldset>
	        	<strong>Category Selection :</strong>
			</fieldset>
			<div class="k-header" id="menu_tree">
	            <div id="treeview"></div>
	        </div>
        </div>
        <div id="user_class_tab_2">
        <fieldset>
	        <strong>Access Level Selection : </strong>
		</fieldset>
        <div>
        	<!-- <div class="k-header" id="menu_tree">
	            <div id="accesstreeview"></div>
	        </div> -->
           <?php //showArrayValues($results);
           
           	//for($i=0; $i<count($results); $i++){ 
           //showArrayValues($results);
           if($results)
           	$tabl = '<table width="90%" align="center" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1">
        		<thead>
        		<th class="ui-state-default" align="center">S.no.</th>
        		<th class="ui-state-default" align="center">Category</th>
        		<th class="ui-state-default" align="center" colspan="3">Permission</th>
				<tr>';
		      	$i = 1;
		      	$categoryEdit = explode(",",$selmenu['CATEGORY_SELECTED_EDIT']);
		      	$categoryPublish = explode(",",$selmenu['CATEGORY_SELECTED_VIEW']);
           		foreach($results[0] as $val){
           			//showArrayValues($categoryEdit);
           			//<td class="ui-widget-content" align="center"> <input type="checkbox" id="both_'.$val->ID.'"  name="both" value="1" onClick="checkall('.$val->ID.')" > Both </td>
        			$tabl.= '<td class="ui-widget-content" align="center">'.$i.'</td>
        			<td class="ui-widget-content" align="center">'.$val->CATEGORY_ENG.'</td> 
			        <td class="ui-widget-content" align="center"> 
			        	<input '.((in_array($val->ID, $categoryEdit))  ? 'checked = "checked"':'') .'type="checkbox" class="case_'.$val->ID.'" id="edit_'.$val->ID.'" name="edit[]" value="'.$val->ID.'"> Add / Edit / Upload</td>
		        	<td class="ui-widget-content" align="center"><input '.((in_array($val->ID, $categoryPublish))  ? 'checked = "checked"':'') .'type="checkbox" class="case_'.$val->ID.'" id="view_'.$val->ID.'" name="view[]" value="'.$val->ID.'"> Publish Rights</td>
			        </tr>';
        			$i++; 
        		}
        		$tabl.='</table>';
        		echo $tabl;
      
        	/*$tabl = '<table width="90%" align="center" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1">
        		<thead>
        		<th class="ui-state-default" align="center">S.no.</th>
        		<th class="ui-state-default" align="center">Category</th>
        		<th class="ui-state-default" align="center" colspan="3">Permission</th>
				<tr>';
		      	$i = 1;
        		foreach($results as $key => $val){
        			$tabl.= '<td class="ui-widget-content" align="center">'.$i.'</td>
        			<td class="ui-widget-content" align="center">'. $key.'</td> 
		        <td class="ui-widget-content" align="center"> <input type="checkbox" id="" name=""> Both </td>
		        <td class="ui-widget-content" align="center"> <input type="checkbox" id="" name=""> Edit</td>
		        <td class="ui-widget-content" align="center"> <input type="checkbox" id="" name=""> View</td>
		        </tr>';
        			$i++; 
        		}
        		$tabl.='</table>';
        		echo $tabl;*/
        	?>
        	<?php //echo form_checkbox("feature_iui","1", set_checkbox("feature_iui","1", $article->feature_iui)); ?>
        </div>
        
        </div>
    </div>
    </fieldset>
<div id="mySaveDiv" align="right" class="mysavebar">
<?php echo getButton(' Save ', "saveData()", 4, 'cus-disk').'&nbsp;'.
	getButton(' Cancel ', "closeDialog();", 4, 'cus-cancel');?>
     </div>
</form>
<script type="text/javascript" language="javascript">
$().ready(function(){
	$("#user_class_tabs").tabs();
	$("#accMenus").accordion({width:500, heightStyle: "content", navigation: false});
	$("#accModules").accordion({width:500, heightStyle: "content", navigation: false});
	setShowHide('accMenus', <?php echo $MENU_OPTION;?>);
	setShowHide('accModules', <?php echo $MODULE_OPTION;?>);
	$(".chosen-select").select2();
	//$(".chosen-select").select2();
	getToolTips();
	setSelect2();
	/*$("#frmUserClass").validationEngine({
		/*promptPosition : "topCenter",
		scroll: false,
		prettySelect: true, 
		usePrefix: 's2id_', 
		autoPositionUpdate: true,
		promptPosition : 'topLeft'
		//checkbox code for Edit mode.//
		<td class="ui-widget-content" align="center"> 
			        	<input <//?php echo $categoryEdit['.$i.']=='.$val->ID.') ? "":""
			        	type="checkbox" class="case_'.$val->ID.'" id="edit_'.$val->ID.'" name="edit[]" value="'.$val->ID.'" ($categoryEdit == '.$val->ID.' ? "checked" : "") > Edit</td>
	  //checkbox code for Edit mode.//
	});*/
	validator = 
	$("#frmUserClass").validate({
		rules: {"USER_CLASS_NAME" : {required : true}},
		messages: {"USER_CLASS_NAME" : {required : "User Class Name is Required"}}
	});
	<?php for($i=0; $i<count($menu_tree); $i++){ 
			echo "$('#tree".$menu_tree[$i]['MENU_ID']."').tree({
					onCheck: { ancestors: 'check', descendants: 'check' }, 
					onUncheck: { ancestors: 'uncheckIfEmpty', descendants: 'uncheck'}, leafUiIcon: 'ui-icon ui-icon-document-b'
					});\n";
       	}
	?>
});
/***/
function setShowHide(id, mValue){
	if (mValue==2){
		$('#'+id).show();
	}else{
		$('#'+id).hide();
	}
}
/**OK*/
function saveData(){
	
	
	var myValidation = $("#frmUserClass").valid();
	if(!myValidation){
			alert('You have : ' + ( validator.numberOfInvalids() ) + ' errors in this form.');
			//alert('Please Check Errors');
		return ;
	}
	if(myValidation){
		var mydata = $('#frmUserClass').serialize();
		var params = {'divid':'mySaveDiv', 'url':'saveUserClass', 'data':mydata, 
			'donefname': 'doneProject', 'failfname' :'', 'alwaysfname':''};
		callMyAjax(params);
	}else{
		showMyAlert('Error...', 'There is/are some Required Data... <br />Please Check & Complete it.', 'warn');
		//alert('There is/are some Required Data... ' + "\n Please Check & Complete it." );
	}
}
/** OK on 15-10-2013 */
function doneProject(response){
	showAlert('message',parseAndShowMyResponse(response),'');
	$('#message').html( parseAndShowMyResponse(response) );
	$("#userClassGrid").trigger('reloadGrid');
	$("#modalBox").dialog('close');
}
/**OK*/
function afterEntryBox(data){
	$('#modalBox').html(data);
	centerDialog('modalBox');
}
</script>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/kendo.all.min.js"></script>

<script>
	$(function () {
        $("#treeview .k-checkbox input").eq(0).hide();
        $('form').submit(function () {
            $('#treeview :checkbox').each(function () {
                if (this.indeterminate) {
                this.checked = true;
                }
            });
        });
    });
   jQuery("#treeview").kendoTreeView({
        checkboxes: {
        checkChildren: true,
        template: "<input type='checkbox' #= item.check# name='menu[]' value='#= item.value #'  />"
        },
        check: onCheck,
        dataSource: [
<?php foreach ($result as $parent => $v_parent): ?>
    <?php if (is_array($v_parent)): ?>
        <?php foreach ($v_parent as $parent_id => $v_child): ?>
            {
            id: "", text: "<?php echo $parent; ?>",<?php
            if (!empty($roll[$parent_id])) {
				
              echo $roll[$parent_id] ? 'check: "checked",' : '';
            }?> value: "<?php
            if (!empty($parent_id)) {
                echo $parent_id;
            }
            ?>", expanded: true, items: [
            <?php foreach ($v_child as $child => $v_sub_child) : ?>
                <?php if (is_array($v_sub_child)): ?>
                    <?php foreach ($v_sub_child as $sub_chld => $v_sub_chld): ?>
                        {
                        id: "", text: "<?php echo $child; ?>", value: "<?php
                        if (!empty($sub_chld) && !is_array($sub_chld)) {
                            echo $sub_chld;
                        }
                        ?>", expanded: true, items: [
                        <?php foreach ($v_sub_chld as $sub_chld_name => $sub_chld_id){ ?>
                            {
                            id: "", text: "<?php echo $sub_chld_name; ?>",<?php
                            if (!empty($roll[$sub_chld_id])) {
								
                               echo $roll[$sub_chld_id] ? 'check: "checked",' : 'checked';
                            }
							foreach ($sub_chld_id as $sub_chld_namecc => $sub_chld_idcv){ }
                            ?> value: "<?php
                            if (!empty($sub_chld_id) && !is_array($sub_chld_id)) {
                                echo $sub_chld_id."";
                            }elseif(!empty($sub_chld_id)){
								
							echo $sub_chld_namecc."";	
							}
                            ?>", expanded: true, items: [
                        <?php foreach ($sub_chld_id as $sub_chld_namec => $sub_chld_idc){
								foreach($sub_chld_idc as $valc=>$va){
									foreach ($va as $cc => $aa){ } ?>
                                    {
                                    id: "", text: "<?php echo $valc; ?>",<?php
			                            if (!empty($roll) && !is_array($va)) {
			                               echo $roll[$va] ? 'check: "checked",' : '';
			                            }else{
										   echo $roll[$cc] ? 'check: "checked",' : '';	
										}
										
			                            ?> value: "<?php
			                            if (!empty($va) && !is_array($va)) {
			                               echo $va."";
			                            }else{
											echo $cc;
										}
			                            ?>",
                                    },
						<?php }} ?>
                        ]
                        },
		<?php } ?>
            ]
        },
    <?php endforeach; ?>
    <?php else: ?>
    {
    id: "", text: "<?php echo $child; ?>", <?php
    if (!is_array($v_sub_child)) {
        if (!empty($roll[$v_sub_child])) {
            echo $roll[$v_sub_child] ? 'check: "checked",' : 'checked';
        }
    }
    ?> value: "<?php
    if (!empty($v_sub_child)) {
        echo $v_sub_child;
    }
    ?>",
     },
    <?php endif; ?>
    <?php endforeach; ?>
        ]
        },
    <?php endforeach; ?>
    <?php else: ?>
        { <?php if ($parent == 'Dashboard') { ?>
            id: "", text: "<?php echo $parent ?>", <?php echo 'check: "checked",'; ?>  
            value: "<?php
            if (!is_array($v_parent)) {
                echo $v_parent;
            }
            ?>"
        <?php } else { ?>
        id: "", text: "<?php echo $parent ?>", <?php
            if (!is_array($v_parent)) {
                if (!empty($roll[$v_parent])) {
                    echo $roll[$v_parent] ? 'check: "checked",' : 'checked';
                }
            }
            ?> value: "<?php
            if (!is_array($v_parent)) {
                echo $v_parent;
            }
            ?>"
        <?php } ?>
        },
    <?php endif; ?>
<?php endforeach; ?>
    ]
    });
    // show checked node IDs on datasource change
    function onCheck() {
    var checkedNodes = [],
            treeView = $("#treeview").data("kendoTreeView"),
            message;
            checkedNodeIds(treeView.dataSource.view(), checkedNodes);
            $("#result").html(message);
    }
/**/
function checkall(mode){

	alert($(".case_"+mode+":checked").length);
	if($(".case_"+mode).length == $(".case_"+mode+":checked").length) {
		alert('aaaa');
		//$("#selectall").attr("checked", "checked");
		$("#edit_"+mode).attr("checked", "checked");
		$("#view_"+mode).attr("checked", "checked");
	} else {
		alert('bbb');
		//$("#selectall").removeAttr("checked");
		$("#edit_"+mode).removeAttr("checked");
		$("#view_"+mode).removeAttr("checked");
	}
}

</script>