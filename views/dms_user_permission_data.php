<!-- <//?php showArrayValues($selmenu); ?> -->
<style type="text/css">
 .k-checkbox input{
   display: block !important;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/kendo.default.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/kendo.common.min.css" />
<form id="menu_add" class="menu_add"  method="post">
    <input type="hidden" name="MENU_ID" id="menu_id" value="<?php if(isset($selmenu)) {echo $selmenu["MENU_ID"];} ?>">
    <fieldset><legend><strong>Menus</strong></legend>
    <table cellspacing="1" cellpadding="3" class="ui-widget-content" width="100%">
      <tr>
        <td class="ui-state-default">Menu name </td>
        <td class="ui-widget-content" colspan="3">
        <input type="text" name="menu_name" id="menu_name" size="44" title="MENU_NAME" value="<?php if(isset($selmenu)){echo $selmenu["MENU_NAME"] ;} ?>"/>
        </td>
    </tr>
    <tr>
        <td class="ui-state-default">Menu</td>
        <td class="ui-widget-content">
            <div class="k-header" id="menu_tree">
                <div id="treeview"></div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="ui-state-default">Status</td>
        <td class="ui-widget-content" colspan="3">
            <select class="form-control" name="status" id="status1" class="sel2" required>   
                <option value="">Select Menu Status</option>                             
                <option <?php if($selmenu["STATUS"]=="1"){echo "selected";}  ?> value="1">Active</option>
                <option <?php if($selmenu["STATUS"]=="0"){echo "selected";}  ?>  value="0">Inactive</option>
            </select>
        </td>
    </tr> 
        
        <td class="ui-state-default"> </td>                             
        <td class="ui-widget-content">                              
             <div id="" align="right" class="mysavebar">
                     <!-- <button id="btn_submit" type="submit" value="save" name="save" class="btn btn-primary">Save</button>
                     <button type="reset" value="Reset" class="btn btn-primary">Reset</button> -->
                     <?php echo getButton('Save ', "saveData(menu_add)", 4, 'cus-disk').'&nbsp;'.getButton('Reset ', "resetParams()", 4, 'cus-cancel').'&nbsp;'.getButton(' Cancel ', "closeDialog();", 4, 'cus-cancel');?>
                </div>
            </td>
    </table>
   <!--  <div id="mySaveDiv" align="right" class="mysavebar">
<//?php echo getButton(' Save ', "saveData()", 4, 'cus-disk').'&nbsp;'.
    /*getButton(' Reset ', "resetForm('menu_master_view')", 4, 'cus-cancel').'&nbsp;'.*/
    getButton(' Cancel ', "closeDialog();", 4, 'cus-cancel');?>
</div> -->
</fieldset>
</form>
</body>
</html>

<script type="text/javascript">
    $().ready(function() {
        $('.sel2').select2();
    });

    function saveData(){
    //alert($('.menu_add').serialize());exit();
        if($('.menu_add').valid()){
            var params = {
                'divid':'mySaveDiv',
                'url':'saveData',
                'data': $('.menu_add').serialize(),
                'donefname': 'doneSave',
                'failfname' :'',
                'alwaysfname':''
            };
            callMyAjax(params);
        }
    }
    function resetParams() {
    $('#menu_name').val('');
    $('#status1').val('');
    $('input[name=menu_tree]').attr('checked',true);
}
   function doneSave(response){
        $('#message').html(parseAndShowMyResponse(response));
        closeMyDialog("modalBox");
        //$('#myTable').trigger("reloadGrid");
        $('#menuMasterGrid').trigger("reloadGrid");
    }
</script>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/kendo.all.min.js"></script>
 <script>
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
	foreach ($va as $cc => $aa){ }
							?>
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
										<?php 
}} ?>
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
                        { <?php if ($parent == 'Dashboard') {
            ?>
                            id: "", text: "<?php echo $parent ?>", <?php echo 'check: "checked",';
            ?>  value: "<?php
            if (!is_array($v_parent)) {
                echo $v_parent;
            }
            ?>"
            <?php
        } else {
            ?>
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
        <?php }
        ?>
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
    </script>


    <script type="text/javascript">

                $(function () {
                    $("#treeview .k-checkbox input").eq(0).hide();
                    $('form').submit(function () {
                        $('#treeview :checkbox').each(function () {
                            if (this.indeterminate) {
                            this.checked = true;
                            }
                        });
                    })
                })
    </script>     