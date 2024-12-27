<?php $baseURL = base_url(); ?>
<title>DMS- Moderator</title>
<div id="content_wrapper">
    <div id="page_heading">
        <?php echo $page_heading; ?>
    </div>
    <div style="width:100%;float:left">
        <div id="messagebox" class="messagebox"></div>
    </div>
    <div style="width:100%;float:left">
        <?php echo getMessageBox('message', ''); ?>
    </div>
    <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1" style="margin-bottom:9px">
        <tr>
            <td align="center" class="ui-widget-content">
                <div style="width:100%;float:left;padding-bottom:5px;padding-top:5px" align="center">
                    <table id="fileUploadGrid"></table>
                    <div id="fileUploadGridPager"></div>
                </div>
            </td>
        </tr>
    </table>
    <div id='modal'></div>
</div>
<!-- 
Added this grid to view published files in website
-->
<hr>
<div id="content_wrapper">
   <!--  <div id="page_heading">
        <?php //echo $page_heading; ?>
    </div> -->
    <table width="100%" border="0" cellpadding="3" class="ui-widget-content" cellspacing="1" style="margin-bottom:9px">
        <tr>
            <td align="center" class="ui-widget-content">
                <div style="width:100%;float:left;padding-bottom:5px;padding-top:5px" align="center">
                    <table id="fileUploadedGrid"></table>
                    <div id="fileUploadedGridPager"></div>
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

    function jqGrid_Projects() {
        <?php echo $grid; ?>
        <?php echo $gridPublished; ?>
        setRowColor();
    }
    $('#newFileUpload').on('click', function() {
        data = {
            'id': 0,
            'userId': <?php echo $userId; ?>
        };
        showModalBox('modalBox', 'showEntryBox', data, 'New File Upload Section', 'showData', true);
    });

    function showData(msg) {
        $('#modalBox').html(msg);
        $("#modalBox").dialog("option", "width", 500);
        centerDialog('modalBox');
    }

    function Operation(mode, ptype) {
        var gridName = '#fileUploadGrid';
        if (mode == BUTTON_DELETE) {
            id = $(gridName).getGridParam("selrow");
            if (id > 0) {
                var ans = confirm('Are you sure to Delete this Project ?');
                if (!ans) {
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: 'deleteData',
                    data: {
                        id: id
                    },
                    donefname: 'doneDelete',
                    success: function(response) {
                        alert(response);
                        $(gridName).trigger('reloadGrid');
                        $('#message').html(parseAndShowMyResponse(response));
                    }
                });
            } else {
                showAlert("Error", "Please Select Row To Delete", 'error');
            }
        } else {
            if (mode == BUTTON_ADD_NEW) {
                getDialog(0);
            } else {
                var id = $('#fileUploadGrid').getGridParam("selrow");
                //alert(id);
                if (id > 0) {
                    getDialog(id);
                } else {
                    showAlert("Error", "Please Select Row To Edit", 'error');
                }
            }
        }
    }

    function OperationPublished() {
        var id = $('#fileUploadedGrid').getGridParam("selrow");
        if (id > 0) {
            getDialogData(id);
        } else {
            showAlert("Error", "Sorry! You have not access to update after published in website", 'error');
        }
    }

    function getDialog(id) {
        data = {
            'id': id,
            'userId': <?php echo $userId; ?>,
        };
        title = ((id == 0) ? 'Upload New Document' : 'View Data');
        showModalBox('modalBox', 'showEntryBox', data, title, 'showData', true);
    }

    function getDialogData(id) {
        data = {
            'id': id,
            'userId': <?php echo $userId; ?>,
            //'reqStatus':'PUBLISHED'
            'reqStatus': '<?php echo md5("PUBLISHED"); ?>'
        };
        title = ((id == 0) ? 'Upload New Document' : 'View Data');
        showModalBox('modalBox', 'showEntryBox', data, title, 'showData', true);
    }

    function Active(status, id) {
        $.ajax({
            type: "POST",
            url: 'Active',
            data: {
                id: id,
                status: status
            },
            success: function(response) {
                $('#fileUploadGrid').trigger("reloadGrid");
            }
        });
    }

    function setRowColor() {

        // Select all rows in the table
        const rows = document.querySelectorAll('tr');
        rows.forEach(row => {
            console.log(row.hasAttribute('title'));
            // Check if the row has a title attribute
            if (row.hasAttribute('title')) {
                // Get the value of the title attribute
                const title = row.getAttribute('title');
                console.log(`Row title: ${title}`);
            }
        });


    }
</script>