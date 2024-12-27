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
       <!--  <tr>
            <td align="left" class="ui-widget-content">
                button type="button" class="btn btn-primary" id='filetype'>Allow New FileType</button>
                <button type="button" class="btn btn-danger"id='newcategory' >Add New Category</button>
                <button type="button" class="btn btn-secondary" >Upload File</button>
            </td>
        </tr> -->
       <!--  <tr>
            <td align="left" class="ui-widget-content">
                
            </td>
        </tr> -->
        <tr>
            <td align="center" class="ui-widget-content">
                <div style="width:100%;float:left;padding-bottom:5px;padding-top:5px" align="center">
                    <table id="Grid"></table>
                    <div id="GridPager"></div>
                </div>
            </td>
        </tr>
    </table>
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
    $('#filetype').on('click',function(){
        showModalBox('modalBox', 'showEntryBox', '', 'Allow New FileType', 'showData', true);
    });
    function showData(msg){
        $('#modalBox').html(msg);
        $("#modalBox" ).dialog( "option", "width", 500);
        centerDialog('modalBox');
    } 
    function Operation(mode, ptype){
        var gridName = '#Grid';
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
        title = ((id==0) ? 'Add New File Permission' : 'Edit Data');
        showModalBox('modalBox', 'showEntryBox', data, title, 'showData', true);
    }
</script>