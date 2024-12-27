<?php $baseURL = base_url(); ?>
<title>DMS</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>js/fancybox/fancybox.css" />
<style>
    .fancybox__content {
        height: 100% !important;
        /* Overwrite Fancy box height */
    }
</style>
<script type="text/javascript" src="<?php echo base_url(); ?>js/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind("[data-fancybox]", {
        iframe: {
            preload: false, // Disable iframe preloading
            css: {
                width: "100%",
                height: "90%",
            },
        },
    });
</script>
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
            <td align="left" class="ui-widget-content">
                <!-- <button type="button" class="btn btn-primary" id='newsection'>Add New Section</button> -->
                <button type="button" class="btn btn-danger" id='newFileUpload'>Upload New File</button>
                <!-- <button type="button" class="btn btn-secondary" >Upload File</button> -->
            </td>
        </tr>
        <tr>
            <td align="left" class="ui-widget-content">

            </td>
        </tr>
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
        <?php //echo $page_heading; 
        ?>
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
        $("#modalBox").dialog("option", "width", 700);
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
            'userId': <?php echo $userId; ?>
        };
        title = ((id == 0) ? 'Upload New Document' : 'Edit Data');
        showModalBox('modalBox', 'showEntryBox', data, title, 'showData', true);
    }

    function getDialogData(id) {
        data = {
            'id': id,
            'userId': <?php echo $userId; ?>,
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
</script>