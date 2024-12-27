<?php $baseURL = base_url();?>
<title>DMS</title>
<div id="content_wrapper">
    <div id="page_heading">
        <?php echo $page_heading;?>
    </div>
    <div style="width:100%;float:left">
        <div id="messagebox" class="messagebox"></div>
    </div>
    <div style="width:100%;float:left">
        <?php echo getMessageBox('message', ''); ?>
    </div>
    <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1" style="margin-bottom:9px">
        <tr>
            <td align="left" class="ui-widget-content">
                <button type="button" class="btn btn-primary" id='menu_add' onclick="add_menu(0);">Create New Menu</button>
            </td>
        </tr>
        <tr>
            <table id="myTable">
  <!-- <tr class="header">
    <th style="width:20%;">Menu Name</th>
    <th style="width:60%;">List</th> 
    <th style="width:20%;">Status</th>
    <th style="width:20%;">Action</th>
  </tr> -->

  <?php foreach($menu_list as $menu){?>

  <tr>
    <!-- <td><?php echo $menu["MENU_NAME"];?></td> -->
   <!--  <td><?php 
    $cat_ids =explode(",",$menu["MENU_SELECTED"]);
    //showArrayValues($cat_ids);
     //for($i=0;$i<=count($cat_ids);$i++){
        
    $cat_name = $this->Dms__menu__m->get_categoryBYID($cat_ids);
    echo $cat_name;
    //echo $cat_name["CATEGORY_ENG"] .',';
     //}
    ?>
    </td> -->  
    <!-- <td>
    <?php if($menu["STATUS"]=="1"){
        
        echo "Active";
  }else{ echo "inactive";}?>
    </td> -->
    <!-- <td>
        <button id="EDIT_MENU" class="btn btn-danger" onclick="edit_menu(<?php echo $menu["MENU_ID"];?>)">EDIT</button>
    </td> -->
    <!-- <td><a href="<?php echo base_url();?>dms/Dms_menu_c/menu_edit/<?php echo $menu["MENU_ID"];?>">Edit</a>
      <a  onclick="return confirm('are you sure ?')"  href="<?php echo base_url('dms/del_menu/'.$menu['MENU_ID']); ?>" class="btn btn-danger">Delete</a>   
    
    </td> -->
  </tr>
  <?php }?>
</table>
        </tr>
    </table>
    <tr>
        <td align="center" class="ui-widget-content">
            <div style="width:99%;float:left;padding-bottom:5px;padding-top:5px" align="center">
                <table id="menuMasterGrid"></table>
                <div id="menuMasterGridPager"></div>
            </div>
        </td>
    </tr>
    <tr>
        <td align="center" class="ui-widget-content">
            <div style="width:99%;float:left;padding-bottom:5px;padding-top:5px" align="center">
                <table id="userClassGrid"></table>
                <div id="userClassGridPager"></div>
            </div>
        </td>
    </tr>
    <div id='modal'></div>
</div>

<script type="text/javascript">
    $().ready(function() {
        //$('.sel2').select2();
        jqGrid_Projects();
    });
    function jqGrid_Projects(){
        <?php echo $grid; ?>
    }
    $('#newmenu').on('click',function(){
        showModalBox('modalBox', 'showMenuData', '', 'Create New Menu', 'showData', true);
    });

    /*$('#menu_add').on('click',function(){
        showModalBox('modalBox', 'menu_add', '', 'Add New Menu', 'showData', true);
    });*/
    function add_menu(id){
        data = {'id': id};
        title = ((id==0) ? 'Add Menu' : 'Edit Menu');
        showModalBox('modalBox', 'menu_add', data, title, 'showData', true);
    }
    /*
    function edit_menu(id){
        data = {'id': id};
        title = 'Edit Menu';
        showModalBox('modalBox', 'menu_edit', data, title, 'showData', true);
    }*/
    
    function Operation(mode, ptype){
        var gridName = '#menuMasterGrid';
        if(mode == BUTTON_DELETE){
            id = $(gridName).getGridParam("selrow");
            if(id > 0){
                var ans = confirm('Are you sure to Delete this Project ?');
                if(!ans){
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: 'deleteData',
                    data: {id: id},
                    donefname: 'doneDelete',
                    success: function (response) {
                        alert(response);
                        $(gridName).trigger('reloadGrid');
                        $('#message').html(parseAndShowMyResponse(response));
                    }
                });
            }else{
                showAlert("Error","Please Select Row To Delete", 'error');
            }
        }else{
            if(mode == BUTTON_ADD_NEW){
                getDialog(0);
            }else{
                var id = $(gridName).getGridParam("selrow");
                //alert(id);
                if(id > 0){
                    getDialog(id);
                }else{
                    showAlert("Error", "Please Select Row To Edit", 'error');
                }
            }
        }
    }
    
    function getDialog(id) {
        data = {'id': id};
        title = ((id==0) ? 'Add New Data' : 'Edit Data');
        //showModalBox('modalBox', 'showEntryBox', data, title, 'showData', true);
        add_menu(id);
    }
    function operationUser(mode, ptype){
        var gridName = '#userClassGrid';
        if(mode == BUTTON_DELETE){
            id = $(gridName).getGridParam("selrow");
            //alert(id);
            if(id > 0){
                var ans = confirm('Are you sure to Delete this Project ?');
                if(!ans){
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: 'deleteData',
                    data: {id: id},
                    donefname: 'doneDelete',
                    success: function (response) {
                        alert(response);
                        $(gridName).trigger('reloadGrid');
                        $('#message').html(parseAndShowMyResponse(response));
                    }
                });
            }else{
                showAlert("Error","Please Select Row To Delete", 'error');
            }
        }else{
            if(mode == BUTTON_ADD_NEW){
                getUserDialog(0);
            }else{
                var id = $(gridName).getGridParam("selrow");
                //alert(id);
                if(id > 0){
                    getUserDialog(id);
                }else{
                    showAlert("Error", "Please Select Row To Edit", 'error');
                }
            }
        }
    }
    function getUserDialog(id) {
        data = {'USER_CLASS_ID': id, 'USER_ID':id};
        title = ((id==0) ? 'Add New User Rights' : 'Edit User Rights');
        showModalBox('modalBox', 'showUserEntryBox', data, title, 'showData', true);
    }
    function showData(msg){
        $('#modalBox').html(msg);
        $("#modalBox" ).dialog( "option", "width", 1000);
        centerDialog('modalBox');
    } 
    //status code
    function Active(status,id){
        $.ajax({
        type:"POST",
        url:'Active',
        data:{ID:id,STATUS:status},
        success:function(response){
            $('#menuMasterGrid').trigger("reloadGrid");         
        }
        });
    }
</script>